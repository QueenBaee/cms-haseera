<section id="about" class="py-14 sm:py-20 lg:py-24 relative overflow-hidden">

    <div class="absolute bottom-0 left-0 w-96 h-96 opacity-10 pointer-events-none" aria-hidden="true"
         style="background: radial-gradient(ellipse at center, #7C3AED 0%, transparent 70%);"></div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">

            {{-- Left: Heading --}}
            <div class="min-w-0">
                @if($settings->about_eyebrow)
                <p class="text-sm font-semibold text-purple-400 uppercase tracking-widest mb-4">
                    {{ $settings->about_eyebrow }}
                </p>
                @endif

                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight mb-6">
                    {{ $settings->about_title ?? 'Mitra Kreatif untuk Transformasi Digital Anda' }}
                </h2>

                @if($settings->about_description)
                <p class="text-[#A3A3A3] text-lg leading-relaxed">
                    {{ $settings->about_description }}
                </p>
                @endif
            </div>

            {{-- Right: Benefit pills --}}
            @if($benefits->isNotEmpty())
            <div class="min-w-0 flex flex-wrap gap-3">
                @foreach($benefits as $benefit)
                <div class="min-w-0 max-w-full flex items-center gap-3 px-4 sm:px-5 py-3 rounded-xl border border-white/[0.08] bg-[#1A1A1A] hover:border-purple-500/40 hover:bg-[#1e1a2e] transition-all duration-200">
                    <span class="w-2 h-2 rounded-full bg-purple-500 shrink-0" aria-hidden="true"></span>
                    <span class="min-w-0 text-sm font-medium text-white break-words">{{ $benefit->title }}</span>
                </div>
                @endforeach
            </div>
            @endif

        </div>
    </div>
</section>
