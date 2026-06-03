<x-layouts.app title="Area Admin">
    <section class="mx-auto grid min-h-[calc(100vh-73px)] max-w-7xl items-center gap-8 px-4 py-10 sm:px-6 lg:grid-cols-[1fr_440px] lg:px-8">
        <div>
            <div class="inline-flex rounded-full border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-bold text-emerald-700">Area Admin Aman</div>
            <h1 class="mt-5 max-w-3xl text-5xl font-black tracking-tight text-slate-950">Kelola pemilihan, calon, dan rekap suara terenkripsi.</h1>
            <p class="mt-5 max-w-2xl text-lg leading-8 text-slate-600">Masuk admin memakai NIK/NIM dan kata sandi. Kata sandi disimpan sebagai hash, semua aksi penting tercatat di log audit.</p>
        </div>

        <form method="post" action="{{ route('admin.login.submit') }}" data-login-form data-turbo="false" class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/70">
            @csrf
            <div class="rounded-2xl bg-slate-950 p-5 text-white">
                <p class="text-sm font-semibold text-emerald-300">Konsol Aman</p>
                <h2 class="mt-1 text-2xl font-black">Masuk Admin</h2>
            </div>

            <div class="mt-6 space-y-4">
                <div>
                    <label class="text-sm font-bold text-slate-700" for="identity_number">NIK/NIM Admin</label>
                    <input id="identity_number" name="identity_number" value="{{ old('identity_number') }}" class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 font-semibold uppercase outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100" placeholder="F1D02410053" autofocus>
                    @error('identity_number') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-sm font-bold text-slate-700" for="password">Kata Sandi</label>
                    <input id="password" name="password" type="password" class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100" placeholder="Minimal 8 karakter">
                    @error('password') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <button data-login-button class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 font-black text-white shadow-lg shadow-emerald-600/20 transition hover:bg-emerald-700 disabled:cursor-wait disabled:opacity-80">
                <svg data-login-spinner class="hidden h-5 w-5 animate-spin" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-90" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                <span data-login-label>Masuk Dasbor</span>
            </button>
            <p class="mt-4 rounded-xl bg-slate-50 p-3 text-xs leading-5 text-slate-500">Akun seed: <strong>F1D02410053</strong> / <strong>admin12345</strong></p>
        </form>
    </section>

    <div data-login-overlay class="fixed inset-0 z-[80] hidden items-center justify-center bg-slate-950/45 px-4 backdrop-blur-sm">
        <div class="w-full max-w-sm rounded-3xl border border-white/20 bg-white p-6 text-center shadow-2xl shadow-slate-950/30">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                <svg class="h-8 w-8 animate-spin" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-90" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
            </div>
            <h2 class="mt-4 text-lg font-black text-slate-950">Memverifikasi Admin</h2>
            <p class="mt-2 text-sm leading-6 text-slate-500">Mohon tunggu, sistem sedang mengecek NIK/NIM dan kata sandi.</p>
        </div>
    </div>
</x-layouts.app>
