@props(['label', 'value', 'tone' => 'navy'])

@php
    $tones = [
        'navy' => 'bg-gradient-to-br from-slate-800 to-slate-950 text-white border-slate-700 shadow-slate-900/20',
        'emerald' => 'bg-gradient-to-br from-emerald-500 to-emerald-700 text-white border-emerald-400 shadow-emerald-500/30',
        'white' => 'bg-white/90 backdrop-blur-md text-slate-900 border-slate-200 shadow-slate-200/50',
        'amber' => 'bg-gradient-to-br from-amber-400 to-amber-600 text-white border-amber-300 shadow-amber-500/30',
    ];
@endphp

<div class="relative overflow-hidden {{ $tones[$tone] }} rounded-3xl border p-6 shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl group">
    <!-- Subtle glow effect -->
    <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-white/20 blur-2xl transition-transform duration-500 group-hover:scale-150"></div>
    <div class="relative z-10">
        <p class="text-xs font-bold uppercase tracking-wider opacity-90">{{ $label }}</p>
        <p class="mt-3 text-4xl font-black tracking-tight">{{ $value }}</p>
    </div>
</div>
