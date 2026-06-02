<x-layouts.app title="Suara Tersimpan">
    <section class="mx-auto max-w-3xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="rounded-3xl border border-emerald-200 bg-white p-8 text-center shadow-xl shadow-slate-200/70">
            <div class="mx-auto flex size-16 items-center justify-center rounded-2xl bg-emerald-600 text-3xl font-black text-white">OK</div>
            <h1 class="mt-6 text-3xl font-black text-slate-950">Suara berhasil disimpan.</h1>
            <p class="mt-3 text-slate-600">Pilihan Anda telah dienkripsi dengan RSA dan disimpan sebagai ballot anonim. Sistem tidak menampilkan ulang isi pilihan untuk menjaga kerahasiaan.</p>
            <a href="{{ route('home') }}" class="mt-8 inline-flex rounded-xl bg-slate-950 px-5 py-3 text-sm font-black text-white hover:bg-emerald-700">Kembali ke Halaman Utama</a>
        </div>
    </section>
</x-layouts.app>
