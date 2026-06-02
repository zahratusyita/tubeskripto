<x-layouts.app title="Kelola Calon">
    <section class="admin-page">
        <x-admin.page-header
            eyebrow="Panitia"
            title="Kelola Calon Kepala Desa"
            description="Atur nomor urut, nama, visi, misi, dan foto calon yang akan tampil di halaman pemilih."
        />

        @if ($errors->any())
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">{{ $errors->first() }}</div>
        @endif

        <div class="grid gap-8 lg:grid-cols-[400px_1fr] animate-fade-in-up delay-75">
            <form method="post" action="{{ route('admin.candidates.store') }}" class="rounded-3xl border border-white bg-white/80 p-6 sm:p-8 shadow-xl shadow-slate-200/50 backdrop-blur-xl h-fit relative overflow-hidden group">
                @csrf
                <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-emerald-100/50 blur-3xl transition-transform duration-700 group-hover:scale-150"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 text-white shadow-lg shadow-emerald-500/30">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                        </div>
                        <h2 class="text-xl font-black text-slate-900">Tambah Calon</h2>
                    </div>
                    <div class="mt-5 space-y-4">
                        <div class="rounded-2xl border border-emerald-100 bg-emerald-50/70 p-4">
                            <label for="candidate-voter-lookup" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-emerald-700">Ambil dari Data Pemilih</label>
                            <div class="grid gap-3 sm:grid-cols-[1fr_auto]">
                                <input id="candidate-voter-lookup" class="input bg-white" placeholder="Masukkan NIK/NIM calon" data-candidate-lookup-input>
                                <button type="button" class="rounded-xl bg-emerald-600 px-4 py-3 text-sm font-black text-white transition-colors hover:bg-emerald-700" data-candidate-lookup data-name-target="candidate-name-new">Ambil Data</button>
                            </div>
                            <p class="mt-2 text-xs font-semibold text-slate-500" data-candidate-lookup-message>Untuk demo, calon bisa dipilih dari daftar pemilih lalu namanya terisi otomatis.</p>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Nomor Urut</label>
                            <input class="input" name="ballot_number" type="number" placeholder="Contoh: 1">
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Nama Calon</label>
                            <input id="candidate-name-new" class="input" name="name" placeholder="Nama lengkap beserta gelar">
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Foto Profil</label>
                            <div class="grid gap-3 sm:grid-cols-[1fr_auto]">
                                <select class="input" data-photo-gender>
                                    <option value="men">Laki-laki</option>
                                    <option value="women">Perempuan</option>
                                </select>
                                <button type="button" class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-black text-emerald-700 hover:bg-emerald-500 hover:text-white transition-colors" data-random-photo data-photo-target="candidate-photo-new">Acak</button>
                            </div>
                            <input id="candidate-photo-new" class="input mt-3" name="photo" placeholder="Atau tempel tautan foto (opsional)">
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Visi</label>
                            <input class="input" name="vision" placeholder="Satu kalimat visi utama">
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Misi</label>
                            <textarea class="input min-h-28" name="mission" placeholder="Tuliskan misi, pisahkan tiap poin dengan baris baru"></textarea>
                        </div>
                        <button type="button" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-black text-slate-700 transition-colors hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700" data-auto-platform>Isi Visi & Misi Otomatis</button>
                    </div>
                    <button class="mt-8 w-full rounded-2xl bg-slate-900 px-4 py-4 font-black text-white transition-all hover:bg-emerald-600 hover:shadow-lg hover:shadow-emerald-500/30 hover:-translate-y-0.5">Simpan Calon Baru</button>
                </div>
            </form>

            <div class="space-y-4">
                @foreach ($election->candidates as $candidate)
                    @php
                        $name = strtolower($candidate->name);
                        $defaultGender = str_contains($name, 'siti') || str_contains($name, 'rahma') || str_contains($name, 'wati') ? 'women' : 'men';
                    @endphp
                    <div class="rounded-3xl border border-slate-200 bg-white/70 p-6 sm:p-8 shadow-sm backdrop-blur-sm transition-all duration-300 hover:border-emerald-200 hover:shadow-lg hover:shadow-slate-200/50 relative overflow-hidden group">
                        <div class="absolute right-0 top-0 h-32 w-32 -translate-y-8 translate-x-8 rounded-full bg-slate-50 transition-transform duration-700 group-hover:scale-150"></div>
                        <div class="relative z-10 flex flex-col sm:flex-row gap-6 items-start">
                            <!-- Candidate Number Badge -->
                            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-slate-800 to-slate-950 text-2xl font-black text-white shadow-lg shadow-slate-900/20">
                                {{ $candidate->ballot_number }}
                            </div>
                            
                            <div class="grow w-full">
                                <form id="candidate-update-{{ $candidate->id }}" method="post" action="{{ route('admin.candidates.update', $candidate) }}">
                                    @csrf @method('put')
                                    <div class="grid gap-4 md:grid-cols-[80px_1fr_1fr] hidden">
                                        <!-- Hidden ballot number, shown in badge instead but keep input for form submission -->
                                        <input type="hidden" name="ballot_number" value="{{ $candidate->ballot_number }}">
                                    </div>
                                    
                                    <div class="grid gap-4 md:grid-cols-2">
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-slate-500">Nama Calon</label>
                                            <input class="input font-bold text-slate-900" name="name" value="{{ $candidate->name }}">
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-slate-500">Visi Utama</label>
                                            <input class="input" name="vision" value="{{ $candidate->vision }}">
                                        </div>
                                    </div>
                                    <div class="mt-4 grid gap-4 md:grid-cols-[1fr_1.5fr]">
                                        <div class="space-y-3">
                                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500">Foto</label>
                                            <div class="grid gap-2 sm:grid-cols-[1fr_auto]">
                                                <select class="input py-2 text-xs" data-photo-gender>
                                                    <option value="men" @selected($defaultGender === 'men')>Laki-laki</option>
                                                    <option value="women" @selected($defaultGender === 'women')>Perempuan</option>
                                                </select>
                                                <button type="button" class="rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2 text-xs font-black text-emerald-700 hover:bg-emerald-500 hover:text-white transition-colors" data-random-photo data-photo-target="candidate-photo-{{ $candidate->id }}">Acak</button>
                                            </div>
                                            <input id="candidate-photo-{{ $candidate->id }}" class="input py-2 text-xs" name="photo" value="{{ $candidate->photo }}" placeholder="Tautan URL Foto">
                                            @if($candidate->photo)
                                                <div class="mt-2 h-20 w-20 overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
                                                    <img src="{{ $candidate->photo }}" alt="Foto" class="h-full w-full object-cover">
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-slate-500">Misi (Program Kerja)</label>
                                            <textarea class="input min-h-32 text-sm" name="mission">{{ $candidate->mission }}</textarea>
                                        </div>
                                    </div>
                                </form>
                                <div class="mt-6 flex flex-wrap gap-3 items-center justify-end border-t border-slate-100 pt-5">
                                    <form method="post" action="{{ route('admin.candidates.delete', $candidate) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus calon {{ $candidate->name }}?')">
                                        @csrf @method('delete')
                                        <button class="rounded-xl border border-rose-200 px-5 py-2.5 text-sm font-black text-rose-600 transition-colors hover:bg-rose-50 hover:border-rose-300">Hapus Calon</button>
                                    </form>
                                    <button form="candidate-update-{{ $candidate->id }}" class="rounded-xl bg-slate-900 px-6 py-2.5 text-sm font-black text-white shadow-md transition-all hover:bg-emerald-600 hover:shadow-emerald-500/30 hover:-translate-y-0.5">Simpan Perubahan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
