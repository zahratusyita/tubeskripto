@php
    function getLogBadgeClass($action) {
        $action = strtolower($action);
        if (str_contains($action, 'hapus') || str_contains($action, 'tutup')) {
            return 'bg-rose-50 text-rose-700 border-rose-200';
        } elseif (str_contains($action, 'tambah') || str_contains($action, 'buka') || str_contains($action, 'import')) {
            return 'bg-emerald-50 text-emerald-700 border-emerald-200';
        }
        return 'bg-blue-50 text-blue-700 border-blue-200';
    }
@endphp

<x-layouts.app title="Bukti Keamanan">
    <section class="admin-page animate-fade-in-up">
        <!-- Header Halaman -->
        <x-admin.page-header
            eyebrow="Presentasi"
            title="Bukti Konsep Keamanan"
            description="Halaman ini dibuat agar konsep keamanan bisa ditunjukkan langsung ke dosen atau audiens tanpa membuka kode."
        />

        <!-- Lencana Status Keamanan Utama -->
        <div class="mb-8 flex flex-col md:flex-row items-center justify-between gap-6 rounded-[2rem] border border-white/40 bg-gradient-to-r from-slate-900 to-emerald-950 p-6 sm:p-8 shadow-2xl shadow-emerald-900/20 backdrop-blur-xl relative overflow-hidden group">
            <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-emerald-500/10 blur-3xl transition-transform duration-700 group-hover:scale-150 animate-float"></div>
            <div class="flex items-center gap-4 relative z-10">
                <span class="flex size-14 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 text-white shadow-lg shadow-emerald-500/30 ring-4 ring-emerald-900/50">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </span>
                <div>
                    <h3 class="text-lg sm:text-xl font-black text-white tracking-tight">Sistem Keamanan Aktif & Terverifikasi</h3>
                    <p class="mt-1 text-sm text-emerald-100/70 max-w-xl">Konsep teruji menggunakan enkripsi asimetris RSA-2048, integrasi SHA-256 HMAC, dan hashing satu arah Bcrypt.</p>
                </div>
            </div>
            <div class="flex items-center gap-2 rounded-full bg-emerald-500/20 px-4 py-2 border border-emerald-400/30 backdrop-blur-md relative z-10">
                <span class="size-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-xs font-black text-emerald-300 uppercase tracking-widest">Sistem Aman</span>
            </div>
        </div>

        <!-- Simulator Kriptografi RSA Interaktif -->
        <div class="mb-10 rounded-[2rem] border border-white bg-white/70 p-6 sm:p-8 shadow-xl shadow-indigo-900/5 backdrop-blur-md relative overflow-hidden group">
            <div class="absolute -left-32 -top-32 h-64 w-64 rounded-full bg-indigo-100/50 blur-3xl transition-transform duration-1000 group-hover:translate-x-10"></div>
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between border-b border-indigo-100/50 pb-5 mb-6 relative z-10">
                <div class="flex items-center gap-3">
                    <span class="flex size-10 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-700 text-white shadow-lg shadow-indigo-500/20">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    <h3 class="text-sm sm:text-base font-black text-slate-900 uppercase tracking-wider">Simulator Interaktif RSA (Demo Live)</h3>
                </div>
                <span class="mt-3 sm:mt-0 text-[10px] sm:text-xs font-black text-indigo-600 bg-indigo-50 border border-indigo-100 px-3 py-1 rounded-full uppercase tracking-widest shadow-sm">Modul Presentasi</span>
            </div>

            <div class="grid gap-6 md:grid-cols-3 items-stretch relative z-10">
                <!-- Input Asli -->
                <div class="flex flex-col gap-3 rounded-2xl bg-white p-6 border border-slate-100 shadow-sm">
                    <label class="text-sm font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                        <span class="flex size-6 items-center justify-center rounded-full bg-slate-100 text-xs text-slate-600">1</span> Plaintext Pilihan
                    </label>
                    <input id="sim-input" type="text" value="Pilihan Calon: 02" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-5 py-4 text-base font-bold text-slate-800 outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-50" />
                    <button onclick="runSimulationEncrypt()" class="mt-auto w-full inline-flex items-center justify-center gap-2 rounded-xl bg-slate-900 px-5 py-4 text-sm font-black text-white hover:bg-indigo-600 transition-all cursor-pointer shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-0.5">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        Enkripsi (Kunci Publik)
                    </button>
                </div>

                <!-- Ciphertext Terenkripsi -->
                <div class="flex flex-col gap-3 rounded-2xl bg-white p-6 border border-slate-100 shadow-sm relative">
                    <!-- Panah konektor -->
                    <div class="hidden md:block absolute -left-5 top-1/2 -translate-y-1/2 text-slate-300">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                    </div>
                    <label class="text-sm font-black text-indigo-500 uppercase tracking-widest flex items-center gap-2">
                        <span class="flex size-6 items-center justify-center rounded-full bg-indigo-50 text-xs text-indigo-600">2</span> Ciphertext Aman
                    </label>
                    <div class="relative grow">
                        <code id="sim-ciphertext" class="block h-full min-h-[60px] break-all rounded-xl bg-slate-950 p-5 font-mono text-xs text-indigo-400 border border-slate-900 select-all shadow-inner leading-relaxed">
                            [Menunggu Enkripsi...]
                        </code>
                        <span id="sim-encrypting-loader" class="hidden absolute inset-0 flex items-center justify-center rounded-xl bg-slate-950/90 backdrop-blur-sm font-mono text-xs font-bold text-emerald-400">
                            <span class="animate-pulse flex items-center gap-2">
                                <svg class="h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Mengenkripsi...
                            </span>
                        </span>
                    </div>
                    <button id="sim-decrypt-btn" onclick="runSimulationDecrypt()" disabled class="mt-auto w-full inline-flex items-center justify-center gap-2 rounded-xl bg-slate-100 px-5 py-4 text-sm font-black text-slate-400 border border-slate-200 transition-all cursor-not-allowed">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" /></svg>
                        Dekripsi (Kunci Privat)
                    </button>
                </div>

                <!-- Hasil Terdekripsi -->
                <div class="flex flex-col gap-3 rounded-2xl bg-white p-6 border border-slate-100 shadow-sm relative">
                    <!-- Panah konektor -->
                    <div class="hidden md:block absolute -left-5 top-1/2 -translate-y-1/2 text-slate-300">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                    </div>
                    <label class="text-sm font-black text-emerald-500 uppercase tracking-widest flex items-center gap-2">
                        <span class="flex size-6 items-center justify-center rounded-full bg-emerald-50 text-xs text-emerald-600">3</span> Hasil Dekripsi
                    </label>
                    <div class="relative grow flex flex-col">
                        <code id="sim-decrypted" class="block flex-grow min-h-[60px] overflow-hidden truncate rounded-xl bg-slate-50 px-5 py-4 font-mono text-sm font-bold text-slate-400 border border-slate-200 flex items-center">
                            -
                        </code>
                        <span id="sim-decrypting-loader" class="hidden absolute inset-0 flex items-center justify-center rounded-xl bg-slate-900/90 backdrop-blur-sm font-mono text-xs font-bold text-emerald-400">
                            <span class="animate-pulse flex items-center gap-2">
                                <svg class="h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Mendekripsi...
                            </span>
                        </span>
                    </div>
                    <div class="mt-auto text-xs text-slate-500 font-medium leading-relaxed text-center bg-slate-50 p-3 rounded-xl border border-slate-100">
                        Hanya bisa didekripsi dengan Kunci Privat RSA saat proses rekapitulasi akhir.
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid Bukti Konsep Keamanan -->
        <div class="grid gap-6 lg:grid-cols-2">
            <!-- Kartu Bukti 1: Hash Kata Sandi -->
            <div class="rounded-3xl border border-white bg-white/70 p-8 sm:p-10 shadow-lg shadow-slate-200/40 backdrop-blur-md flex flex-col justify-between hover:shadow-xl hover:border-emerald-200 transition-all duration-300 relative overflow-hidden group">
                <div class="absolute -right-10 -bottom-10 h-32 w-32 rounded-full bg-emerald-100/40 blur-2xl transition-transform duration-700 group-hover:scale-150"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <span class="text-xs sm:text-sm font-black text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-md uppercase tracking-widest border border-emerald-100">Keamanan 01</span>
                        <span class="text-xs sm:text-sm font-bold text-slate-400">One-way Hashing</span>
                    </div>
                    <h3 class="mt-5 text-2xl font-black text-slate-900 tracking-tight">Kata Sandi Admin di-Hash</h3>
                    <p class="mt-3 text-base text-slate-500 font-medium leading-relaxed">
                        Kata sandi asli admin tidak pernah disimpan dalam teks biasa di database. Algoritma Bcrypt satu arah digunakan agar tahan terhadap serangan brute-force.
                    </p>
                </div>

                <div class="mt-8 relative z-10">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-black text-slate-500 uppercase tracking-widest">Hash Bcrypt di Database:</span>
                        <button onclick="copyToClipboard('{{ $admin->password }}', this)" class="inline-flex items-center gap-1.5 text-xs font-black text-slate-600 border border-slate-200 rounded-lg px-3 py-1.5 bg-white shadow-sm hover:bg-slate-50 transition cursor-pointer">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m-5 4h5m-5 4h5m-2 5h2" /></svg>
                            <span>Salin Hash</span>
                        </button>
                    </div>
                    <code class="block overflow-hidden rounded-xl bg-slate-900 p-5 font-mono text-sm leading-relaxed text-emerald-400 select-all border border-slate-800 shadow-inner">
                        {{ $admin->password }}
                    </code>
                </div>
            </div>

            <!-- Kartu Bukti 2: Status Pemilih Terpisah -->
            <div class="rounded-3xl border border-white bg-white/70 p-8 sm:p-10 shadow-lg shadow-slate-200/40 backdrop-blur-md flex flex-col justify-between hover:shadow-xl hover:border-indigo-200 transition-all duration-300 relative overflow-hidden group">
                <div class="absolute -right-10 -bottom-10 h-32 w-32 rounded-full bg-indigo-100/40 blur-2xl transition-transform duration-700 group-hover:scale-150"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <span class="text-xs sm:text-sm font-black text-indigo-600 bg-indigo-50 px-3 py-1.5 rounded-md uppercase tracking-widest border border-indigo-100">Keamanan 02</span>
                        <span class="text-xs sm:text-sm font-bold text-slate-400">Data Segregation</span>
                    </div>
                    <h3 class="mt-5 text-2xl font-black text-slate-900 tracking-tight">Status Pemilih Terpisah</h3>
                    <p class="mt-3 text-base text-slate-500 font-medium leading-relaxed">
                        Identitas pemilih terpisah sepenuhnya dari data pilihan calon. Pemilih hanya dilacak partisipasinya tanpa tahu siapa yang mereka pilih.
                    </p>
                </div>

                <div class="mt-8 relative z-10">
                    <!-- Visualisasi Alur Pemisahan -->
                    <div class="mb-5 grid grid-cols-7 gap-2 text-center items-center text-xs font-black text-slate-500 border border-slate-100 bg-white p-4 rounded-xl shadow-sm">
                        <div class="col-span-3 rounded-lg bg-indigo-50 border border-indigo-100 text-indigo-700 py-3 px-2 shadow-inner">
                            Data Pemilih <br> (NIK & Nama)
                        </div>
                        <div class="col-span-1 text-rose-500 text-xl flex justify-center">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </div>
                        <div class="col-span-3 rounded-lg bg-rose-50 border border-rose-100 text-rose-700 py-3 px-2 shadow-inner">
                            Data Surat Suara <br> (Anonim)
                        </div>
                    </div>

                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-black text-slate-500 uppercase tracking-widest">Sampel Data Pemilih:</span>
                    </div>
                    <code class="block overflow-hidden rounded-xl bg-slate-900 p-5 font-mono text-sm leading-relaxed text-indigo-400 select-all border border-slate-800 shadow-inner">
                        {{ $voter?->identity_number }} | {{ $voter?->full_name }} | sudah_memilih={{ $voter?->has_voted ? 'ya' : 'tidak' }}
                    </code>
                </div>
            </div>

            <!-- Kartu Bukti 3: Surat Suara Tidak Punya Identitas -->
            <div class="rounded-3xl border border-white bg-white/70 p-8 sm:p-10 shadow-lg shadow-slate-200/40 backdrop-blur-md flex flex-col justify-between hover:shadow-xl hover:border-amber-200 transition-all duration-300 relative overflow-hidden group">
                <div class="absolute -right-10 -bottom-10 h-32 w-32 rounded-full bg-amber-100/40 blur-2xl transition-transform duration-700 group-hover:scale-150"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <span class="text-xs sm:text-sm font-black text-amber-600 bg-amber-50 px-3 py-1.5 rounded-md uppercase tracking-widest border border-amber-100">Keamanan 03</span>
                        <span class="text-xs sm:text-sm font-bold text-slate-400">Anonymous Ballots</span>
                    </div>
                    <h3 class="mt-5 text-2xl font-black text-slate-900 tracking-tight">Surat Suara Tanpa Identitas</h3>
                    <p class="mt-3 text-base text-slate-500 font-medium leading-relaxed">
                        Surat suara di database murni anonim. Isinya hanyalah kombinasi token acak dan teks enkripsi RSA tanpa jejak NIK, menjamin kerahasiaan pilihan.
                    </p>
                </div>

                <div class="mt-8 relative z-10">
                    @php
                        $ballotContent = $ballot ? $ballot->anonymous_token_hash.' | '.$ballot->encrypted_vote : '';
                    @endphp
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-black text-slate-500 uppercase tracking-widest">Sampel Enkripsi Ballot:</span>
                        @if($ballot)
                            <button onclick="copyToClipboard('{{ $ballotContent }}', this)" class="inline-flex items-center gap-1.5 text-xs font-black text-slate-600 border border-slate-200 rounded-lg px-3 py-1.5 bg-white shadow-sm hover:bg-slate-50 transition cursor-pointer">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m-5 4h5m-5 4h5m-2 5h2" /></svg>
                                <span>Salin Ballot</span>
                            </button>
                        @endif
                    </div>
                    <code class="block overflow-hidden rounded-xl bg-slate-900 p-5 font-mono text-sm leading-relaxed text-amber-400 select-all border border-slate-800 break-all shadow-inner">
                        {{ $ballot ? Str::limit($ballotContent, 180) : 'Belum ada ballot terdaftar di sistem.' }}
                    </code>
                </div>
            </div>

            <!-- Kartu Bukti 4: Integritas Ballot -->
            <div class="rounded-3xl border border-white bg-white/70 p-8 sm:p-10 shadow-lg shadow-slate-200/40 backdrop-blur-md flex flex-col justify-between hover:shadow-xl hover:border-purple-200 transition-all duration-300 relative overflow-hidden group">
                <div class="absolute -right-10 -bottom-10 h-32 w-32 rounded-full bg-purple-100/40 blur-2xl transition-transform duration-700 group-hover:scale-150"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <span class="text-xs sm:text-sm font-black text-purple-600 bg-purple-50 px-3 py-1.5 rounded-md uppercase tracking-widest border border-purple-100">Keamanan 04</span>
                        <span class="text-xs sm:text-sm font-bold text-slate-400">HMAC Integrity</span>
                    </div>
                    <h3 class="mt-5 text-2xl font-black text-slate-900 tracking-tight">Integritas Ballot HMAC</h3>
                    <p class="mt-3 text-base text-slate-500 font-medium leading-relaxed">
                        Surat suara dikunci dengan kode otentikasi pesan HMAC-SHA256. Setiap perubahan manual pada isi suara akan langsung membatalkan hash ini.
                    </p>
                </div>

                <div class="mt-8 relative z-10">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-black text-slate-500 uppercase tracking-widest">Kode HMAC-SHA256:</span>
                        @if($ballot?->integrity_hash)
                            <button onclick="copyToClipboard('{{ $ballot->integrity_hash }}', this)" class="inline-flex items-center gap-1.5 text-xs font-black text-slate-600 border border-slate-200 rounded-lg px-3 py-1.5 bg-white shadow-sm hover:bg-slate-50 transition cursor-pointer">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m-5 4h5m-5 4h5m-2 5h2" /></svg>
                                <span>Salin HMAC</span>
                            </button>
                        @endif
                    </div>
                    <code class="block overflow-hidden rounded-xl bg-slate-900 p-5 font-mono text-sm leading-relaxed text-purple-400 select-all border border-slate-800 break-all shadow-inner">
                        {{ $ballot?->integrity_hash ?? 'Belum ada hash integritas.' }}
                    </code>
                </div>
            </div>

            <!-- Kartu Bukti 5: Kunci Publik RSA Aktif -->
            <div class="lg:col-span-2 rounded-3xl border border-white bg-white/70 p-8 sm:p-10 shadow-lg shadow-slate-200/40 backdrop-blur-md flex flex-col justify-between hover:shadow-xl hover:border-slate-300 transition-all duration-300 relative overflow-hidden group">
                <div class="absolute -right-20 -bottom-20 h-64 w-64 rounded-full bg-slate-200/40 blur-3xl transition-transform duration-700 group-hover:scale-150"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <span class="text-xs sm:text-sm font-black text-slate-700 bg-slate-100 px-3 py-1.5 rounded-md uppercase tracking-widest border border-slate-200">Keamanan 05</span>
                        <span class="text-xs sm:text-sm font-bold text-slate-400">RSA-2048 Asymmetric</span>
                    </div>
                    <h3 class="mt-5 text-2xl font-black text-slate-900 tracking-tight">Kunci Publik RSA-2048</h3>
                    <p class="mt-3 text-base text-slate-500 font-medium leading-relaxed max-w-4xl">
                        Inilah kunci yang dibagikan secara publik ke peramban warga. Data suara dienkripsi menggunakan kunci ini di gawai pemilih, dan mustahil dibongkar tanpa Kunci Privat yang hanya terbuka saat rekapitulasi akhir.
                    </p>
                </div>

                <div class="mt-8 relative z-10">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-black text-slate-500 uppercase tracking-widest">Public Key dalam Format PEM:</span>
                        @if($election?->rsaKey?->public_key)
                            <button onclick="copyToClipboard('{{ $election->rsaKey->public_key }}', this)" class="inline-flex items-center gap-1.5 text-xs font-black text-slate-600 border border-slate-200 rounded-lg px-3 py-1.5 bg-white shadow-sm hover:bg-slate-50 transition cursor-pointer">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m-5 4h5m-5 4h5m-2 5h2" /></svg>
                                <span>Salin Kunci RSA</span>
                            </button>
                        @endif
                    </div>
                    <code class="block overflow-hidden rounded-xl bg-slate-900 p-6 font-mono text-sm leading-relaxed text-slate-300 select-all border border-slate-800 break-all h-48 overflow-y-auto shadow-inner">
                        {{ $election?->rsaKey?->public_key ?? 'Belum ada kunci publik terdaftar.' }}
                    </code>
                </div>
            </div>
        </div>

        <!-- Log Audit Linimasa -->
        <div class="rounded-[2rem] border border-white bg-white/70 p-6 sm:p-8 shadow-xl shadow-slate-200/40 backdrop-blur-md mt-10 relative overflow-hidden group">
            <div class="absolute -left-20 -top-20 h-64 w-64 rounded-full bg-blue-100/40 blur-3xl transition-transform duration-700 group-hover:translate-x-10"></div>
            <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center justify-between border-b border-slate-200/60 pb-5 mb-8">
                <div>
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">Log Audit Transparansi</h2>
                    <p class="text-sm text-slate-500 font-medium mt-1">Mencatat seluruh tindakan administratif secara kekal demi menjaga kepercayaan audiens.</p>
                </div>
                <span class="mt-4 sm:mt-0 inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1.5 text-xs font-black uppercase tracking-widest text-blue-700 border border-blue-100 shadow-sm">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    Jejak Aktivitas
                </span>
            </div>

            <!-- Linimasa Vertikal Modern -->
            <div class="relative pl-6 sm:pl-8 border-l-2 border-slate-100 space-y-8 sm:ml-4 py-2 z-10">
                @forelse ($logs as $log)
                    @php
                        $badgeStyle = getLogBadgeClass($log->action);
                    @endphp
                    <div class="relative group/item">
                        <!-- Bullet dot timeline -->
                        <span class="absolute -left-[35px] sm:-left-[43px] top-1.5 flex size-5 sm:size-6 items-center justify-center rounded-full bg-white border-2 border-slate-200 group-hover/item:border-blue-400 group-hover/item:scale-125 group-hover/item:shadow-[0_0_10px_rgba(96,165,250,0.5)] transition-all duration-300">
                            <span class="size-2 sm:size-2.5 rounded-full bg-slate-300 group-hover/item:bg-blue-500 transition-colors"></span>
                        </span>
                        
                        <div class="rounded-2xl border border-white bg-white/50 p-5 shadow-sm transition-all duration-300 hover:bg-white hover:shadow-md hover:border-blue-100 hover:-translate-y-0.5">
                            <div class="flex flex-wrap items-center justify-between gap-3">
                                <span class="inline-flex items-center rounded-lg border px-2.5 py-1 text-[10px] font-black uppercase tracking-widest shadow-sm {{ $badgeStyle }}">
                                    {{ $log->action }}
                                </span>
                                <span class="text-[10px] font-bold text-slate-400 flex items-center gap-1.5 bg-slate-50 px-2 py-1 rounded-md border border-slate-100">
                                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    {{ $log->created_at->format('d M Y, H:i') }} WIB
                                </span>
                            </div>
                            <p class="mt-3 text-sm font-semibold text-slate-700 leading-relaxed">{{ $log->detail }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 bg-slate-50/50 rounded-2xl border border-dashed border-slate-200">
                        <svg class="h-10 w-10 text-slate-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Belum Ada Jejak Log</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- JavaScript Simulator & Copy-to-Clipboard -->
    <script>
        // Simulasi Enkripsi & Dekripsi RSA
        let currentInputText = '';
        let currentCipherText = '';

        function runSimulationEncrypt() {
            const inputVal = document.getElementById('sim-input').value.trim();
            if (!inputVal) return;

            currentInputText = inputVal;
            
            const loader = document.getElementById('sim-encrypting-loader');
            const cipherArea = document.getElementById('sim-ciphertext');
            const decryptBtn = document.getElementById('sim-decrypt-btn');
            const decryptedArea = document.getElementById('sim-decrypted');

            loader.classList.remove('hidden');
            decryptedArea.textContent = '-';
            decryptedArea.className = "block h-[45px] overflow-hidden truncate rounded-xl bg-slate-50/50 px-4 py-3.5 font-mono text-[10px] text-slate-500 border border-slate-200";
            decryptBtn.disabled = true;
            decryptBtn.className = "mt-2 inline-flex items-center justify-center gap-1.5 rounded-xl bg-slate-950 px-4 py-3 text-xs font-bold text-slate-500 border border-slate-855 transition cursor-not-allowed";

            setTimeout(() => {
                let result = '';
                const hexChars = '0123456789ABCDEF';
                for (let i = 0; i < 64; i++) {
                    result += hexChars[Math.floor(Math.random() * 16)];
                }
                currentCipherText = '0x' + result;
                cipherArea.textContent = currentCipherText;
                loader.classList.add('hidden');

                decryptBtn.disabled = false;
                decryptBtn.className = "mt-2 inline-flex items-center justify-center gap-1.5 rounded-xl bg-emerald-600 px-4 py-3 text-xs font-bold text-white hover:bg-emerald-700 transition cursor-pointer shadow-md shadow-emerald-500/10";
            }, 800);
        }

        function runSimulationDecrypt() {
            if (!currentInputText || !currentCipherText) return;

            const decryptedArea = document.getElementById('sim-decrypted');
            const decryptBtn = document.getElementById('sim-decrypt-btn');

            let counter = 0;
            const interval = setInterval(() => {
                decryptedArea.textContent = Math.random().toString(36).substring(2, 12).toUpperCase();
                counter++;
                if (counter > 8) {
                    clearInterval(interval);
                    decryptedArea.textContent = currentInputText;
                    decryptedArea.classList.remove('text-slate-500');
                    decryptedArea.classList.add('text-emerald-700', 'bg-emerald-50', 'border-emerald-250', 'font-black');
                    
                    decryptBtn.disabled = true;
                    decryptBtn.className = "mt-2 inline-flex items-center justify-center gap-1.5 rounded-xl bg-slate-900 px-4 py-3 text-xs font-bold text-slate-500 border border-slate-800 transition cursor-not-allowed";
                }
            }, 100);
        }

        // Salin ke Clipboard
        function copyToClipboard(text, button) {
            navigator.clipboard.writeText(text).then(() => {
                const originalHTML = button.innerHTML;
                button.innerHTML = `
                    <svg class="h-3 w-3 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="text-emerald-600">Tersalin</span>
                `;
                button.classList.add('bg-emerald-50', 'border-emerald-200');
                setTimeout(() => {
                    button.innerHTML = originalHTML;
                    button.classList.remove('bg-emerald-50', 'border-emerald-200');
                }, 2000);
            });
        }
    </script>
</x-layouts.app>
