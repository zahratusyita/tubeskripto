<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-mesh {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: 
                radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
            z-index: -1;
            opacity: 0; /* Only for dark mode if needed */
        }
        .bg-mesh-light {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: 
                radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(59, 130, 246, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(16, 185, 129, 0.08) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(59, 130, 246, 0.08) 0px, transparent 50%);
            z-index: -1;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased selection:bg-emerald-500/30">
    <div class="bg-mesh-light"></div>
    
    <div class="relative z-10 min-h-screen flex flex-col">
        <header @auth id="admin-navbar" data-turbo-permanent @endauth class="sticky top-0 z-50 border-b border-slate-200/50 bg-white/70 backdrop-blur-xl">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex min-h-16 items-center justify-between gap-4">
                    <a href="{{ route('home') }}" class="group flex min-w-0 shrink-0 items-center gap-3">
                        <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-sm font-black text-white shadow-lg shadow-emerald-500/20 group-hover:rotate-12 transition-transform duration-300">SV</span>
                        <span class="flex min-w-0 flex-col justify-center">
                            <span class="block truncate text-sm font-bold leading-tight tracking-wide text-slate-900 transition-colors group-hover:text-emerald-700">SecureVote Desa</span>
                            <span class="block truncate text-xs leading-tight text-slate-500">Surat Suara Anonim RSA</span>
                        </span>
                    </a>

                    @guest
                        @if (request()->routeIs('vote.show'))
                            <div class="rounded-full bg-emerald-100/80 px-3 sm:px-4 py-1.5 sm:py-2 border border-emerald-200 shadow-sm">
                                <span class="text-[10px] sm:text-xs font-bold text-emerald-700 flex items-center gap-1.5">
                                    <svg class="h-3 w-3 sm:h-4 sm:w-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="hidden sm:inline">Keadaan:</span> Berhak Memilih
                                </span>
                            </div>
                        @else
                            <a class="admin-nav-action" href="{{ route('admin.login') }}">Area Admin</a>
                        @endif
                    @endguest

                    @auth
                        <div class="hidden items-center gap-2 lg:flex">
                            @php
                                $navItems = [
                                    ['label' => 'Dasbor', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard'],
                                    ['label' => 'Pantauan', 'route' => 'admin.live', 'active' => 'admin.live'],
                                    ['label' => 'Calon', 'route' => 'admin.candidates', 'active' => 'admin.candidates'],
                                    ['label' => 'Pemilih', 'route' => 'admin.voters', 'active' => 'admin.voters'],
                                    ['label' => 'Rekap', 'route' => 'admin.tally', 'active' => 'admin.tally'],
                                    ['label' => 'Bukti', 'route' => 'admin.proof', 'active' => 'admin.proof'],
                                ];
                            @endphp

                            @foreach ($navItems as $item)
                                <a class="admin-nav-link {{ request()->routeIs($item['active']) ? 'admin-nav-link-active' : '' }}" href="{{ route($item['route']) }}" data-admin-nav>{{ $item['label'] }}</a>
                            @endforeach

                            <a class="inline-flex items-center gap-1.5 rounded-xl border border-blue-200 bg-blue-50/50 px-3.5 py-2 text-sm font-bold text-blue-700 shadow-sm transition-all hover:bg-blue-50 hover:scale-105 active:scale-95 cursor-pointer mr-2" href="{{ route('home') }}" target="_blank">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9-9c1.657 0 3 4.03 3 9s-1.343 9-3 9m0-18c-1.657 0-3 4.03-3 9s1.343 9 3 9m-9-9a9 9 0 019-9" />
                                </svg>
                                <span>Portal Publik</span>
                            </a>

                            <form method="post" action="{{ route('admin.logout') }}">
                                @csrf
                                <button class="admin-nav-action">Keluar</button>
                            </form>
                        </div>
                    @endauth
                </div>

                @auth
                    <nav class="-mx-1 flex items-center gap-1 overflow-x-auto border-t border-slate-100 py-2 lg:hidden">
                        @foreach ($navItems as $item)
                            <a class="admin-nav-link {{ request()->routeIs($item['active']) ? 'admin-nav-link-active' : '' }}" href="{{ route($item['route']) }}" data-admin-nav>{{ $item['label'] }}</a>
                        @endforeach
                        
                        <a class="inline-flex items-center gap-1 rounded-xl border border-blue-200 bg-blue-50/50 px-3 py-2 text-xs font-bold text-blue-700 shadow-sm transition-all hover:bg-blue-50 hover:scale-105 active:scale-95 cursor-pointer shrink-0 mr-1" href="{{ route('home') }}" target="_blank">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9-9c1.657 0 3 4.03 3 9s-1.343 9-3 9m0-18c-1.657 0-3 4.03-3 9s1.343 9 3 9m-9-9a9 9 0 019-9" />
                            </svg>
                            <span>Portal Publik</span>
                        </a>

                        <form method="post" action="{{ route('admin.logout') }}" class="shrink-0">
                            @csrf
                            <button class="admin-nav-action">Keluar</button>
                        </form>
                    </nav>
                @endauth
            </div>
        </header>

        <main class="flex-grow flex flex-col justify-center">
            @if (session('status'))
                <div class="mx-auto mt-6 max-w-7xl px-4 sm:px-6 lg:px-8 w-full">
                    <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 backdrop-blur-md shadow-sm">
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>

    <!-- Script Custom Dropdown Interaktif -->
    <script>
        function toggleDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            if (!dropdown) return;
            const menu = dropdown.querySelector('.custom-dropdown-menu');
            const chevron = dropdown.querySelector('.chevron');
            
            // Tutup dropdown lain yang terbuka
            document.querySelectorAll('.custom-dropdown-menu').forEach(otherMenu => {
                if (otherMenu !== menu) {
                    otherMenu.classList.remove('show');
                    const otherChevron = otherMenu.parentElement.querySelector('.chevron');
                    if (otherChevron) otherChevron.classList.remove('rotate-180');
                }
            });

            menu.classList.toggle('show');
            if (chevron) chevron.classList.toggle('rotate-180');
        }

        function selectOption(dropdownId, value, label) {
            const dropdown = document.getElementById(dropdownId);
            if (!dropdown) return;
            const input = dropdown.querySelector('input[type="hidden"]');
            const labelSpan = dropdown.querySelector('span[id^="label-"]');
            const menu = dropdown.querySelector('.custom-dropdown-menu');
            const chevron = dropdown.querySelector('.chevron');

            if (input) input.value = value;
            if (labelSpan) labelSpan.textContent = label;
            
            // Update active class visual
            menu.querySelectorAll('.custom-dropdown-item').forEach(item => {
                if (item.getAttribute('onclick').includes(`'${value}'`) || (value === '' && item.getAttribute('onclick').includes("''"))) {
                    item.classList.add('custom-dropdown-item-active');
                } else {
                    item.classList.remove('custom-dropdown-item-active');
                }
            });

            menu.classList.remove('show');
            if (chevron) chevron.classList.remove('rotate-180');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.custom-dropdown')) {
                document.querySelectorAll('.custom-dropdown-menu').forEach(menu => {
                    menu.classList.remove('show');
                    const chevron = menu.parentElement.querySelector('.chevron');
                    if (chevron) chevron.classList.remove('rotate-185');
                });
            }
        });
    </script>
</body>
</html>
