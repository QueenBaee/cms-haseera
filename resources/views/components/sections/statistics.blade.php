@if($statistics->isNotEmpty())
@php
    $statCount = min($statistics->count(), 4);
@endphp
<section id="statistics" class="statistics-section relative pt-10 sm:pt-12 pb-8 sm:pb-10">

    <div class="relative mx-auto px-4 sm:px-6 lg:px-8" style="max-width: 1520px;">
        <div class="statistics-panel statistics-grid rounded-3xl p-3"
             style="--stat-columns: {{ $statCount }}">
            @foreach($statistics as $index => $stat)
            @php $isLong = mb_strlen($stat->value) > 8; @endphp
            <article class="statistics-card group flex min-h-40 min-w-0 flex-col items-center justify-center rounded-2xl px-4 py-6 text-center transition duration-300 hover:-translate-y-0.5 sm:min-h-44 sm:px-5">
                <div class="{{ $isLong ? 'statistics-value stat-value-long' : 'statistics-value' }} mb-3 font-bold leading-none"
                     x-data="statCounter(@js($stat->value), {{ $index * 80 }})"
                     x-init="init()">
                    @if($stat->prefix)<span>{{ $stat->prefix }}</span>@endif<span x-text="display">{{ $stat->value }}</span>@if($stat->suffix)<span>{{ $stat->suffix }}</span>@endif
                </div>
                @if($stat->label)
                <p class="w-full max-w-sm min-w-0 text-sm font-medium leading-relaxed text-white/70 sm:text-base">
                    {{ $stat->label }}
                </p>
                @endif
                @if($stat->description)
                <p class="mt-2 w-full min-w-0 text-xs leading-relaxed text-white/45">{{ $stat->description }}</p>
                @endif
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif
