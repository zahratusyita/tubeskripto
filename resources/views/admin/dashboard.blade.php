<x-layouts.app title="Dasbor Admin">
    <section class="admin-page">
        <x-admin.page-header
            eyebrow="Panel Kendali Utama"
            title="Dasbor Admin"
            description="Pantau ringkasan operasional pemilihan, tingkat partisipasi warga, status keamanan sistem, dan akses cepat panitia secara real-time."
        >
            <x-slot:actions>
                <div class="flex items-center gap-3 bg-white/60 backdrop-blur-md px-4 py-2.5 rounded-2xl border border-slate-200/60 shadow-sm animate-fade-in-up">
                    <span class="text-[10px] sm:text-xs font-bold uppercase tracking-wider text-slate-500">Status Sistem:</span>
                    @if ($election->status === 'open')
                        <span class="flex items-center gap-2 rounded-full bg-emerald-100/80 px-3 py-1 text-xs font-black text-emerald-700 ring-1 ring-emerald-500/20">
                            <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            DIBUKA (LIVE)
                        </span>
                    @else
                        <span class="flex items-center gap-2 rounded-full bg-slate-200/80 px-3 py-1 text-xs font-black text-slate-700 ring-1 ring-slate-500/20">
                            <span class="h-2 w-2 rounded-full bg-slate-500"></span>
                            DITUTUP
                        </span>
                    @endif
                </div>
            </x-slot:actions>
        </x-admin.page-header>

        <div class="grid gap-6 lg:grid-cols-[1.25fr_.75fr] animate-fade-in-up delay-75">
            <div class="relative overflow-hidden rounded-3xl border border-slate-800 bg-gradient-to-br from-slate-900 via-slate-900 to-emerald-950 shadow-2xl shadow-emerald-900/20 group">
                <!-- Decorative animated glows -->
                <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-emerald-500/20 blur-3xl transition-transform duration-700 group-hover:scale-150 animate-float"></div>
                <div class="absolute -left-20 -bottom-20 h-64 w-64 rounded-full bg-teal-500/10 blur-3xl transition-transform duration-700 group-hover:scale-150 animate-float delay-300"></div>
                
                <div class="relative p-7 text-white sm:p-8 z-10">
                    <div class="relative">
                        <div class="mb-5 flex flex-wrap items-center gap-3">
                            <span class="rounded-full bg-emerald-500/20 border border-emerald-400/30 px-4 py-2 text-xs sm:text-sm font-black tracking-wider uppercase text-emerald-300 backdrop-blur-sm">{{ $election->village_name }}</span>
                            <span class="rounded-full bg-white/10 border border-white/20 px-4 py-2 text-xs sm:text-sm font-black tracking-wider text-white backdrop-blur-sm flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                RSA-OAEP Aktif
                            </span>
                        </div>
                        <h1 class="max-w-3xl text-4xl font-black tracking-tight sm:text-5xl lg:text-6xl text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-300 leading-tight">{{ $election->title }}</h1>
                        <p class="mt-4 max-w-2xl leading-relaxed text-slate-300 text-sm sm:text-base">Pantau partisipasi warga, status keamanan enkripsi RSA, dan kesiapan rekapitulasi langsung dari satu pusat kendali dasbor admin yang aman.</p>

                        <div class="mt-8 grid gap-4 sm:grid-cols-3">
                            <div class="rounded-2xl bg-white/5 border border-white/10 p-5 backdrop-blur-md transition-colors hover:bg-white/10">
                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Partisipasi</p>
                                <p class="mt-2 text-4xl font-black text-white">{{ $turnout }}<span class="text-2xl text-emerald-400">%</span></p>
                            </div>
                            <div class="rounded-2xl bg-white/5 border border-white/10 p-5 backdrop-blur-md transition-colors hover:bg-white/10">
                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Suara Enkripsi</p>
                                <p class="mt-2 text-4xl font-black text-white">{{ $election->ballots_count }}</p>
                            </div>
                            <div class="rounded-2xl bg-white/5 border border-white/10 p-5 backdrop-blur-md transition-colors hover:bg-white/10">
                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Calon Aktif</p>
                                <p class="mt-2 text-4xl font-black text-white">{{ $election->candidates_count }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-white bg-white/80 p-6 shadow-xl shadow-slate-200/50 backdrop-blur-xl flex flex-col justify-between relative overflow-hidden group">
                <div class="absolute -right-10 -bottom-10 h-40 w-40 rounded-full bg-emerald-100/50 blur-3xl transition-transform duration-700 group-hover:scale-150"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
                        </div>
                        <h2 class="text-xl font-black text-slate-900">Kontrol Pemilihan</h2>
                    </div>
                    <p class="mt-2 text-sm leading-relaxed text-slate-500">Kendalikan alur pemilihan. Buka voting untuk menerima suara, atau tutup untuk mengunci dan memulai proses dekripsi & rekap.</p>
                </div>
                
                <div class="relative z-10 mt-6 grid gap-3">
                    @if ($election->status === 'open')
                        <!-- Jika Status Sedang Buka -->
                        <div class="w-full rounded-2xl border-2 border-emerald-500 bg-emerald-50 px-4 py-3.5 flex items-center justify-between shadow-sm cursor-default">
                            <div class="flex items-center gap-3">
                                <span class="flex h-3 w-3 relative">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                                </span>
                                <span class="text-sm font-black text-emerald-700">Pemilihan Sedang Berjalan (Aktif)</span>
                            </div>
                            <svg class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <form method="post" action="{{ route('admin.election.status') }}">
                            @csrf @method('patch')
                            <input type="hidden" name="status" value="closed">
                            <button class="w-full rounded-2xl bg-rose-50 border-2 border-rose-200 px-4 py-3.5 text-sm font-black text-rose-600 shadow-sm transition-all hover:bg-rose-600 hover:text-white hover:border-rose-600 hover:shadow-rose-500/30 hover:-translate-y-0.5">Tutup Pemilihan Sekarang</button>
                        </form>
                    @else
                        <!-- Jika Status Tutup -->
                        <form method="post" action="{{ route('admin.election.status') }}">
                            @csrf @method('patch')
                            <input type="hidden" name="status" value="open">
                            <button class="w-full rounded-2xl border-2 border-emerald-200 bg-emerald-50 px-4 py-3.5 text-sm font-black text-emerald-600 shadow-sm transition-all hover:bg-emerald-600 hover:text-white hover:border-emerald-600 hover:shadow-emerald-500/30 hover:-translate-y-0.5">Buka Kembali Pemilihan</button>
                        </form>
                        <div class="w-full rounded-2xl bg-slate-100 border-2 border-slate-200 px-4 py-3.5 flex items-center justify-between shadow-sm opacity-80 cursor-default">
                            <div class="flex items-center gap-3">
                                <span class="h-3 w-3 rounded-full bg-slate-400"></span>
                                <span class="text-sm font-black text-slate-600">Pemilihan Telah Ditutup</span>
                            </div>
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                    @endif
                </div>
                <div class="relative z-10 mt-5 rounded-2xl bg-slate-50 border border-slate-100 p-4">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Status Rekapitulasi</p>
                    <p class="mt-1 text-sm font-bold {{ $election->status === 'closed' ? 'text-emerald-600' : 'text-amber-600' }}">
                        <span class="inline-block mr-1">●</span>
                        {{ $election->status === 'closed' ? 'Rekap sudah bisa dibuka.' : 'Rekap dikunci sampai voting ditutup.' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4 animate-fade-in-up delay-150">
            <x-stat-card label="Total Pemilih" :value="$totalVoters" />
            <x-stat-card label="Sudah Memilih" :value="$votedCount" tone="emerald" />
            <x-stat-card label="Belum Memilih" :value="$notVotedCount" tone="white" />
            <x-stat-card label="Surat Suara Masuk" :value="$election->ballots_count" tone="amber" />
        </div>

        <div class="mt-6 grid gap-6 lg:grid-cols-[.9fr_1.1fr] animate-fade-in-up delay-300">
            <div class="rounded-3xl border border-white bg-white/80 p-6 sm:p-8 shadow-xl shadow-slate-200/50 backdrop-blur-xl relative overflow-hidden group">
                <div class="flex items-center justify-between gap-4 border-b border-slate-100 pb-5">
                    <div>
                        <h2 class="text-xl font-black text-slate-900">Progres Kehadiran</h2>
                        <p class="mt-1 text-sm text-slate-500">{{ $votedCount }} dari {{ $totalVoters }} pemilih telah menggunakan haknya.</p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-emerald-100 text-emerald-700 ring-4 ring-emerald-50">
                        <p class="text-lg font-black">{{ $turnout }}<span class="text-sm">%</span></p>
                    </div>
                </div>
                <div class="mt-6 h-3 sm:h-4 overflow-hidden rounded-full bg-slate-100 shadow-inner relative">
                    <div class="absolute inset-y-0 left-0 rounded-full bg-gradient-to-r from-emerald-400 to-emerald-600 transition-all duration-1000 ease-out" style="width: {{ $turnout }}%"></div>
                </div>

                <div class="mt-8 space-y-5">
                    @foreach ($regions as $region)
                        @php
                            $regionTurnout = $region->total > 0 ? round(($region->voted / $region->total) * 100) : 0;
                        @endphp
                        <div class="group/bar">
                            <div class="mb-2 flex items-center justify-between text-sm">
                                <span class="font-bold text-slate-700 uppercase tracking-wide text-xs">{{ $region->region }}</span>
                                <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md">{{ $region->voted }}/{{ $region->total }} suara ({{ $regionTurnout }}%)</span>
                            </div>
                            <div class="h-2 overflow-hidden rounded-full bg-slate-100">
                                <div class="h-full rounded-full bg-slate-800 transition-all duration-1000 ease-out group-hover/bar:bg-emerald-500" style="width: {{ $regionTurnout }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-3xl border border-white bg-white/80 p-6 sm:p-8 shadow-xl shadow-slate-200/50 backdrop-blur-xl">
                <div class="flex items-center gap-3 mb-6">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </div>
                    <h2 class="text-xl font-black text-slate-900">Aksi Cepat</h2>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <a href="{{ route('admin.live') }}" class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:border-emerald-300 hover:shadow-lg hover:shadow-emerald-100">
                        <div class="absolute right-0 top-0 h-16 w-16 -translate-y-4 translate-x-4 rounded-full bg-emerald-50 transition-transform group-hover:scale-150"></div>
                        <div class="relative z-10">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 mb-4 transition-colors group-hover:bg-emerald-500 group-hover:text-white">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            </span>
                            <span class="block text-base font-black text-slate-900">Pantauan Langsung</span>
                            <span class="mt-1 block text-xs font-medium text-slate-500 leading-relaxed">Lihat grafik partisipasi real-time.</span>
                        </div>
                    </a>
                    <a href="{{ route('admin.candidates') }}" class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:border-amber-300 hover:shadow-lg hover:shadow-amber-100">
                        <div class="absolute right-0 top-0 h-16 w-16 -translate-y-4 translate-x-4 rounded-full bg-amber-50 transition-transform group-hover:scale-150"></div>
                        <div class="relative z-10">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-amber-600 mb-4 transition-colors group-hover:bg-amber-500 group-hover:text-white">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            </span>
                            <span class="block text-base font-black text-slate-900">Kelola Calon</span>
                            <span class="mt-1 block text-xs font-medium text-slate-500 leading-relaxed">Atur kandidat dan nomor urut.</span>
                        </div>
                    </a>
                    <a href="{{ route('admin.voters') }}" class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:border-blue-300 hover:shadow-lg hover:shadow-blue-100">
                        <div class="absolute right-0 top-0 h-16 w-16 -translate-y-4 translate-x-4 rounded-full bg-blue-50 transition-transform group-hover:scale-150"></div>
                        <div class="relative z-10">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-600 mb-4 transition-colors group-hover:bg-blue-500 group-hover:text-white">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            </span>
                            <span class="block text-base font-black text-slate-900">Daftar Pemilih</span>
                            <span class="mt-1 block text-xs font-medium text-slate-500 leading-relaxed">Saring & lihat log pemilih.</span>
                        </div>
                    </a>
                    <a href="{{ route('admin.tally') }}" class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:border-purple-300 hover:shadow-lg hover:shadow-purple-100">
                        <div class="absolute right-0 top-0 h-16 w-16 -translate-y-4 translate-x-4 rounded-full bg-purple-50 transition-transform group-hover:scale-150"></div>
                        <div class="relative z-10">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-100 text-purple-600 mb-4 transition-colors group-hover:bg-purple-500 group-hover:text-white">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            </span>
                            <span class="block text-base font-black text-slate-900">Rekap Suara</span>
                            <span class="mt-1 block text-xs font-medium text-slate-500 leading-relaxed">Buka dekripsi hasil akhir.</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-6 grid gap-6 lg:grid-cols-[.8fr_1.2fr] animate-fade-in-up delay-500 mb-10">
            <div class="rounded-3xl border border-white bg-white/80 p-6 sm:p-8 shadow-xl shadow-slate-200/50 backdrop-blur-xl">
                <div class="flex items-center gap-3 mb-6">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-900 text-white">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </div>
                    <h2 class="text-xl font-black text-slate-900">Status Keamanan</h2>
                </div>
                <div class="mt-5 space-y-3">
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 border border-slate-100 px-4 py-3.5 text-sm text-slate-600 transition-colors hover:bg-white hover:border-emerald-200 hover:shadow-sm">
                        <span class="font-medium">Kata sandi admin</span>
                        <span class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-emerald-500"></span><strong class="font-black text-emerald-700">Hash bcrypt</strong></span>
                    </div>
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 border border-slate-100 px-4 py-3.5 text-sm text-slate-600 transition-colors hover:bg-white hover:border-emerald-200 hover:shadow-sm">
                        <span class="font-medium">Enkripsi suara</span>
                        <span class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span><strong class="font-black text-emerald-700">RSA-OAEP</strong></span>
                    </div>
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 border border-slate-100 px-4 py-3.5 text-sm text-slate-600 transition-colors hover:bg-white hover:border-emerald-200 hover:shadow-sm">
                        <span class="font-medium">Surat suara</span>
                        <span class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-emerald-500"></span><strong class="font-black text-emerald-700">Anonim</strong></span>
                    </div>
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 border border-slate-100 px-4 py-3.5 text-sm text-slate-600 transition-colors hover:bg-white hover:border-emerald-200 hover:shadow-sm">
                        <span class="font-medium">Integritas data</span>
                        <span class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-emerald-500"></span><strong class="font-black text-emerald-700">HMAC-SHA256</strong></span>
                    </div>
                </div>
                <a href="{{ route('admin.proof') }}" class="mt-6 flex w-full justify-center items-center gap-2 rounded-xl border border-emerald-500 bg-emerald-50 px-4 py-3.5 text-sm font-black text-emerald-700 transition-all hover:bg-emerald-600 hover:text-white hover:shadow-lg hover:shadow-emerald-500/30">
                    Lihat Bukti Keamanan
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                </a>
            </div>

            <div class="rounded-3xl border border-white bg-white/80 p-6 sm:p-8 shadow-xl shadow-slate-200/50 backdrop-blur-xl flex flex-col h-full">
                <div class="flex items-center justify-between border-b border-slate-100 pb-5">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-100 text-rose-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <h2 class="text-xl font-black text-slate-900">Audit Trail Terbaru</h2>
                    </div>
                    <span class="rounded-full bg-rose-50 px-3 py-1 text-[10px] font-black uppercase tracking-wider text-rose-600 border border-rose-100">Log Sistem</span>
                </div>
                <div class="mt-6 grid gap-4 sm:grid-cols-2 grow items-start content-start">
                    @forelse ($recentLogs as $log)
                        <div class="rounded-2xl border border-slate-100 bg-slate-50/80 p-4 transition-colors hover:bg-white hover:border-slate-200 hover:shadow-sm">
                            <p class="text-xs font-black uppercase tracking-wider text-slate-900">{{ $log->action }}</p>
                            <p class="mt-1.5 text-sm text-slate-600 leading-relaxed">{{ $log->detail }}</p>
                            <div class="mt-3 flex items-center gap-2 text-[10px] font-semibold uppercase tracking-wider text-slate-400">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                {{ $log->created_at->format('d M Y H:i') }}
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full flex flex-col items-center justify-center rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-8 text-center h-32">
                            <svg class="h-10 w-10 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                            <p class="text-sm font-semibold text-slate-500">Belum ada log audit yang tersimpan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
