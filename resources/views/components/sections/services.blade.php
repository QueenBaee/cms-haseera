<section id="services" class="py-14 sm:py-20 lg:py-28 bg-[#0e0e0e] relative overflow-hidden">

    {{-- Ambient background glows --}}
    <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[900px] h-[600px] opacity-[0.09]"
             style="background: radial-gradient(ellipse at center, #9800EF 0%, #4a0077 40%, transparent 70%); filter: blur(40px);"></div>
        <div class="absolute top-1/3 left-[10%] w-[400px] h-[400px] opacity-[0.05]"
             style="background: radial-gradient(ellipse at center, #9800EF 0%, transparent 65%); filter: blur(60px);"></div>
        <div class="absolute top-1/3 right-[10%] w-[400px] h-[400px] opacity-[0.05]"
             style="background: radial-gradient(ellipse at center, #FF00E4 0%, transparent 65%); filter: blur(60px);"></div>
    </div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative">

        {{-- Section heading --}}
        <div class="text-center mb-12 sm:mb-16 lg:mb-20">
            @if($settings->services_eyebrow)
            <p class="text-sm font-semibold text-purple-400 uppercase tracking-widest mb-4">
                {{ $settings->services_eyebrow }}
            </p>
            @endif
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4">
                {{ $settings->services_title ?? 'Solusi Kreatif untuk Kebutuhan Anda' }}
            </h2>
            @if($settings->services_description)
            <p class="text-[#A3A3A3] text-lg max-w-2xl mx-auto leading-relaxed">
                {{ $settings->services_description }}
            </p>
            @endif
        </div>

        {{-- Cards grid — items-stretch memastikan semua card sama tinggi --}}
        @if($services->isNotEmpty())
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 lg:gap-4 items-stretch">
            @foreach($services as $service)

            @php $isFeatured = (bool) $service->is_featured; @endphp

            @if($isFeatured)
            {{-- ── FEATURED CARD — Visual Event ── --}}
            <article class="group relative flex flex-col h-full rounded-[28px] p-7 sm:p-8 overflow-hidden
                            transition-all duration-300 hover:-translate-y-1.5"
                     style="
                         background: linear-gradient(145deg,
                             rgba(152,0,239,0.20) 0%,
                             rgba(120,0,190,0.12) 30%,
                             rgba(180,0,220,0.10) 60%,
                             rgba(255,0,228,0.16) 100%
                         );
                         border: 1px solid rgba(255,0,228,0.25);
                         backdrop-filter: blur(24px);
                         -webkit-backdrop-filter: blur(24px);
                         box-shadow:
                             0 0 0 1px rgba(152,0,239,0.08) inset,
                             0 0 80px rgba(152,0,239,0.25),
                             0 24px 64px rgba(0,0,0,0.55),
                             inset 0 1px 0 rgba(255,255,255,0.10);
                         transition: box-shadow 300ms ease, transform 300ms ease;
                     "
                     onmouseenter="this.style.boxShadow='0 0 0 1px rgba(152,0,239,0.08) inset, 0 0 100px rgba(152,0,239,0.38), 0 24px 64px rgba(0,0,0,0.60), inset 0 1px 0 rgba(255,255,255,0.10)';"
                     onmouseleave="this.style.boxShadow='0 0 0 1px rgba(152,0,239,0.08) inset, 0 0 80px rgba(152,0,239,0.25), 0 24px 64px rgba(0,0,0,0.55), inset 0 1px 0 rgba(255,255,255,0.10)';">

                {{-- Top glow line --}}
                <div class="absolute inset-x-0 top-0 h-px pointer-events-none" aria-hidden="true"
                     style="background: linear-gradient(90deg, transparent 0%, rgba(255,0,228,0.60) 50%, transparent 100%);"></div>

                {{-- Inner top radial glow --}}
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-4/5 h-40 pointer-events-none opacity-25" aria-hidden="true"
                     style="background: radial-gradient(ellipse at top, rgba(152,0,239,0.5) 0%, transparent 70%);"></div>

                {{-- Ambient glow at bottom --}}
                <div class="absolute -bottom-8 left-1/2 -translate-x-1/2 w-3/4 h-24 pointer-events-none opacity-40 blur-2xl" aria-hidden="true"
                     style="background: radial-gradient(ellipse at center, rgba(255,0,228,0.5) 0%, transparent 70%);"></div>

                {{-- Title block --}}
                <div class="relative mb-5">
                    <h3 class="text-2xl sm:text-3xl font-bold tracking-tight" style="color: #ffe0fb;">
                        {{ $service->title }}
                    </h3>
                    @if($service->short_description)
                    <p class="mt-2.5 text-sm leading-relaxed" style="color: rgba(255,200,250,0.80);">
                        {{ $service->short_description }}
                    </p>
                    @endif
                </div>

                {{-- Divider --}}
                <div class="mb-5 h-px flex-shrink-0" style="background: linear-gradient(90deg, transparent, rgba(255,0,228,0.35), transparent);" aria-hidden="true"></div>

                {{-- Items list — flex-1 mengisi sisa ruang --}}
                @if(!empty($service->items))
                <ul class="relative flex-1 space-y-3" role="list">
                    @foreach($service->items as $item)
                    <li class="flex items-start gap-3">
                        <span class="mt-0.5 flex-shrink-0 w-5 h-5 rounded-full flex items-center justify-center"
                              style="background: rgba(152,0,239,0.25); border: 1px solid rgba(255,0,228,0.30);" aria-hidden="true">
                            <svg class="w-2.5 h-2.5" style="color: #B5FF41;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </span>
                        <span class="text-sm leading-relaxed" style="color: rgba(255,220,252,0.80);">
                            {{ is_array($item) ? ($item['label'] ?? '') : $item }}
                        </span>
                    </li>
                    @endforeach
                </ul>
                @endif

            </article>

            @else
            {{-- ── NORMAL GLASS CARD ── --}}
            <article class="group relative flex flex-col h-full rounded-[28px] p-7 sm:p-8 overflow-hidden
                            transition-all duration-300 hover:-translate-y-1.5"
                     style="
                         background: linear-gradient(145deg,
                             rgba(255,255,255,0.055) 0%,
                             rgba(255,255,255,0.025) 50%,
                             rgba(139,92,246,0.04) 100%
                         );
                         border: 1px solid rgba(255,255,255,0.09);
                         backdrop-filter: blur(20px);
                         -webkit-backdrop-filter: blur(20px);
                         box-shadow:
                             0 0 0 1px rgba(255,255,255,0.04) inset,
                             0 8px 48px rgba(0,0,0,0.45),
                             inset 0 1px 0 rgba(255,255,255,0.07);
                         transition: border-color 300ms ease, box-shadow 300ms ease, transform 300ms ease;
                     "
                     onmouseenter="this.style.borderColor='rgba(139,92,246,0.22)'; this.style.boxShadow='0 0 0 1px rgba(255,255,255,0.04) inset, 0 12px 56px rgba(0,0,0,0.50), 0 0 32px rgba(109,40,217,0.10), inset 0 1px 0 rgba(255,255,255,0.07)';"
                     onmouseleave="this.style.borderColor='rgba(255,255,255,0.09)'; this.style.boxShadow='0 0 0 1px rgba(255,255,255,0.04) inset, 0 8px 48px rgba(0,0,0,0.45), inset 0 1px 0 rgba(255,255,255,0.07)';">

                {{-- Top glow line on hover --}}
                <div class="absolute inset-x-0 top-0 h-px opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none" aria-hidden="true"
                     style="background: linear-gradient(90deg, transparent, rgba(139,92,246,0.45), transparent);"></div>

                {{-- Inner top highlight --}}
                <div class="absolute top-0 left-0 right-0 h-24 pointer-events-none opacity-[0.03]" aria-hidden="true"
                     style="background: linear-gradient(180deg, rgba(255,255,255,1) 0%, transparent 100%);"></div>

                {{-- Title block --}}
                <div class="mb-5">
                    <h3 class="text-2xl sm:text-3xl font-bold text-white tracking-tight group-hover:text-purple-100 transition-colors duration-300">
                        {{ $service->title }}
                    </h3>
                    @if($service->short_description)
                    <p class="mt-2.5 text-sm text-[#b0b0b0] leading-relaxed">
                        {{ $service->short_description }}
                    </p>
                    @endif
                </div>

                {{-- Divider --}}
                <div class="mb-5 h-px flex-shrink-0 transition-colors duration-300"
                     style="background: rgba(255,255,255,0.07);"
                     onmouseenter="this.style.background='rgba(139,92,246,0.18)';"
                     onmouseleave="this.style.background='rgba(255,255,255,0.07)';"
                     aria-hidden="true"></div>

                {{-- Items list — flex-1 mengisi sisa ruang --}}
                @if(!empty($service->items))
                <ul class="flex-1 space-y-3" role="list">
                    @foreach($service->items as $item)
                    <li class="flex items-start gap-3">
                        <span class="mt-0.5 flex-shrink-0 w-5 h-5 rounded-full flex items-center justify-center transition-colors duration-300"
                              style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.10);" aria-hidden="true">
                            <svg class="w-2.5 h-2.5 transition-colors duration-300" style="color: #B5FF41;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </span>
                        <span class="text-sm text-[#9ca3af] leading-relaxed">
                            {{ is_array($item) ? ($item['label'] ?? '') : $item }}
                        </span>
                    </li>
                    @endforeach
                </ul>
                @endif

            </article>
            @endif

            @endforeach
        </div>

        {{-- CTA Button --}}
        @php
            $ctaUrl = '#contact';
            if (!empty($settings->whatsapp)) {
                $wa = preg_replace('/[^0-9]/', '', $settings->whatsapp);
                if (str_starts_with($wa, '0')) {
                    $wa = '62' . substr($wa, 1);
                }
                $ctaUrl = 'https://wa.me/' . $wa;
            } elseif (!empty($settings->phone)) {
                $ph = preg_replace('/[^0-9]/', '', $settings->phone);
                if (str_starts_with($ph, '0')) {
                    $ph = '62' . substr($ph, 1);
                }
                $ctaUrl = 'https://wa.me/' . $ph;
            }
        @endphp
        <div class="mt-10 sm:mt-12 flex justify-center">
            <a href="{{ $ctaUrl }}"
               target="_blank"
               rel="noopener noreferrer"
               class="services-cta-btn"
               onmouseenter="this.style.filter='brightness(1.07)'; this.style.boxShadow='0 10px 36px rgba(181,255,65,0.32)'; this.style.transform='translateY(-2px)';"
               onmouseleave="this.style.filter='brightness(1)'; this.style.boxShadow='0 8px 30px rgba(181,255,65,0.18)'; this.style.transform='translateY(0)';">
                <span>Hubungi Kami Sekarang</span>
                <svg class="services-cta-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        @else
        <p class="text-center text-[#666]">Belum ada layanan yang tersedia.</p>
        @endif

    </div>
</section>
