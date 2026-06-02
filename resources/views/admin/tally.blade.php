<x-layouts.app title="Rekap Suara">
    <section class="admin-page animate-fade-in-up">
        <!-- Header Halaman -->
        <x-admin.page-header
            eyebrow="Rekap"
            title="Hasil Penghitungan Suara"
            description="Hasil hanya dibuka setelah pemilihan ditutup dan surat suara didekripsi menggunakan kunci privat RSA."
        />

        @if ($election->status !== 'closed')
            <!-- Tampilan Dikunci (Locked State) -->
            <div class="relative overflow-hidden rounded-3xl border border-slate-200 bg-white p-8 md:p-12 shadow-sm text-center max-w-2xl mx-auto mt-6">
                <!-- Hiasan latar belakang mesh ringan -->
                <div class="absolute -right-20 -top-20 size-60 rounded-full bg-amber-500/5 blur-3xl"></div>
                <div class="absolute -left-20 -bottom-20 size-60 rounded-full bg-blue-500/5 blur-3xl"></div>

                <div class="relative flex flex-col items-center">
                    <!-- Ikon gembok interaktif dengan animasi pulse/cincin radar -->
                    <div class="relative flex size-24 items-center justify-center rounded-full bg-amber-50 text-amber-600 border border-amber-100 shadow-sm animate-float">
                        <span class="absolute inset-0 rounded-full bg-amber-400/10 animate-ping"></span>
                        <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>

                    <h2 class="mt-8 text-2xl font-black text-slate-900 tracking-tight">Rekapitulasi Suara Dikunci</h2>
                    <p class="mt-3 text-slate-500 max-w-md mx-auto text-sm leading-relaxed">
                        Demi asas kerahasiaan pemilih dan keamanan kriptografi, rekapitulasi perolehan suara calon dikunci saat pemilihan masih berjalan. Hasil suara hanya didekripsi menggunakan Kunci Privat RSA setelah pemilihan resmi ditutup.
                    </p>

                    <!-- Live Status Stats (Aman) -->
                    <div class="mt-8 w-full max-w-md grid grid-cols-2 gap-4 rounded-2xl border border-slate-100 bg-slate-50/50 p-4">
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Suara Masuk</p>
                            <p class="mt-1 text-2xl font-black text-slate-850">{{ number_format($election->ballots_count, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tingkat Partisipasi</p>
                            @php
                                $turnout = $totalVoters > 0 ? round(($election->ballots_count / $totalVoters) * 100, 1) : 0;
                            @endphp
                            <p class="mt-1 text-2xl font-black text-emerald-600">{{ $turnout }}%</p>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-900 px-5 py-3.5 text-sm font-bold text-white hover:bg-slate-800 transition-all shadow-md cursor-pointer">
                            <span>Ke Dasbor Utama</span>
                        </a>
                        <a href="{{ route('admin.live') }}" class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3.5 text-sm font-bold text-slate-700 hover:bg-slate-50 transition-all shadow-sm cursor-pointer">
                            <span class="size-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>Pantau Live</span>
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- Tampilan Rekap Terbuka (Unlocked State) -->
            @php
                $maxVotes = -1;
                $winnerId = null;
                $totalVotes = 0;
                
                // Cari perolehan tertinggi untuk highlight pemenang
                foreach ($election->candidates as $candidate) {
                    $votes = $results[$candidate->id] ?? 0;
                    $totalVotes += $votes;
                    if ($votes > $maxVotes) {
                        $maxVotes = $votes;
                        $winnerId = $candidate->id;
                    }
                }
                
                if ($maxVotes <= 0) {
                    $winnerId = null;
                }
            @endphp

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 mt-6">
                @foreach ($election->candidates as $candidate)
                    @php
                        $votes = $results[$candidate->id] ?? 0;
                        $percent = $totalVotes > 0 ? round(($votes / $totalVotes) * 100, 1) : 0;
                        $isWinner = ($candidate->id === $winnerId);
                    @endphp
                    
                    <div class="relative overflow-hidden rounded-3xl border {{ $isWinner ? 'border-emerald-500 ring-2 ring-emerald-500/20' : 'border-slate-200' }} bg-white p-6 shadow-sm transition-all hover:-translate-y-1 hover:shadow-md">
                        <!-- Badge pemenang -->
                        @if ($isWinner)
                            <div class="absolute -right-16 -top-16 flex size-32 items-end justify-center bg-gradient-to-br from-emerald-500 to-teal-500 rotate-45 text-white pb-3 shadow-md">
                                <svg class="h-5 w-5 mb-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                            </div>
                        @endif

                        <!-- Bagian Atas: Nomor Urut -->
                        <div class="flex items-center justify-between">
                            <div class="inline-flex items-center gap-2">
                                <div class="flex size-10 items-center justify-center rounded-xl bg-slate-900 text-sm font-black text-white shadow-sm">
                                    {{ $candidate->ballot_number }}
                                </div>
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">No. Urut</span>
                            </div>
                            @if ($isWinner)
                                <span class="mr-14 inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-0.5 text-[10px] font-bold text-emerald-800">
                                    Suara Terbanyak
                                </span>
                            @endif
                        </div>

                        <!-- Bagian Tengah: Foto Calon & Nama -->
                        <div class="mt-6 flex items-center gap-4">
                            @if ($candidate->photo)
                                <img src="{{ $candidate->photo }}" alt="{{ $candidate->name }}" class="size-20 rounded-2xl object-cover border border-slate-100 shadow-sm" />
                            @else
                                <div class="flex size-20 items-center justify-center rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 border border-slate-200 text-2xl font-black text-slate-400">
                                    {{ mb_strtoupper(mb_substr($candidate->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <h3 class="text-lg font-black text-slate-900 leading-tight">{{ $candidate->name }}</h3>
                                <p class="mt-1 text-xs text-slate-400">Calon Kepala Desa</p>
                            </div>
                        </div>

                        <!-- Bagian Bawah: Hasil Suara & Progress Bar -->
                        <div class="mt-6 border-t border-slate-100 pt-5">
                            <div class="flex items-baseline justify-between">
                                <p class="text-sm font-semibold text-slate-500">Perolehan Suara</p>
                                <div class="text-right">
                                    <span class="text-4xl font-black {{ $isWinner ? 'text-emerald-600' : 'text-slate-805' }}">{{ number_format($votes, 0, ',', '.') }}</span>
                                    <span class="text-xs font-bold text-slate-400 block mt-0.5">{{ $percent }}%</span>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mt-4">
                                <div class="h-2 w-full rounded-full bg-slate-100 overflow-hidden">
                                    <div class="h-full rounded-full bg-gradient-to-r {{ $isWinner ? 'from-emerald-500 to-teal-500' : 'from-slate-450 to-slate-550' }} transition-all duration-500" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Panel Detail & Audit Kriptografi -->
            <div class="mt-8 grid gap-6 md:grid-cols-12">
                <!-- Widget Statistik Hasil -->
                <div class="md:col-span-5 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm flex flex-col justify-between">
                    <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-3">Statistik Pemilihan</h4>
                    <div class="mt-4 space-y-4 flex-grow">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500 font-medium">Total Suara Sah (Didekripsi):</span>
                            <span class="font-black text-slate-900">{{ number_format($election->ballots_count, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500 font-medium">Tingkat Partisipasi (Turnout):</span>
                            @php
                                $finalTurnout = $totalVoters > 0 ? round(($election->ballots_count / $totalVoters) * 100, 1) : 0;
                            @endphp
                            <span class="font-black text-emerald-600">{{ $finalTurnout }}%</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500 font-medium">Waktu Dimulai:</span>
                            <span class="font-semibold text-slate-700">{{ $election->started_at?->format('d M Y, H:i') ?? '-' }} WIB</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500 font-medium">Waktu Ditutup:</span>
                            <span class="font-semibold text-slate-700">{{ $election->ended_at?->format('d M Y, H:i') ?? '-' }} WIB</span>
                        </div>
                    </div>
                </div>

                <!-- Audit Kriptografi RSA -->
                <div class="md:col-span-7 rounded-3xl border border-slate-200 bg-slate-950 text-white p-6 shadow-sm">
                    <div class="flex items-center justify-between border-b border-slate-800/80 pb-3">
                        <h4 class="text-sm font-bold text-emerald-400 uppercase tracking-wider">Audit Keamanan & Kriptografi</h4>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/10 px-2.5 py-0.5 text-[10px] font-bold text-emerald-400 border border-emerald-500/20">
                            <span class="size-1 bg-emerald-450 rounded-full animate-pulse"></span>
                            RSA Terverifikasi
                        </span>
                    </div>
                    
                    <!-- Visual Alur -->
                    <div class="mt-5 grid grid-cols-3 gap-2 text-center items-center">
                        <div class="rounded-2xl bg-slate-900 p-3 border border-slate-800">
                            <svg class="h-6 w-6 text-slate-400 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <p class="text-[10px] font-bold text-slate-400 mt-2">Ballot Terenkripsi</p>
                        </div>
                        <div class="text-slate-700 font-bold text-lg">
                            ➔
                        </div>
                        <div class="rounded-2xl bg-emerald-950/40 p-3 border border-emerald-900/30">
                            <svg class="h-6 w-6 text-emerald-400 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <p class="text-[10px] font-bold text-emerald-400 mt-2">Dekripsi Kunci Privat</p>
                        </div>
                    </div>

                    <p class="mt-5 text-xs text-slate-400 leading-relaxed">
                        Sistem menggunakan algoritma **RSA dengan skema padding OAEP (Optimal Asymmetric Encryption Padding)**. Setiap ballot disimpan secara anonim dalam bentuk ciphertext hex di database. Hanya ketika pemilihan ditutup, server memuat Kunci Privat admin untuk mendekripsi ID calon. Ini menjamin suara warga tidak dapat diintip oleh siapapun (termasuk admin) selama pemilihan berlangsung.
                    </p>
                </div>
            </div>
        @endif
    </section>
</x-layouts.app>
