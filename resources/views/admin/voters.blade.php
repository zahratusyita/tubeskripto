@php
    function getInitials($name) {
        $words = explode(' ', trim($name));
        $initials = '';
        foreach ($words as $w) {
            $initials .= mb_substr($w, 0, 1);
        }
        return mb_strtoupper(mb_substr($initials, 0, 2));
    }
    
    function getAvatarBgColor($name) {
        $char = ord(strtoupper(substr(trim($name), 0, 1)));
        $colors = [
            'bg-blue-50 text-blue-700 border-blue-100',
            'bg-emerald-50 text-emerald-700 border-emerald-100',
            'bg-indigo-50 text-indigo-700 border-indigo-100',
            'bg-purple-50 text-purple-700 border-purple-100',
            'bg-pink-50 text-pink-700 border-pink-100',
            'bg-rose-50 text-rose-700 border-rose-100',
            'bg-amber-50 text-amber-700 border-amber-100',
            'bg-teal-50 text-teal-700 border-teal-100',
            'bg-cyan-50 text-cyan-700 border-cyan-100',
        ];
        return $colors[$char % count($colors)];
    }
@endphp

<x-layouts.app title="Daftar Pemilih">
    <section class="admin-page animate-fade-in-up">
        <!-- Header Halaman -->
        <x-admin.page-header
            eyebrow="Data Warga"
            title="Daftar Pemilih"
            description="Pantau warga yang sudah dan belum menggunakan hak pilih. Data demo berasal dari NIM sebagai simulasi NIK."
        >
            <x-slot:actions>
                <form method="post" action="{{ route('admin.voters.import') }}" class="inline-block">
                    @csrf
                    <button class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-500/20 hover:from-emerald-500 hover:to-teal-500 transition-all hover:translate-y-[-1px] active:translate-y-[0px] cursor-pointer">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        <span>Impor CSV Pemilih</span>
                    </button>
                </form>
            </x-slot:actions>
        </x-admin.page-header>

        <!-- Ringkasan Statistik Pemilih -->
        <div class="mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Total Pemilih -->
            <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Pemilih</p>
                        <h3 class="mt-1 text-3xl font-black text-slate-900">{{ number_format($stats['total'], 0, ',', '.') }}</h3>
                    </div>
                    <div class="rounded-xl bg-blue-50 p-3 text-blue-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 005.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-slate-400">
                    <span>Terdaftar di sistem</span>
                </div>
            </div>

            <!-- Sudah Memilih -->
            <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Sudah Memilih</p>
                        <h3 class="mt-1 text-3xl font-black text-emerald-600">{{ number_format($stats['voted'], 0, ',', '.') }}</h3>
                    </div>
                    <div class="rounded-xl bg-emerald-50 p-3 text-emerald-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-slate-500">
                    <span class="font-bold text-emerald-600">{{ $stats['total'] > 0 ? round(($stats['voted']/$stats['total'])*100, 1) : 0 }}%</span>
                    <span class="ml-1 text-slate-400">dari total pemilih</span>
                </div>
            </div>

            <!-- Belum Memilih -->
            <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Belum Memilih</p>
                        <h3 class="mt-1 text-3xl font-black text-rose-600">{{ number_format($stats['not_voted'], 0, ',', '.') }}</h3>
                    </div>
                    <div class="rounded-xl bg-rose-50 p-3 text-rose-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-slate-500">
                    <span class="font-bold text-rose-600">{{ $stats['total'] > 0 ? round(($stats['not_voted']/$stats['total'])*100, 1) : 0 }}%</span>
                    <span class="ml-1 text-slate-400">belum memberikan suara</span>
                </div>
            </div>

            <!-- Tingkat Partisipasi -->
            <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Partisipasi</p>
                        <h3 class="mt-1 text-3xl font-black text-teal-600">{{ $stats['turnout'] }}%</h3>
                    </div>
                    <div class="rounded-xl bg-teal-50 p-3 text-teal-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                        </svg>
                    </div>
                </div>
                <!-- Progress Bar -->
                <div class="mt-4">
                    <div class="h-2 w-full rounded-full bg-slate-100 overflow-hidden">
                        <div class="h-full rounded-full bg-gradient-to-r from-teal-500 to-emerald-500 transition-all duration-500" style="width: {{ $stats['turnout'] }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Pencarian Terpadu -->
        <form class="mb-6 grid gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm md:grid-cols-12 items-end" method="get">
            <!-- Kolom Cari Nama/NIK -->
            <div class="md:col-span-4 flex flex-col gap-1.5">
                <label for="search" class="text-xs font-bold text-slate-500 uppercase tracking-wider">Cari Pemilih</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input 
                        id="search" 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari Nama atau NIK..." 
                        class="w-full rounded-xl border border-slate-200 bg-slate-50/50 pl-10 pr-4 py-3 text-sm font-semibold outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-100/50"
                    />
                </div>
            </div>

            <!-- Kolom Wilayah -->
            <div class="md:col-span-3 flex flex-col gap-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Wilayah</label>
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

            <!-- Kolom Status -->
            <div class="md:col-span-3 flex flex-col gap-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Status Memilih</label>
                <div class="relative custom-dropdown" id="dropdown-status">
                    <input type="hidden" name="status" value="{{ request('status') }}">
                    <button type="button" onclick="toggleDropdown('dropdown-status')" class="w-full flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50/50 pl-10 pr-4 py-3 text-sm font-semibold text-left outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-100/50 cursor-pointer">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 pointer-events-none">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        @php
                            $statusLabels = ['voted' => 'Sudah Memilih', 'not' => 'Belum Memilih'];
                            $currentStatusLabel = $statusLabels[request('status')] ?? 'Semua Status';
                        @endphp
                        <span id="label-status" class="truncate text-slate-800">
                            {{ $currentStatusLabel }}
                        </span>
                        <svg class="h-4 w-4 text-slate-400 transition-transform duration-300 chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="custom-dropdown-menu">
                        <button type="button" class="custom-dropdown-item {{ !request('status') ? 'custom-dropdown-item-active' : '' }}" onclick="selectOption('dropdown-status', '', 'Semua Status')">
                            Semua Status
                        </button>
                        <button type="button" class="custom-dropdown-item {{ request('status') === 'voted' ? 'custom-dropdown-item-active' : '' }}" onclick="selectOption('dropdown-status', 'voted', 'Sudah Memilih')">
                            Sudah Memilih
                        </button>
                        <button type="button" class="custom-dropdown-item {{ request('status') === 'not' ? 'custom-dropdown-item-active' : '' }}" onclick="selectOption('dropdown-status', 'not', 'Belum Memilih')">
                            Belum Memilih
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="md:col-span-2 flex gap-2 w-full">
                @if(request()->anyFilled(['search', 'region', 'status']))
                    <a href="{{ route('admin.voters') }}" class="flex items-center justify-center rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-bold text-slate-600 hover:bg-slate-100 transition-all flex-1 text-center cursor-pointer" title="Reset Filter">
                        Reset
                    </a>
                @endif
                <button class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-3 text-sm font-bold text-white hover:bg-slate-800 transition-all shadow-sm flex-1 cursor-pointer">
                    <span>Saring</span>
                </button>
            </div>
        </form>

        <!-- Tabel Pemilih Premium -->
        <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm transition-all duration-300">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[800px] text-left text-sm border-collapse">
                    <thead class="bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-500 border-b border-slate-200/80">
                        <tr>
                            <th class="px-6 py-4">Nama Pemilih</th>
                            <th class="px-6 py-4">NIK / NIM</th>
                            <th class="px-6 py-4">Wilayah</th>
                            <th class="px-6 py-4">Status Pemilih</th>
                            <th class="px-6 py-4">Waktu Memilih</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($voters as $voter)
                            @php
                                $avatarStyle = getAvatarBgColor($voter->full_name);
                                $initials = getInitials($voter->full_name);
                            @endphp
                            <tr class="group hover:bg-slate-50/50 transition-colors">
                                <!-- Nama dengan Avatar -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex size-9 shrink-0 items-center justify-center rounded-full border text-xs font-bold {{ $avatarStyle }}">
                                            {{ $initials }}
                                        </div>
                                        <span class="font-semibold text-slate-800">{{ $voter->full_name }}</span>
                                    </div>
                                </td>
                                <!-- NIK/NIM -->
                                <td class="px-6 py-4 font-mono text-slate-600 font-medium group-hover:text-slate-950 transition-colors">
                                    {{ $voter->identity_number }}
                                </td>
                                <!-- Wilayah -->
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1 rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">
                                        <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        </svg>
                                        {{ $voter->region }}
                                    </span>
                                </td>
                                <!-- Keadaan (Status) -->
                                <td class="px-6 py-4">
                                    @if ($voter->has_voted)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700 border border-emerald-100">
                                            <span class="size-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            Sudah Memilih
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-50 px-3 py-1 text-xs font-bold text-slate-500 border border-slate-100">
                                            <span class="size-1.5 rounded-full bg-slate-400"></span>
                                            Belum Memilih
                                        </span>
                                    @endif
                                </td>
                                <!-- Waktu Memilih -->
                                <td class="px-6 py-4 text-slate-500 font-medium">
                                    @if ($voter->voted_at)
                                        <div class="flex items-center gap-1.5 text-xs">
                                            <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>{{ $voter->voted_at->format('d M Y, H:i') }}</span>
                                        </div>
                                    @else
                                        <span class="text-xs text-slate-400 font-normal">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center gap-3">
                                        <div class="rounded-full bg-slate-100 p-4 text-slate-400">
                                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-sm font-bold text-slate-800">Tidak ada pemilih ditemukan</h3>
                                        <p class="text-xs text-slate-500 max-w-xs leading-normal">Coba sesuaikan kata kunci pencarian Anda atau reset filter untuk menampilkan semua data.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-end">
            {{ $voters->links() }}
        </div>
    </section>
</x-layouts.app>
