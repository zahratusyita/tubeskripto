<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Ballot;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\Voter;
use App\Services\RsaVoteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $election = Election::withCount(['candidates', 'ballots'])->firstOrFail();
        $totalVoters = Voter::count();
        $votedCount = Voter::where('has_voted', true)->count();
        $notVotedCount = Voter::where('has_voted', false)->count();

        return view('admin.dashboard', [
            'election' => $election,
            'totalVoters' => $totalVoters,
            'votedCount' => $votedCount,
            'notVotedCount' => $notVotedCount,
            'turnout' => $totalVoters > 0 ? round(($votedCount / $totalVoters) * 100, 1) : 0,
            'regions' => Voter::select('region')
                ->selectRaw('count(*) as total')
                ->selectRaw('sum(case when has_voted = 1 then 1 else 0 end) as voted')
                ->groupBy('region')
                ->orderBy('region')
                ->get(),
            'recentLogs' => AuditLog::latest()->limit(8)->get(),
        ]);
    }

    public function live(Request $request, RsaVoteService $rsa): View
    {
        $election = Election::with(['candidates', 'rsaKey', 'ballots'])->withCount('ballots')->firstOrFail();
        
        $voterQuery = Voter::query();
        
        if ($request->filled('region')) {
            $region = $request->string('region');
            $voterQuery->where('region', $region);
        }
        
        $totalVoters = (clone $voterQuery)->count();
        $votedCount = (clone $voterQuery)->where('has_voted', true)->count();
        $notVotedCount = max($totalVoters - $votedCount, 0);
        $turnout = $totalVoters > 0 ? round(($votedCount / $totalVoters) * 100, 1) : 0;
        $results = collect();

        if ($election->status === 'closed') {
            $counts = $election->candidates->mapWithKeys(fn (Candidate $candidate) => [$candidate->id => 0])->all();

            foreach ($election->ballots as $ballot) {
                $candidateId = $rsa->decryptCandidateId($ballot, $election->rsaKey);
                $counts[$candidateId] = ($counts[$candidateId] ?? 0) + 1;
            }

            $results = $election->candidates
                ->map(fn (Candidate $candidate) => [
                    'candidate' => $candidate,
                    'votes' => $counts[$candidate->id] ?? 0,
                ])
                ->sortByDesc('votes')
                ->values();
        }

        $regions = Voter::select('region')->distinct()->orderBy('region')->pluck('region');

        return view('admin.live', compact('election', 'totalVoters', 'votedCount', 'notVotedCount', 'turnout', 'results', 'regions'));
    }

    public function voters(Request $request): View
    {
        $query = Voter::query()->orderBy('region')->orderBy('full_name');

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('identity_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('region')) {
            $query->where('region', $request->string('region'));
        }

        if ($request->filled('status')) {
            $query->where('has_voted', $request->string('status') === 'voted');
        }

        $stats = [
            'total' => Voter::count(),
            'voted' => Voter::where('has_voted', true)->count(),
            'not_voted' => Voter::where('has_voted', false)->count(),
        ];
        $stats['turnout'] = $stats['total'] > 0 ? round(($stats['voted'] / $stats['total']) * 100, 1) : 0;

        return view('admin.voters', [
            'voters' => $query->paginate(20)->withQueryString(),
            'regions' => Voter::select('region')->distinct()->orderBy('region')->pluck('region'),
            'stats' => $stats,
        ]);
    }

    public function lookupVoter(Request $request)
    {
        $data = $request->validate([
            'identity_number' => ['required', 'string', 'max:40'],
        ]);

        $voter = Voter::where('identity_number', strtoupper(trim($data['identity_number'])))->first();

        if (! $voter) {
            return response()->json([
                'message' => 'NIK/NIM tidak ditemukan di data pemilih.',
            ], 404);
        }

        return response()->json([
            'identity_number' => $voter->identity_number,
            'full_name' => $voter->full_name,
            'region' => $voter->region,
        ]);
    }

    public function candidates(): View
    {
        return view('admin.candidates', [
            'election' => Election::with('candidates')->firstOrFail(),
        ]);
    }

    public function storeCandidate(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'ballot_number' => ['required', 'integer', 'min:1'],
            'name' => ['required', 'string', 'max:120'],
            'photo' => ['nullable', 'url', 'max:500'],
            'vision' => ['required', 'string', 'max:180'],
            'mission' => ['required', 'string', 'max:1000'],
        ]);

        $election = Election::firstOrFail();
        $election->candidates()->create($data);
        $this->log('Tambah calon', 'Menambahkan calon '.$data['name']);

        return back()->with('status', 'Calon berhasil ditambahkan.');
    }

    public function updateCandidate(Request $request, Candidate $candidate): RedirectResponse
    {
        $data = $request->validate([
            'ballot_number' => ['required', 'integer', 'min:1'],
            'name' => ['required', 'string', 'max:120'],
            'photo' => ['nullable', 'url', 'max:500'],
            'vision' => ['required', 'string', 'max:180'],
            'mission' => ['required', 'string', 'max:1000'],
        ]);

        $candidate->update($data);
        $this->log('Edit calon', 'Memperbarui data calon '.$candidate->name);

        return back()->with('status', 'Calon berhasil diperbarui.');
    }

    public function deleteCandidate(Candidate $candidate): RedirectResponse
    {
        $name = $candidate->name;
        $candidate->delete();
        $this->log('Hapus calon', 'Menghapus calon '.$name);

        return back()->with('status', 'Calon berhasil dihapus.');
    }

    public function updateElectionStatus(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:open,closed'],
        ]);

        $election = Election::firstOrFail();
        $election->update([
            'status' => $data['status'],
            'started_at' => $data['status'] === 'open' ? ($election->started_at ?? now()) : $election->started_at,
            'ended_at' => $data['status'] === 'closed' ? now() : null,
        ]);

        $this->log($data['status'] === 'open' ? 'Buka pemilihan' : 'Tutup pemilihan', 'Status pemilihan diperbarui.');

        return back()->with('status', 'Status pemilihan berhasil diperbarui.');
    }

    public function resetDemo(): RedirectResponse
    {
        $ballotCount = Ballot::count();
        $votedCount = Voter::where('has_voted', true)->count();

        DB::transaction(function (): void {
            Ballot::query()->delete();
            Voter::query()->update([
                'has_voted' => false,
                'voted_at' => null,
            ]);

            Election::query()->update([
                'status' => 'open',
                'started_at' => now(),
                'ended_at' => null,
            ]);
        });

        $this->log(
            'Reset data demo',
            'Menghapus '.$ballotCount.' surat suara dan mengembalikan '.$votedCount.' pemilih ke status belum memilih.'
        );

        return back()->with('status', 'Data demo berhasil direset. Semua pemilih kembali belum memilih dan pemilihan dibuka.');
    }

    public function tally(RsaVoteService $rsa): View
    {
        $election = Election::with(['candidates', 'rsaKey'])->withCount('ballots')->firstOrFail();
        $results = $election->candidates->mapWithKeys(fn (Candidate $candidate) => [$candidate->id => 0])->all();

        if ($election->status === 'closed') {
            foreach ($election->ballots as $ballot) {
                $candidateId = $rsa->decryptCandidateId($ballot, $election->rsaKey);
                $results[$candidateId] = ($results[$candidateId] ?? 0) + 1;
            }
        }

        $totalVoters = Voter::count();

        return view('admin.tally', compact('election', 'results', 'totalVoters'));
    }

    public function proof(): View
    {
        return view('admin.proof', [
            'admin' => auth()->user(),
            'voter' => Voter::where('has_voted', true)->first() ?? Voter::first(),
            'ballot' => Ballot::latest()->first(),
            'logs' => AuditLog::latest()->limit(6)->get(),
            'election' => Election::with('rsaKey')->first(),
        ]);
    }

    public function importVoters(): RedirectResponse
    {
        $path = database_path('seeders/voters.csv');

        if (! file_exists($path)) {
            return back()->withErrors(['import' => 'File seed voters.csv tidak ditemukan.']);
        }

        $handle = fopen($path, 'r');
        fgetcsv($handle);
        $count = 0;

        while (($row = fgetcsv($handle)) !== false) {
            Voter::updateOrCreate(
                ['identity_number' => strtoupper($row[0])],
                ['full_name' => $row[1], 'region' => $row[2]]
            );
            $count++;
        }

        fclose($handle);
        $this->log('Import pemilih', 'Mengimpor '.$count.' data pemilih dari CSV.');

        return back()->with('status', $count.' data pemilih berhasil diimpor.');
    }

    private function log(string $action, string $detail): void
    {
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'detail' => $detail,
        ]);
    }
}
