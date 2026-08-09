<section id="portfolio" class="py-16 relative overflow-hidden">

    <div class="absolute top-1/2 right-0 w-80 h-80 opacity-10 pointer-events-none" aria-hidden="true"
         style="background: radial-gradient(ellipse at center, #7C3AED 0%, transparent 70%);"></div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- ── Section heading ─────────────────────────────────────────────── --}}
        <div class="text-center mb-10">
            @if($settings->projects_eyebrow)
            <p class="text-sm font-semibold text-purple-400 uppercase tracking-widest mb-3">
                {{ $settings->projects_eyebrow }}
            </p>
            @endif
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-3">
                {{ $settings->projects_title ?? 'Kolaborasi & Proyek Unggulan' }}
            </h2>
            @if($settings->projects_description)
            <p class="text-[#A3A3A3] text-base max-w-2xl mx-auto">
                {{ $settings->projects_description }}
            </p>
            @endif
        </div>

        {{-- ── Featured Project Carousel ────────────────────────────────────── --}}
        @if($featuredPortfolios->isNotEmpty())
        @php $slides = $featuredPortfolios->values(); $total = $slides->count(); @endphp

        <div class="mb-12"
             x-data="{
                 current: 0,
                 total: {{ $total }},
                 paused: false,
                 timer: null,
                 init() {
                     if (this.total > 1) this.start();
                 },
                 start() {
                     this.stop();
                     this.timer = setInterval(() => {
                         if (!this.paused) {
                             this.current = (this.current + 1) % this.total;
                         }
                     }, 5000);
                 },
                 stop() {
                     if (this.timer) { clearInterval(this.timer); this.timer = null; }
                 },
                 next() {
                     this.current = (this.current + 1) % this.total;
                     this.start();
                 },
                 previous() {
                     this.current = (this.current - 1 + this.total) % this.total;
                     this.start();
                 },
                 goTo(index) {
                     this.current = index;
                     this.start();
                 }
             }"
             @mouseenter="paused = true"
             @mouseleave="paused = false">

            {{-- Viewport: overflow-hidden clips the sliding track --}}
            <div class="relative w-full min-w-0 rounded-2xl overflow-hidden border border-white/[0.08] bg-[#1A1A1A]">

                {{-- Track: flex row, moves via translate3d --}}
                <div class="flex min-w-0 transition-transform duration-[600ms] ease-in-out"
                     :style="'transform: translate3d(-' + (current * 100) + '%, 0, 0)'">

                    @foreach($slides as $portfolio)
                    {{-- Each slide: full width, never hidden --}}
                    <div class="w-full min-w-0 shrink-0 grid grid-cols-1 lg:grid-cols-2">

                        {{-- Image --}}
                        <div class="relative overflow-hidden bg-[#141414]">
                            <div class="aspect-[16/9] lg:aspect-auto lg:h-[340px]">
                                @if($portfolio->thumbnail || $portfolio->cover_image)
                                <img src="{{ asset('storage/' . ($portfolio->thumbnail ?? $portfolio->cover_image)) }}"
                                     alt="{{ $portfolio->title }}"
                                     class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full flex items-center justify-center"
                                     style="background: linear-gradient(135deg, rgba(124,58,237,0.2) 0%, rgba(20,20,20,1) 100%);">
                                    <svg class="w-16 h-16 text-purple-500/20" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                @endif
                            </div>

                            <div class="absolute top-3 left-3 flex items-center gap-2">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-purple-500/30 border border-purple-500/40 text-purple-200">
                                    ★ Featured
                                </span>
                                @if($portfolio->category)
                                <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-black/50 border border-white/10 text-white/70">
                                    {{ $portfolio->category->name }}
                                </span>
                                @endif
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="min-w-0 flex flex-col justify-center p-6 lg:p-8">

                            @if($portfolio->client_name)
                            <p class="text-xs font-semibold text-purple-400 uppercase tracking-widest mb-2">
                                {{ $portfolio->client_name }}
                            </p>
                            @endif

                            <h3 class="text-xl lg:text-2xl font-bold text-white mb-3 leading-tight">
                                @if($portfolio->project_url)
                                <a href="{{ $portfolio->project_url }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   aria-label="Buka proyek {{ $portfolio->title }}"
                                   class="transition-colors duration-200 hover:text-purple-400">
                                    {{ $portfolio->title }}
                                </a>
                                @else
                                    {{ $portfolio->title }}
                                @endif
                            </h3>

                            @if($portfolio->short_description)
                            <p class="text-[#A3A3A3] leading-relaxed mb-4 text-sm lg:text-base line-clamp-3">
                                {{ $portfolio->short_description }}
                            </p>
                            @endif

                            @if($portfolio->technologies && count($portfolio->technologies))
                            <div class="flex flex-wrap gap-1.5 mb-5">
                                @foreach(array_slice($portfolio->technologies, 0, 5) as $tech)
                                <span class="px-2 py-0.5 text-xs rounded-md bg-white/5 border border-white/10 text-[#A3A3A3]">
                                    {{ $tech }}
                                </span>
                                @endforeach
                            </div>
                            @endif

                        </div>

                    </div>
                    @endforeach

                </div>{{-- /track --}}

                {{-- Prev / Next buttons --}}
                @if($total > 1)
                <button type="button"
                        @click="previous()"
                        class="absolute left-3 top-1/2 -translate-y-1/2 z-10 w-8 h-8 rounded-full bg-black/60 border border-white/10 flex items-center justify-center text-white hover:bg-black/80 hover:border-purple-500/40 transition-all duration-200"
                        aria-label="Slide sebelumnya">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button type="button"
                        @click="next()"
                        class="absolute right-3 top-1/2 -translate-y-1/2 z-10 w-8 h-8 rounded-full bg-black/60 border border-white/10 flex items-center justify-center text-white hover:bg-black/80 hover:border-purple-500/40 transition-all duration-200"
                        aria-label="Slide berikutnya">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
                @endif

            </div>{{-- /viewport --}}

            {{-- Pagination dots --}}
            @if($total > 1)
            <div class="flex items-center justify-center gap-2 mt-4" role="tablist" aria-label="Navigasi slide">
                @foreach($slides as $i => $portfolio)
                <button type="button"
                        @click="goTo({{ $i }})"
                        :class="current === {{ $i }} ? 'w-5 bg-purple-500' : 'w-2 bg-white/20 hover:bg-white/40'"
                        class="h-2 rounded-full transition-all duration-300"
                        role="tab"
                        :aria-selected="current === {{ $i }}"
                        aria-label="Slide {{ $i + 1 }}">
                </button>
                @endforeach
            </div>
            @endif

        </div>
        @endif

        {{-- ── Z-Pattern Project List ───────────────────────────────────────── --}}
        @if($portfolios->isNotEmpty())

        @if($featuredPortfolios->isNotEmpty())
        <div class="mb-8">
            <h3 class="text-sm font-semibold text-white/40 uppercase tracking-widest text-center">
                Proyek Lainnya
            </h3>
            <div class="mt-3 h-px bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
        </div>
        @endif

        <div class="space-y-4">
            @foreach($portfolios as $index => $portfolio)
            @php $isEven = $index % 2 === 0; @endphp

            <article class="group grid grid-cols-1 lg:grid-cols-2 gap-0 rounded-xl border border-white/[0.08] bg-[#1A1A1A] overflow-hidden hover:border-purple-500/30 transition-all duration-300">

                <div class="{{ $isEven ? 'lg:order-1' : 'lg:order-2' }} relative overflow-hidden bg-[#141414]">
                    <div class="aspect-[16/9] lg:aspect-auto lg:h-[200px]">
                        @if($portfolio->thumbnail || $portfolio->cover_image)
                        <img src="{{ asset('storage/' . ($portfolio->thumbnail ?? $portfolio->cover_image)) }}"
                             alt="{{ $portfolio->title }}"
                             loading="lazy"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                        <div class="w-full h-full flex items-center justify-center"
                             style="background: linear-gradient(135deg, rgba(124,58,237,0.15) 0%, rgba(20,20,20,1) 100%);">
                            <svg class="w-10 h-10 text-purple-500/20" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        @endif

                        @if($portfolio->category)
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-purple-500/20 border border-purple-500/30 text-purple-300">
                                {{ $portfolio->category->name }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="{{ $isEven ? 'lg:order-2' : 'lg:order-1' }} flex flex-col justify-center p-5 lg:p-6">

                    @if($portfolio->client_name)
                    <p class="text-xs font-semibold text-purple-400 uppercase tracking-widest mb-1.5">
                        {{ $portfolio->client_name }}
                    </p>
                    @endif

                    <h3 class="text-base lg:text-lg font-bold text-white mb-2 group-hover:text-purple-200 transition-colors leading-tight">
                        {{ $portfolio->title }}
                    </h3>

                    @if($portfolio->short_description)
                    <p class="text-[#A3A3A3] leading-relaxed mb-3 text-sm line-clamp-2">
                        {{ $portfolio->short_description }}
                    </p>
                    @endif

                    @if($portfolio->technologies && count($portfolio->technologies))
                    <div class="flex flex-wrap gap-1.5 mb-3">
                        @foreach(array_slice($portfolio->technologies, 0, 4) as $tech)
                        <span class="px-2 py-0.5 text-xs rounded-md bg-white/5 border border-white/10 text-[#A3A3A3]">
                            {{ $tech }}
                        </span>
                        @endforeach
                    </div>
                    @endif

                    @if($portfolio->project_url)
                    <a href="{{ $portfolio->project_url }}"
                       target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#20C997] hover:text-[#1aad82] transition-colors self-start">
                        {{ $portfolio->button_text ?? 'Lihat Proyek' }}
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                    @endif
                </div>

            </article>
            @endforeach
        </div>

        @if($hasMorePortfolios ?? false)
        <div class="mt-10 text-center">
            <a href="{{ route('portfolio.index') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-[#20C997] text-[#111111] font-semibold text-sm hover:bg-[#1aad82] transition-colors duration-200">
                Lihat Selengkapnya
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
        @endif

        @elseif($featuredPortfolios->isEmpty())
        <p class="text-center text-[#666]">Belum ada portofolio yang tersedia.</p>
        @endif

    </div>
</section>
