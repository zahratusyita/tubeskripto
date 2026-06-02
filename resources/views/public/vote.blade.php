<x-layouts.app title="Pilih Calon">
    <section class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <!-- Header Judul Pemilihan (Full Width) -->
        <div class="mb-10 flex flex-col items-center text-center animate-fade-in-up">
            <p class="mb-3 inline-block rounded-full bg-emerald-100/50 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-emerald-700 border border-emerald-200/50 shadow-sm">{{ $election->village_name }}</p>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 leading-tight">
                {{ str($election->title)->replace('Digital ', '')->replace('Digital', '') }}
            </h2>
        </div>

        <div class="grid gap-8 lg:grid-cols-[320px_1fr] items-start">
            <!-- Sidebar Biodata -->
            <aside class="rounded-3xl border border-white bg-white/80 p-5 sm:p-6 shadow-2xl shadow-slate-200/50 backdrop-blur-xl lg:sticky lg:top-24 relative overflow-hidden group animate-fade-in-up delay-75">
                <!-- Decorative gradient behind biodata -->
                <div class="absolute -inset-4 bg-gradient-to-br from-emerald-100/50 to-cyan-50/50 opacity-50 blur-xl transition duration-500 group-hover:opacity-100 z-0"></div>
                
                <div class="relative z-10 flex items-center gap-4 border-b border-slate-200/60 pb-5">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 text-lg font-black text-white shadow-lg shadow-emerald-500/30">
                        {{ collect(explode(' ', $voter->full_name))->map(fn ($part) => $part[0])->take(2)->join('') }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] sm:text-xs font-bold uppercase tracking-wider text-emerald-600">Biodata Pemilih</p>
                        <h1 class="text-base sm:text-lg font-black text-slate-900 leading-tight mt-0.5 truncate">{{ $voter->full_name }}</h1>
                    </div>
                </div>
                
                <dl class="relative z-10 mt-5 grid grid-cols-2 lg:grid-cols-1 gap-3">
                    <div class="rounded-2xl bg-slate-50/80 p-3.5 sm:p-4 border border-slate-100 transition-colors hover:bg-white hover:shadow-sm">
                        <dt class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">NIK/NIM</dt>
                        <dd class="mt-1 text-sm sm:text-base font-bold text-slate-900 break-all">{{ $voter->identity_number }}</dd>
                    </div>
                    <div class="rounded-2xl bg-slate-50/80 p-3.5 sm:p-4 border border-slate-100 transition-colors hover:bg-white hover:shadow-sm">
                        <dt class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">Wilayah</dt>
                        <dd class="mt-1 text-sm sm:text-base font-bold text-slate-900 truncate">{{ $voter->region }}</dd>
                    </div>
                </dl>
            </aside>

            <!-- Kartu Kandidat -->
            <div class="animate-fade-in-up delay-150">

                @error('candidate_id')
                    <div class="mb-5 rounded-2xl border border-red-200 bg-red-50/80 px-4 py-3 sm:px-5 sm:py-4 text-sm font-semibold text-red-700 backdrop-blur-sm">{{ $message }}</div>
                @enderror

                <div class="grid gap-6 md:grid-cols-3">
                    @foreach ($election->candidates as $index => $candidate)
                        <form method="post" action="{{ route('vote.submit') }}" onsubmit="return confirm('Yakin memilih {{ $candidate->name }}? Suara yang sudah dikirim tidak dapat diubah.')" class="group relative flex flex-col overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:shadow-emerald-200/50 animate-fade-in-up" style="animation-delay: {{ 200 + ($index * 100) }}ms;">
                            @csrf
                            <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                            
                            <!-- Header Kartu -->
                            <div class="flex items-center justify-between border-b border-slate-100 bg-slate-50/50 p-5">
                                <div class="flex size-12 items-center justify-center rounded-2xl bg-gradient-to-br from-slate-800 to-slate-950 text-xl font-black text-white shadow-md">
                                    {{ $candidate->ballot_number }}
                                </div>
                                <span class="rounded-full border border-slate-200 bg-white px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-500 shadow-sm">
                                    Calon Kades
                                </span>
                            </div>
                            
                            <div class="flex flex-col grow p-5">
                                <!-- Foto / Avatar -->
                                <div class="relative mx-auto mt-2 aspect-[4/5] w-3/4 overflow-hidden rounded-2xl bg-gradient-to-br from-slate-100 to-emerald-50 border-4 border-white shadow-lg transition-transform duration-500 group-hover:scale-105 group-hover:shadow-emerald-100/80">
                                    @if ($candidate->photo)
                                        <img src="{{ $candidate->photo }}" alt="{{ $candidate->name }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="flex h-full items-center justify-center bg-slate-100 text-6xl font-black text-emerald-700/50">
                                            {{ collect(explode(' ', $candidate->name))->map(fn ($part) => $part[0])->take(2)->join('') }}
                                        </div>
                                    @endif
                                    <!-- Dekorasi overlay -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/20 to-transparent"></div>
                                </div>
                                
                                <div class="mt-6 text-center">
                                    <h3 class="text-xl font-black text-slate-900 leading-tight">{{ $candidate->name }}</h3>
                                    <p class="mt-2 text-xs font-bold text-emerald-600 uppercase tracking-wide">{{ $candidate->vision }}</p>
                                </div>
                                
                                <div class="mt-4 mb-6 rounded-xl bg-slate-50 p-4">
                                    <p class="text-xs leading-relaxed text-slate-600 line-clamp-3 group-hover:line-clamp-none transition-all duration-300">
                                        {{ $candidate->mission }}
                                    </p>
                                </div>
                                
                                <div class="mt-auto">
                                    <button class="w-full rounded-2xl bg-slate-900 px-4 py-3.5 text-sm font-black text-white shadow-md transition-all duration-300 group-hover:bg-emerald-600 group-hover:shadow-emerald-500/30">
                                        Pilih Kandidat Ini
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
