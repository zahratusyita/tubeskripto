<x-layouts.app title="Area Admin">
    <section class="relative min-h-[calc(100vh-73px)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 overflow-hidden">
        <!-- Background Elements for Elegance -->
        <div class="absolute inset-0 z-0">
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-emerald-300/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
            <div class="absolute top-1/3 right-1/4 w-96 h-96 bg-teal-300/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-1/3 w-96 h-96 bg-blue-300/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000"></div>
        </div>

        <div class="relative z-10 w-full max-w-5xl grid lg:grid-cols-2 gap-12 lg:gap-8 items-center bg-white/40 backdrop-blur-xl border border-white/60 rounded-[2.5rem] p-8 lg:p-12 shadow-[0_8px_40px_rgb(0,0,0,0.04)]">
            
            <!-- Left Side / Branding -->
            <div class="flex flex-col justify-center">
                <div class="inline-flex items-center gap-2 self-start rounded-full border border-emerald-200 bg-emerald-50/80 px-4 py-2 text-sm font-bold text-emerald-700 shadow-sm mb-8 backdrop-blur-sm">
                    <span class="flex h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Area Admin Keamanan Tinggi
                </div>
                
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black tracking-tight text-slate-900 leading-tight">
                    Kelola pemilihan dengan <span class="bg-gradient-to-r from-emerald-600 to-teal-500 bg-clip-text text-transparent">aman & elegan.</span>
                </h1>
                
                <p class="mt-6 text-lg leading-relaxed text-slate-600 max-w-lg">
                    Akses kontrol penuh menggunakan NIK/NIM. Sistem dilengkapi enkripsi kriptografi tingkat lanjut dan pencatatan log audit menyeluruh.
                </p>
                
                <div class="mt-10 flex items-center gap-6 text-slate-500">
                    <div class="flex items-center gap-2">
                        <svg class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        <span class="text-sm font-semibold">Enkripsi RSA</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <span class="text-sm font-semibold">Secure Hash</span>
                    </div>
                </div>
            </div>

            <!-- Right Side / Form -->
            <div class="w-full max-w-md mx-auto lg:ml-auto lg:mr-0">
                <form method="post" action="{{ route('admin.login.submit') }}" data-login-form data-turbo="false" class="relative rounded-3xl border border-white bg-white/70 p-8 shadow-2xl shadow-slate-200/50 backdrop-blur-md transition-all hover:shadow-emerald-200/50">
                    @csrf
                    <div class="mb-8">
                        <h2 class="text-3xl font-black text-slate-900">Sign In</h2>
                        <p class="mt-2 text-sm font-medium text-slate-500">Silakan masuk dengan kredensial admin Anda.</p>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label class="text-sm font-bold text-slate-700 ml-1" for="identity_number">NIK/NIM Admin</label>
                            <div class="relative mt-2">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <input id="identity_number" name="identity_number" value="{{ old('identity_number') }}" class="block w-full rounded-2xl border-0 bg-white/50 py-3.5 pl-11 pr-4 font-semibold text-slate-900 uppercase ring-1 ring-inset ring-slate-200 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-emerald-500 transition-all shadow-sm placeholder:text-slate-400 placeholder:normal-case" placeholder="F1D02410053" autofocus>
                            </div>
                            @error('identity_number') <p class="mt-2 ml-1 text-sm font-semibold text-red-500 flex items-center gap-1"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="text-sm font-bold text-slate-700 ml-1" for="password">Kata Sandi</label>
                            <div class="relative mt-2">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input id="password" name="password" type="password" class="block w-full rounded-2xl border-0 bg-white/50 py-3.5 pl-11 pr-4 font-medium text-slate-900 ring-1 ring-inset ring-slate-200 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-emerald-500 transition-all shadow-sm placeholder:text-slate-400" placeholder="Minimal 8 karakter">
                            </div>
                            @error('password') <p class="mt-2 ml-1 text-sm font-semibold text-red-500 flex items-center gap-1"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <button data-login-button class="group mt-8 relative flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-500 px-5 py-3.5 font-bold text-white shadow-lg shadow-emerald-500/30 transition-all hover:scale-[1.02] hover:shadow-emerald-500/50 hover:from-emerald-500 hover:to-teal-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 active:scale-[0.98] disabled:cursor-wait disabled:opacity-80">
                        <svg data-login-spinner class="hidden h-5 w-5 animate-spin" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-90" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        <span data-login-label class="flex items-center gap-2">
                            Masuk Dasbor
                            <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </span>
                    </button>
                    
                    <div class="mt-6 rounded-2xl bg-emerald-50/50 p-4 border border-emerald-100/50 text-center">
                        <p class="text-xs font-medium text-slate-500">Akun seed: <span class="font-bold text-slate-800">F1D02410053</span> / <span class="font-bold text-slate-800">admin12345</span></p>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Loading Overlay -->
    <div data-login-overlay class="fixed inset-0 z-[80] hidden items-center justify-center bg-white/60 px-4 backdrop-blur-md transition-all duration-300">
        <div class="w-full max-w-sm rounded-[2.5rem] border border-white bg-white/80 p-8 text-center shadow-2xl shadow-emerald-900/10 backdrop-blur-xl relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 via-teal-500 to-emerald-400"></div>
            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-emerald-50 text-emerald-600 shadow-inner border border-emerald-100">
                <svg class="h-10 w-10 animate-spin" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-90" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
            </div>
            <h2 class="mt-6 text-xl font-black text-slate-900">Memverifikasi Admin</h2>
            <p class="mt-2 text-sm leading-relaxed text-slate-500 font-medium">Mohon tunggu, sistem sedang membangun sesi terenkripsi dengan aman...</p>
        </div>
    </div>
    
    <style>
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
    </style>
</x-layouts.app>
