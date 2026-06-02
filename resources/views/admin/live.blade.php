<x-layouts.app title="Pantauan Langsung">
    <section class="admin-page animate-fade-in-up">
        <!-- Header Halaman -->
        <x-admin.page-header
            eyebrow="Pantauan Langsung"
            title="Pemantauan Pemilihan"
            description="Menampilkan progres partisipasi secara langsung. Hasil per calon tetap dikunci sampai voting ditutup agar kerahasiaan dan netralitas proses terjaga."
        >
            <x-slot:actions>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-4 py-2 text-sm font-black text-emerald-800 border border-emerald-250">
                    <span class="size-2 rounded-full bg-emerald-500 {{ $election->status === 'open' ? 'animate-pulse' : '' }}"></span>
                    <span>Keadaan: {{ $election->status === 'open' ? 'DIBUKA' : 'DITUTUP' }}</span>
                </span>
            </x-slot:actions>
        </x-admin.page-header>

        <!-- Form Filter Wilayah -->
        <form class="mb-6 grid gap-4 rounded-2xl border border-slate-200 bg-white p-4 sm:grid-cols-4 items-end shadow-sm" method="get">
            <div class="sm:col-span-3 flex flex-col gap-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Saring Berdasarkan Wilayah</label>
                <div class="relative custom-dropdown" id="dropdown-region">
                    <input type="hidden" name="region" value="{{ request('region') }}">
                    <button type="button" onclick="toggleDropdown('dropdown-region')" class="w-full flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50/50 pl-10 pr-4 py-3 text-sm font-semibold text-left outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-100/50 cursor-pointer">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 pointer-events-none">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </span>
                        <span id="label-region" class="truncate text-slate-800">
                            {{ request('region') ?: 'Semua Wilayah' }}
                        </span>
                        <svg class="h-4 w-4 text-slate-400 transition-transform duration-300 chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="custom-dropdown-menu">
                        <button type="button" class="custom-dropdown-item {{ !request('region') ? 'custom-dropdown-item-active' : '' }}" onclick="selectOption('dropdown-region', '', 'Semua Wilayah')">
                            Semua Wilayah
                        </button>
                        @foreach ($regions as $region)
                            <button type="button" class="custom-dropdown-item {{ request('region') === $region ? 'custom-dropdown-item-active' : '' }}" onclick="selectOption('dropdown-region', '{{ $region }}', '{{ $region }}')">
                                {{ $region }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="flex gap-2">
                @if(request('region'))
                    <a href="{{ route('admin.live') }}" class="flex items-center justify-center rounded-xl border border-slate-200 bg-slate-55 px-4 py-3 text-sm font-bold text-slate-600 hover:bg-slate-100 transition-all flex-1 text-center cursor-pointer">
                        Reset
                    </a>
                @endif
                <button class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-3 text-sm font-bold text-white hover:bg-slate-800 transition-all shadow-sm flex-1 cursor-pointer">
                    <span>Saring</span>
                </button>
            </div>
        </form>

        <!-- Grid Stat Cards -->
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <x-stat-card label="Partisipasi" :value="$turnout.'%'" tone="emerald" />
            <x-stat-card label="Sudah Memilih" :value="$votedCount" />
            <x-stat-card label="Belum Memilih" :value="$notVotedCount" tone="white" />
            @if(request('region'))
                <x-stat-card label="Estimasi Suara Wilayah" :value="$votedCount" tone="amber" />
            @else
                <x-stat-card label="Surat Suara Terenkripsi" :value="$election->ballots_count" tone="amber" />
            @endif
        </div>

        <!-- Progress Kehadiran Pemilih -->
        <div class="admin-panel mt-6">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-black text-slate-950">Progres Kehadiran Pemilih {{ request('region') ? '('.request('region').')' : '' }}</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ $votedCount }} dari {{ $totalVoters }} pemilih sudah menggunakan hak pilih.</p>
                </div>
                <p class="text-3xl font-black text-emerald-700">{{ $turnout }}%</p>
            </div>
            <div class="mt-5 h-4 overflow-hidden rounded-full bg-slate-100">
                <div class="h-full rounded-full bg-emerald-600 transition-all duration-500" style="width: {{ $turnout }}%"></div>
            </div>
        </div>

        @if ($election->status !== 'closed')
            <!-- Keadaan Pemilihan Masih Berjalan (Hasil Dikunci) -->
            <div class="mt-6 grid gap-6 lg:grid-cols-[1fr_360px]">
                <div class="rounded-3xl border border-amber-200 bg-amber-50 p-6 text-amber-900 shadow-sm relative overflow-hidden">
                    <div class="absolute -right-16 -top-16 size-48 rounded-full bg-amber-500/5 blur-2xl"></div>
                    <h2 class="text-2xl font-black">Hasil per calon masih dikunci.</h2>
                    <p class="mt-3 leading-7 text-sm text-amber-950">Perolehan suara calon sengaja tidak ditampilkan sebelum pemilihan ditutup. Ini membuat demo lebih kuat secara keamanan karena admin tidak bisa memantau tren pilihan saat pemungutan suara berlangsung.</p>
                </div>
                <div class="admin-panel">
                    <h3 class="text-lg font-black text-slate-950">Yang bisa ditampilkan live</h3>
                    <ul class="mt-4 space-y-3 text-sm text-slate-600">
                        <li class="flex items-center gap-2">
                            <span class="size-1.5 rounded-full bg-emerald-500"></span>
                            <span>Total pemilih yang sudah hadir.</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="size-1.5 rounded-full bg-emerald-500"></span>
                            <span>Jumlah surat suara terenkripsi masuk.</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="size-1.5 rounded-full bg-emerald-500"></span>
                            <span>Sisa pemilih yang belum voting.</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="size-1.5 rounded-full bg-emerald-500"></span>
                            <span>Status pemilihan saat ini.</span>
                        </li>
                    </ul>
                </div>
            </div>
        @else
            <!-- Keadaan Pemilihan Selesai (Hasil Didekripsi) -->
            <div class="mt-8 border-t border-slate-200 pt-6">
                <!-- Info/Lencana Kerahasiaan Pilihan Suara -->
                <div class="mb-6 flex flex-wrap items-center justify-between gap-4 rounded-2xl border border-blue-200 bg-blue-50/50 p-4 shadow-sm backdrop-blur-md">
                    <div class="flex items-center gap-3">
                        <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-blue-500 text-white shadow-lg shadow-blue-500/20">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">Peringkat Suara Terbanyak (Nasional/Agregat)</h3>
                            <p class="text-xs text-slate-500">Hasil rekapitulasi suara calon di bawah bersifat global seluruh desa demi menjaga asas kerahasiaan pilihan warga di wilayah terkecil.</p>
                        </div>
                    </div>
                </div>

                <div class="mb-5 flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900">Peringkat Suara Terbanyak</h2>
                        <p class="mt-1 text-sm text-slate-500">Hasil ini muncul setelah surat suara didekripsi menggunakan kunci privat.</p>
                    </div>
                    <a href="{{ route('admin.tally') }}" class="rounded-xl bg-slate-950 px-4 py-3 text-sm font-black text-white hover:bg-emerald-700 transition cursor-pointer">Lihat Rekap Detail</a>
                </div>
                <div class="grid gap-5 md:grid-cols-3">
                    @foreach ($results as $index => $row)
                        <div class="rounded-2xl border border-slate-205 bg-white p-6 shadow-sm {{ $index === 0 ? 'ring-4 ring-emerald-100 border-emerald-200' : '' }} transition hover:-translate-y-1 hover:shadow-md">
                            <div class="flex items-center justify-between">
                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-black text-slate-600">Peringkat {{ $index + 1 }}</span>
                                <span class="text-4xl font-black text-emerald-750">{{ number_format($row['votes'], 0, ',', '.') }}</span>
                            </div>
                            <h3 class="mt-5 text-xl font-black text-slate-955 leading-tight">{{ $row['candidate']->name }}</h3>
                            <p class="mt-2 text-sm text-slate-400">Nomor urut {{ $row['candidate']->ballot_number }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
</x-layouts.app>
