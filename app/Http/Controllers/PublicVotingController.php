<?php

namespace App\Http\Controllers;

use App\Models\Ballot;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\Voter;
use App\Services\RsaVoteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PublicVotingController extends Controller
{
    public function index(): View
    {
        return view('public.index', [
            'election' => Election::withCount(['candidates', 'ballots'])->first(),
        ]);
    }

    public function lookup(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'identity_number' => ['required', 'string', 'max:40'],
        ]);

        $voter = Voter::where('identity_number', strtoupper(trim($data['identity_number'])))->first();

        if (! $voter) {
            return back()->withErrors(['identity_number' => 'NIK/NIM tidak terdaftar sebagai pemilih.'])->withInput();
        }

        if ($voter->has_voted) {
            return back()->withErrors(['identity_number' => 'Anda sudah menggunakan hak pilih.'])->withInput();
        }

        session(['voter_id' => $voter->id]);

        return redirect()->route('vote.show');
    }

    public function show(): View|RedirectResponse
    {
        $voter = $this->currentVoter();
        $election = Election::with('candidates')->first();

        if (! $voter || ! $election) {
            return redirect()->route('home');
        }

        return view('public.vote', compact('voter', 'election'));
    }

    public function submit(Request $request, RsaVoteService $rsa): RedirectResponse
    {
        $voter = $this->currentVoter();

        if (! $voter) {
            return redirect()->route('home');
        }

        $data = $request->validate([
            'candidate_id' => ['required', 'integer', 'exists:candidates,id'],
        ]);

        $election = Election::with('rsaKey')->firstOrFail();
        $candidate = Candidate::where('election_id', $election->id)->findOrFail($data['candidate_id']);

        if (! $election->isOpen()) {
            return back()->withErrors(['candidate_id' => 'Pemilihan sudah ditutup.']);
        }

        DB::transaction(function () use ($voter, $candidate, $election, $rsa): void {
            $lockedVoter = Voter::whereKey($voter->id)->lockForUpdate()->firstOrFail();

            if ($lockedVoter->has_voted) {
                abort(409, 'Hak pilih sudah digunakan.');
            }

            $anonymousToken = bin2hex(random_bytes(32));
            $anonymousTokenHash = hash('sha256', $anonymousToken);
            $encryptedVote = $rsa->encryptCandidateId($candidate->id, $election->rsaKey->public_key);

            Ballot::create([
                'election_id' => $election->id,
                'anonymous_token_hash' => $anonymousTokenHash,
                'encrypted_vote' => $encryptedVote,
                'integrity_hash' => $rsa->integrityHash($anonymousTokenHash, $encryptedVote),
                'cast_at' => now(),
            ]);

            $lockedVoter->update([
                'has_voted' => true,
                'voted_at' => now(),
            ]);
        });

        session()->forget('voter_id');

        return redirect()->route('vote.success');
    }

    public function success(): View
    {
        return view('public.success');
    }

    private function currentVoter(): ?Voter
    {
        $id = session('voter_id');

        return $id ? Voter::find($id) : null;
    }
}
