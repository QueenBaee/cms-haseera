@if($statistics->isNotEmpty())
<section id="statistics" class="py-10 border-y border-white/5 bg-[#141414]">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{--
            Desktop: flex nowrap — semua item dalam satu baris.
            Tablet/Mobile: overflow-x-auto + flex nowrap → horizontal scroll.
        --}}
        <div class="overflow-x-auto scrollbar-hide -mx-4 px-4 sm:-mx-6 sm:px-6 lg:mx-0 lg:px-0">
            <div class="flex flex-nowrap divide-x divide-white/[0.06] rounded-2xl border border-white/[0.06] bg-[#181818] min-w-max lg:min-w-0 lg:w-full">
                @foreach($statistics as $stat)
                <div class="flex-1 min-w-[130px] lg:min-w-0 px-5 py-7 text-center group hover:bg-white/[0.03] transition-colors duration-200 first:rounded-l-2xl last:rounded-r-2xl">
                    <div class="text-2xl lg:text-3xl font-bold text-white leading-none mb-1.5 whitespace-nowrap">
                        @if($stat->prefix)<span class="text-purple-400">{{ $stat->prefix }}</span>@endif{{ $stat->value }}@if($stat->suffix)<span class="text-purple-400">{{ $stat->suffix }}</span>@endif
                    </div>
                    <div class="text-xs lg:text-sm text-[#A3A3A3] font-medium leading-snug whitespace-nowrap">{{ $stat->label }}</div>
                    @if($stat->description)
                    <div class="text-xs text-[#555] mt-0.5 whitespace-nowrap">{{ $stat->description }}</div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

    </div>
</section>
@endif
