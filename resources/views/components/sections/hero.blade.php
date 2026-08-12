<section id="hero" class="relative min-h-[85svh] sm:min-h-screen flex items-center justify-center overflow-hidden pt-16">

    {{-- Purple radial glow background --}}
    <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[600px] rounded-full opacity-20"
             style="background: radial-gradient(ellipse at center, #7C3AED 0%, #4C1D95 40%, transparent 70%);">
        </div>
        <div class="absolute top-0 right-0 w-96 h-96 rounded-full opacity-10"
             style="background: radial-gradient(ellipse at center, #8B5CF6 0%, transparent 70%);">
        </div>
    </div>

    {{-- Grid pattern overlay --}}
    <div class="absolute inset-0 opacity-[0.03] pointer-events-none" aria-hidden="true"
         style="background-image: linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 60px 60px;">
    </div>

    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 sm:py-20 lg:py-24 text-center">

        {{-- Badge --}}
        @if($settings->hero_badge)
        <div class="inline-flex items-center gap-2 px-4 py-1.5 mb-8 rounded-full border border-purple-500/30 bg-purple-500/10 text-purple-300 text-sm font-medium">
            <span class="w-1.5 h-1.5 rounded-full bg-purple-400 animate-pulse"></span>
            {{ $settings->hero_badge }}
        </div>
        @endif

        {{-- Main heading --}}
        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold tracking-tight leading-[1.1] mb-6 break-words">
            @foreach(explode("\n", $settings->hero_title ?? 'Creative Digital Agency') as $line)
                <span class="block">
                    @if($loop->first)
                        <span class="text-white">{{ $line }}</span>
                    @elseif($loop->iteration === 2)
                        <span class="bg-gradient-to-r from-purple-400 via-violet-400 to-purple-300 bg-clip-text text-transparent">{{ $line }}</span>
                    @else
                        <span class="text-[#B3B3B3]">{{ $line }}</span>
                    @endif
                </span>
            @endforeach
        </h1>

        {{-- Description --}}
        @if($settings->hero_description)
        <p class="mt-6 max-w-2xl mx-auto text-lg text-[#A3A3A3] leading-relaxed">
            {{ $settings->hero_description }}
        </p>
        @endif

        {{-- CTA Buttons --}}
        <div class="mt-10 flex w-full flex-col sm:flex-row items-center justify-center gap-4">
            @if($settings->hero_primary_button_text)
            <a href="{{ $settings->hero_primary_button_url ?? '#' }}"
               class="group inline-flex max-w-full items-center justify-center gap-2 px-6 sm:px-8 py-3.5 rounded-xl bg-[#b5ff41] text-[#111111] text-center font-semibold text-base hover:brightness-105 transition-all duration-200 hover:scale-105 shadow-lg shadow-[rgba(181,255,65,0.20)]">
                {{ $settings->hero_primary_button_text }}
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            @endif

            @if($settings->hero_secondary_button_text)
            <a href="{{ $settings->hero_secondary_button_url ?? '#' }}"
               class="inline-flex max-w-full items-center justify-center gap-2 px-6 sm:px-8 py-3.5 rounded-xl border border-white/10 text-white text-center font-semibold text-base hover:bg-white/5 hover:border-white/20 transition-all duration-200">
                {{ $settings->hero_secondary_button_text }}
            </a>
            @endif
        </div>

        {{-- Scroll indicator --}}
        <div class="mt-10 sm:mt-20 flex justify-center animate-bounce" aria-hidden="true">
            <svg class="w-5 h-5 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
    </div>
</section>
