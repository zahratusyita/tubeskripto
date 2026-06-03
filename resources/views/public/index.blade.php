<x-layouts.app title="SecureVote Desa">
    <section class="mx-auto flex flex-col lg:grid max-w-7xl gap-6 px-4 py-6 sm:gap-10 sm:px-6 lg:grid-cols-[1.1fr_.9fr] lg:grid-rows-[auto_auto_1fr] lg:gap-x-16 lg:gap-y-6 lg:px-8 lg:py-20 lg:items-start">
        <!-- 1. Title Section (Atas di mobile & desktop) -->
        <div class="order-1 lg:order-1 flex flex-col justify-center items-center lg:items-start relative lg:col-start-1 lg:row-start-1 lg:self-end mt-2 sm:mt-0 text-center lg:text-left animate-fade-in-up delay-75">
            <div class="mb-4 sm:mb-6 inline-flex w-fit items-center gap-2 rounded-full border border-emerald-200/50 bg-white/60 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-bold text-emerald-700 backdrop-blur-sm shadow-sm">
                <span class="flex h-1.5 w-1.5 sm:h-2 sm:w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Simulasi Pemilihan Kepala Desa
            </div>
            
            <h1 class="max-w-3xl text-3xl sm:text-6xl lg:text-7xl font-black tracking-tight text-slate-900 leading-[1.15] sm:leading-tight">
                Pemilihan digital 
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-600 block sm:inline">aman dengan RSA</span>
            </h1>
        </div>

        <!-- 2. Portal Panel Section (Tengah di mobile, Kanan di desktop) -->
        <div class="order-2 lg:order-2 relative w-full lg:col-start-2 lg:row-start-1 lg:row-span-3 mt-4 lg:mt-0 animate-fade-in-up delay-150">
            <!-- Decorative elements behind card -->
            <div class="absolute -inset-1 rounded-3xl bg-gradient-to-br from-emerald-200 to-cyan-200 opacity-50 blur-2xl transition duration-500 group-hover:opacity-70 animate-float"></div>
            
            <div class="relative rounded-2xl sm:rounded-3xl border border-white bg-white/90 p-5 sm:p-8 shadow-2xl shadow-slate-200/50 backdrop-blur-xl">
                <div class="mb-6 sm:mb-8 rounded-xl sm:rounded-2xl bg-slate-50 border border-slate-100 p-5 sm:p-6 text-left">
                    <div class="flex flex-row items-center gap-2 sm:gap-3 justify-start">
                        <div class="flex size-7 sm:size-8 items-center justify-center rounded-full bg-emerald-100 shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="text-xs sm:text-sm font-bold tracking-wide text-emerald-600 uppercase">Portal Pemilih</p>
                    </div>
                    <h2 class="mt-3 text-2xl sm:text-3xl font-black text-slate-900">Validasi Identitas</h2>
                    <p class="mt-2 text-sm leading-relaxed text-slate-500">Silakan masukkan NIK/NIM Anda untuk memverifikasi hak pilih sebelum masuk ke bilik suara virtual.</p>
                </div>

                <form class="space-y-5 sm:space-y-6" method="post" action="{{ route('voter.lookup') }}" data-voter-lookup-form data-turbo="false">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-slate-700" for="identity_number">Nomor Induk Kependudukan (NIK)</label>
                        <div class="relative mt-2">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <input id="identity_number" name="identity_number" value="{{ old('identity_number') }}" 
                                   class="block w-full rounded-xl border border-slate-300 bg-white py-3.5 sm:py-4 pl-11 sm:pl-12 pr-4 text-base sm:text-lg font-bold uppercase text-slate-900 placeholder-slate-400 outline-none transition-all focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20" 
                                   placeholder="Contoh: F1D02410053" autofocus autocomplete="off">
                        </div>
                        @error('identity_number')
                            <div class="mt-2 flex items-center gap-2 rounded-lg bg-red-50 p-3 text-sm font-semibold text-red-600 border border-red-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <button data-voter-lookup-button class="group relative flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 px-5 py-3.5 sm:py-4 text-base font-black text-white shadow-lg shadow-emerald-500/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-emerald-500/50 disabled:cursor-wait disabled:opacity-85 disabled:hover:scale-100">
                        <svg data-voter-lookup-spinner class="hidden size-5 animate-spin" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-90" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        <span data-voter-lookup-label>Cek Hak Pilih Saya</span>
                        <svg data-voter-lookup-arrow xmlns="http://www.w3.org/2000/svg" class="size-5 transition-transform duration-300 group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </form>

                <div class="mt-8 flex items-start gap-3 rounded-2xl border border-slate-100 bg-slate-50/80 p-4 text-sm leading-relaxed text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5 shrink-0 text-emerald-600 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <p>
                        <strong class="text-slate-900">Enkripsi End-to-End:</strong> 
                        Sistem memisahkan data identitas dengan isi suara. Panitia hanya mengetahui siapa yang telah memilih, tanpa bisa melihat pilihan Anda.
                    </p>
                </div>
            </div>
        </div>

        <div data-voter-lookup-overlay class="fixed inset-0 z-[80] hidden items-center justify-center bg-slate-950/45 px-4 backdrop-blur-sm">
            <div class="w-full max-w-sm rounded-3xl border border-white/20 bg-white p-6 text-center shadow-2xl shadow-slate-950/30">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                    <svg class="h-8 w-8 animate-spin" viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-90" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </div>
                <h2 class="mt-4 text-lg font-black text-slate-950">Mengecek Hak Pilih</h2>
                <p class="mt-2 text-sm leading-6 text-slate-500">Mohon tunggu, sistem sedang mencocokkan NIK/NIM dengan data pemilih.</p>
            </div>
        </div>

        <!-- 3. Description Text Section (Bawah di mobile, Kiri Tengah di desktop) -->
        <div class="order-3 lg:order-3 lg:col-start-1 lg:row-start-2 lg:self-start mt-4 lg:mt-0 flex justify-center lg:justify-start animate-fade-in-up delay-300">
            <p class="max-w-xl text-base sm:text-lg leading-relaxed text-slate-600 text-center lg:text-left">
                Sistem e-Voting modern untuk desa. Suara Anda disimpan sebagai 
                <strong class="text-slate-900 font-bold">ballot terenkripsi</strong>, 
                menjamin anonimitas penuh tanpa jejak identitas.
            </p>
        </div>

        <!-- 4. Stats Section (Hanya tampil di Desktop/Tablet besar) -->
        <div class="hidden sm:grid order-4 mt-6 lg:mt-0 gap-4 grid-cols-2 sm:grid-cols-3 lg:col-start-1 lg:row-start-3 lg:self-start mb-6 lg:mb-0 animate-fade-in-up delay-500">
            <div class="group relative overflow-hidden rounded-2xl border border-slate-200/50 bg-white/70 p-5 backdrop-blur-md transition-all duration-300 hover:border-emerald-300 hover:shadow-lg hover:shadow-emerald-500/10 hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <p class="text-2xl sm:text-3xl font-black text-slate-900">{{ $election?->candidates_count ?? 0 }}</p>
                <p class="mt-1 text-xs sm:text-sm font-semibold text-slate-500 group-hover:text-emerald-700 transition-colors">Kandidat Desa</p>
            </div>
            <div class="group relative overflow-hidden rounded-2xl border border-slate-200/50 bg-white/70 p-5 backdrop-blur-md transition-all duration-300 hover:border-emerald-300 hover:shadow-lg hover:shadow-emerald-500/10 hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-br from-teal-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <p class="text-2xl sm:text-3xl font-black text-slate-900">{{ $election?->ballots_count ?? 0 }}</p>
                <p class="mt-1 text-xs sm:text-sm font-semibold text-slate-500 group-hover:text-teal-700 transition-colors">Suara Masuk</p>
            </div>
            <div class="col-span-2 sm:col-span-1 group relative overflow-hidden rounded-2xl border border-slate-200/50 bg-white/70 p-5 backdrop-blur-md transition-all duration-300 hover:border-cyan-300 hover:shadow-lg hover:shadow-cyan-500/10 hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-br from-cyan-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <p class="text-xl sm:text-2xl font-black text-emerald-600 pt-1 uppercase tracking-wider">{{ $election?->status ?? 'draft' }}</p>
                <p class="mt-1 text-xs sm:text-sm font-semibold text-slate-500 group-hover:text-cyan-700 transition-colors">Status Pemilihan</p>
            </div>
        </div>
    </section>
</x-layouts.app>
