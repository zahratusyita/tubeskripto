<x-layouts.app title="Area Admin">
    <section class="mx-auto grid min-h-[calc(100vh-73px)] max-w-7xl items-center gap-8 px-4 py-10 sm:px-6 lg:grid-cols-[1fr_440px] lg:px-8">
        <div>
            <div class="inline-flex rounded-full border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-bold text-emerald-700">Area Admin Aman</div>
            <h1 class="mt-5 max-w-3xl text-5xl font-black tracking-tight text-slate-950">Kelola pemilihan, calon, dan rekap suara terenkripsi.</h1>
            <p class="mt-5 max-w-2xl text-lg leading-8 text-slate-600">Masuk admin memakai NIK/NIM dan kata sandi. Kata sandi disimpan sebagai hash, semua aksi penting tercatat di log audit.</p>
        </div>

        <form method="post" action="{{ route('admin.login.submit') }}" class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/70">
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

            <button class="mt-6 w-full rounded-xl bg-emerald-600 px-5 py-3 font-black text-white shadow-lg shadow-emerald-600/20 hover:bg-emerald-700">Masuk Dasbor</button>
            <p class="mt-4 rounded-xl bg-slate-50 p-3 text-xs leading-5 text-slate-500">Akun seed: <strong>F1D02410053</strong> / <strong>admin12345</strong></p>
        </form>
    </section>
</x-layouts.app>
