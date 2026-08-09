@if($statistics->isNotEmpty())
<section id="statistics" class="py-8 sm:py-10 border-y border-white/5 bg-[#141414]">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{--
            Mobile:  grid 2×2
            Desktop: grid 4 kolom satu baris
        --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 rounded-2xl border border-white/[0.06] bg-[#181818] overflow-hidden">
            @foreach($statistics as $index => $stat)
            @php
                // Divider logic untuk grid 2×2 mobile / 4-col desktop
                // Mobile: border-right pada kolom 1 (index genap), border-bottom pada baris 1 (index 0,1)
                // Desktop: border-right pada semua kecuali terakhir
                $borderClass = implode(' ', array_filter([
                    // Vertical divider: selalu kecuali item terakhir di baris
                    // Mobile: item 0,2 (kiri) → border-r; item 1,3 (kanan) → tidak
                    // Desktop: semua kecuali last → border-r via lg:border-r + lg:last:border-r-0
                    ($index % 2 === 0) ? 'border-r border-white/[0.06]' : '',
                    // Horizontal divider: baris pertama mobile (index 0,1)
                    ($index < 2) ? 'border-b border-white/[0.06]' : '',
                    // Desktop override: semua punya border-r kecuali last
                    'lg:border-b-0 lg:border-r lg:last:border-r-0',
                ]));
            @endphp
            <div class="{{ $borderClass }} min-w-0 min-h-28 sm:min-h-32 px-3 py-6 sm:px-5 sm:py-7 flex flex-col items-center justify-center text-center group hover:bg-white/[0.03] transition-colors duration-200">
                <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-white leading-none mb-1 sm:mb-1.5"
                     x-data="statCounter(@js($stat->value), {{ $index * 80 }})"
                     x-init="init()">
                    @if($stat->prefix)<span class="text-purple-400">{{ $stat->prefix }}</span>@endif<span x-text="display">{{ $stat->value }}</span>@if($stat->suffix)<span class="text-purple-400">{{ $stat->suffix }}</span>@endif
                </div>
                <div class="w-full min-w-0 text-[10px] sm:text-xs lg:text-sm text-[#A3A3A3] font-medium leading-snug break-words">{{ $stat->label }}</div>
                @if($stat->description)
                <div class="w-full min-w-0 text-[10px] sm:text-xs text-[#555] mt-0.5 break-words">{{ $stat->description }}</div>
                @endif
            </div>
            @endforeach
        </div>

    </div>
</section>
@endif
