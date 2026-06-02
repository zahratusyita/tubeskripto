<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\RsaKey;
use App\Models\User;
use App\Models\Voter;
use App\Services\RsaVoteService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['identity_number' => 'F1D02410053'],
            [
                'name' => 'Admin Panitia',
                'email' => 'admin@securevote.test',
                'password' => Hash::make('admin12345'),
                'role' => 'admin',
            ]
        );

        $election = Election::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'Pemilihan Kepala Desa Digital 2026',
                'village_name' => 'Desa Amanah',
                'status' => 'open',
                'started_at' => now(),
            ]
        );

        if (! $election->rsaKey) {
            $keys = app(RsaVoteService::class)->generateKeyPair();
            RsaKey::create([
                'election_id' => $election->id,
                'public_key' => $keys['public_key'],
                'private_key_encrypted' => $keys['private_key_encrypted'],
            ]);
        }

        $candidates = [
            [
                'ballot_number' => 1,
                'name' => 'Drs. Arya Wicaksana',
                'vision' => 'Desa transparan, mandiri, dan melayani.',
                'mission' => "Digitalisasi layanan warga\nPenguatan UMKM desa\nPelaporan anggaran terbuka",
            ],
            [
                'ballot_number' => 2,
                'name' => 'Siti Rahmawati, S.Pd.',
                'vision' => 'Desa inklusif dengan pelayanan cepat.',
                'mission' => "Pendidikan warga berkelanjutan\nPosyandu dan kesehatan keluarga\nAdministrasi desa satu pintu",
            ],
            [
                'ballot_number' => 3,
                'name' => 'Muhammad Fadli',
                'vision' => 'Desa produktif berbasis gotong royong.',
                'mission' => "Pertanian modern\nKeamanan lingkungan\nProgram pemuda desa",
            ],
        ];

        foreach ($candidates as $candidate) {
            Candidate::updateOrCreate(
                ['election_id' => $election->id, 'ballot_number' => $candidate['ballot_number']],
                $candidate + ['election_id' => $election->id]
            );
        }

        $path = database_path('seeders/voters.csv');
        $handle = fopen($path, 'r');
        fgetcsv($handle);

        while (($row = fgetcsv($handle)) !== false) {
            Voter::updateOrCreate(
                ['identity_number' => strtoupper($row[0])],
                ['full_name' => $row[1], 'region' => $row[2]]
            );
        }

        fclose($handle);
    }
}
