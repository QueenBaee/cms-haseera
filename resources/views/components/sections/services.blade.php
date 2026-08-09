<section id="services" class="py-14 sm:py-20 lg:py-24 bg-[#0e0e0e] relative overflow-hidden">

    <div class="absolute top-0 right-1/4 w-[500px] h-[400px] opacity-10 pointer-events-none" aria-hidden="true"
         style="background: radial-gradient(ellipse at center, #7C3AED 0%, transparent 70%);"></div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- Section heading --}}
        <div class="text-center mb-10 sm:mb-16">
            @if($settings->services_eyebrow)
            <p class="text-sm font-semibold text-purple-400 uppercase tracking-widest mb-4">
                {{ $settings->services_eyebrow }}
            </p>
            @endif
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4">
                {{ $settings->services_title ?? 'Solusi Kreatif untuk Kebutuhan Anda' }}
            </h2>
            @if($settings->services_description)
            <p class="text-[#A3A3A3] text-lg max-w-2xl mx-auto">
                {{ $settings->services_description }}
            </p>
            @endif
        </div>

        {{-- Cards grid --}}
        @if($services->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services as $service)
            <article class="group relative flex flex-col rounded-2xl border border-white/[0.08] bg-[#1A1A1A] p-6 hover:border-purple-500/40 transition-all duration-300 hover:shadow-lg hover:shadow-purple-500/10 overflow-hidden">

                {{-- Subtle top glow on hover --}}
                <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-purple-500/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300" aria-hidden="true"></div>

                {{-- Icon / Image --}}
                <div class="mb-5">
                    @if($service->image)
                    <img src="{{ asset('storage/' . $service->image) }}"
                         alt="{{ $service->title }}"
                         loading="lazy"
                         class="w-12 h-12 object-cover rounded-xl">
                    @elseif($service->icon)
                    @php
                        $icon = filled($service->icon) && str_starts_with($service->icon, 'heroicon-')
                            ? $service->icon
                            : 'heroicon-o-bolt';
                    @endphp
                    <div class="w-12 h-12 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400">
                        <x-dynamic-component :component="$icon" class="w-6 h-6" />
                    </div>
                    @else
                    <div class="w-12 h-12 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center" aria-hidden="true">
                        <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    @endif
                </div>

                {{-- Content --}}
                <h3 class="text-lg font-semibold text-white mb-2 group-hover:text-purple-300 transition-colors">
                    {{ $service->title }}
                </h3>

                @if($service->short_description)
                <p class="text-sm text-[#A3A3A3] leading-relaxed flex-1">
                    {{ $service->short_description }}
                </p>
                @endif

                @if($service->button_text && $service->button_url)
                <a href="{{ $service->button_url }}"
                   @if($service->open_new_tab) target="_blank" rel="noopener noreferrer" @endif
                   class="mt-5 inline-flex items-center gap-1.5 text-sm text-purple-400 hover:text-purple-300 font-medium transition-colors">
                    {{ $service->button_text }}
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
                @endif
            </article>
            @endforeach
        </div>
        @else
        <p class="text-center text-[#666]">Belum ada layanan yang tersedia.</p>
        @endif

    </div>
</section>
