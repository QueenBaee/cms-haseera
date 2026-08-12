@if($statistics->isNotEmpty())
<section id="statistics" class="statistics-section relative pt-10 sm:pt-14 pb-14 sm:pb-16">

    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="statistics-panel grid grid-cols-1 gap-3 rounded-3xl p-3 sm:gap-4 sm:p-4 md:grid-cols-3">
            @foreach($statistics as $index => $stat)
            <article class="statistics-card group flex min-h-40 min-w-0 flex-col items-center justify-center rounded-2xl px-5 py-8 text-center transition duration-300 hover:-translate-y-0.5 sm:min-h-44 sm:px-7">
                <div class="statistics-value mb-3 text-4xl font-bold leading-none sm:text-5xl lg:text-6xl"
                     x-data="statCounter(@js($stat->value), {{ $index * 80 }})"
                     x-init="init()">
                    @if($stat->prefix)<span>{{ $stat->prefix }}</span>@endif<span x-text="display">{{ $stat->value }}</span>@if($stat->suffix)<span>{{ $stat->suffix }}</span>@endif
                </div>
                <p class="w-full max-w-sm min-w-0 text-sm font-medium leading-relaxed text-white/70 sm:text-base">
                    {{ $stat->label }}
                </p>
                @if($stat->description)
                <p class="mt-2 w-full min-w-0 text-xs leading-relaxed text-white/45">{{ $stat->description }}</p>
                @endif
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif
