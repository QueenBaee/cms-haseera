<footer id="contact" class="relative overflow-hidden">

    {{-- CTA Band --}}
    @if($settings->cta_title)
    <div class="relative py-20 bg-[#141414] border-t border-white/5 overflow-hidden">
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true"
             style="background: radial-gradient(ellipse at 50% 100%, rgba(124,58,237,0.15) 0%, transparent 60%);"></div>

        <div class="relative mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4">
                {{ $settings->cta_title }}
            </h2>
            @if($settings->cta_description)
            <p class="text-[#A3A3A3] text-lg mb-8 max-w-xl mx-auto">
                {{ $settings->cta_description }}
            </p>
            @endif
            @if($settings->cta_button_text)
            @php
                $ctaUrl = $settings->cta_button_url ?? '';
                // Jika kosong, anchor (#...), atau mailto:/tel: → arahkan ke halaman kontak
                if (empty($ctaUrl) || preg_match('/^(#|mailto:|tel:)/i', $ctaUrl)) {
                    $ctaUrl = route('contact.index');
                }
            @endphp
            <a href="{{ $ctaUrl }}"
               class="inline-flex max-w-full items-center justify-center gap-2 px-6 sm:px-8 py-4 rounded-xl bg-[#20C997] text-[#111111] text-center font-bold text-base hover:bg-[#1aad82] transition-all duration-200 hover:scale-105 shadow-lg shadow-emerald-500/20">
                {{ $settings->cta_button_text }}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            @endif
        </div>
    </div>
    @endif

    {{-- Main footer --}}
    <div class="bg-[#0a0a0a] border-t border-white/5 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">

                {{-- Brand column --}}
                <div class="lg:col-span-2">
                    @if($settings->logo)
                    <img src="{{ asset('storage/' . $settings->logo) }}"
                         alt="{{ $settings->site_name }}"
                         class="h-8 w-auto mb-4">
                    @else
                    <span class="text-xl font-bold text-white block mb-4">{{ $settings->site_name }}</span>
                    @endif

                    @if($settings->company_description)
                    <p class="text-[#666] text-sm leading-relaxed max-w-sm mb-6">
                        {{ $settings->company_description }}
                    </p>
                    @endif

                    {{-- Social media icons --}}
                    @php
                        $wa = preg_replace('/\D/', '', $settings->whatsapp ?? '');
                        if ($wa && str_starts_with($wa, '0')) $wa = '62' . substr($wa, 1);
                        $waUrl = $wa ? 'https://wa.me/' . $wa : null;
                    @endphp
                    <div class="flex flex-wrap gap-2.5">

                        @if($settings->instagram_url)
                        <a href="{{ $settings->instagram_url }}" target="_blank" rel="noopener noreferrer"
                           aria-label="Instagram Haseera"
                           class="w-9 h-9 rounded-lg border border-white/10 bg-white/5 flex items-center justify-center text-[#888] transition-all duration-200 hover:text-white hover:border-white/25 hover:bg-white/10 hover:-translate-y-0.5"
                           style="transition: color .2s, border-color .2s, background .2s, transform .2s, box-shadow .2s;"
                           onmouseenter="this.style.boxShadow='0 0 14px rgba(152,0,239,0.30)'"
                           onmouseleave="this.style.boxShadow='none'">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        @endif

                        @if($waUrl)
                        <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
                           aria-label="WhatsApp Haseera"
                           class="w-9 h-9 rounded-lg border border-white/10 bg-white/5 flex items-center justify-center text-[#888] transition-all duration-200 hover:text-white hover:border-white/25 hover:bg-white/10 hover:-translate-y-0.5"
                           onmouseenter="this.style.boxShadow='0 0 14px rgba(152,0,239,0.30)'"
                           onmouseleave="this.style.boxShadow='none'">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </a>
                        @endif

                        @if($settings->email)
                        <a href="mailto:{{ $settings->email }}"
                           aria-label="Email Haseera"
                           class="w-9 h-9 rounded-lg border border-white/10 bg-white/5 flex items-center justify-center text-[#888] transition-all duration-200 hover:text-white hover:border-white/25 hover:bg-white/10 hover:-translate-y-0.5"
                           onmouseenter="this.style.boxShadow='0 0 14px rgba(152,0,239,0.30)'"
                           onmouseleave="this.style.boxShadow='none'">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </a>
                        @endif

                        @if($settings->tiktok_url)
                        <a href="{{ $settings->tiktok_url }}" target="_blank" rel="noopener noreferrer"
                           aria-label="TikTok Haseera"
                           class="w-9 h-9 rounded-lg border border-white/10 bg-white/5 flex items-center justify-center text-[#888] transition-all duration-200 hover:text-white hover:border-white/25 hover:bg-white/10 hover:-translate-y-0.5"
                           onmouseenter="this.style.boxShadow='0 0 14px rgba(152,0,239,0.30)'"
                           onmouseleave="this.style.boxShadow='none'">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                            </svg>
                        </a>
                        @endif

                        @if($settings->youtube_url)
                        <a href="{{ $settings->youtube_url }}" target="_blank" rel="noopener noreferrer"
                           aria-label="YouTube Haseera"
                           class="w-9 h-9 rounded-lg border border-white/10 bg-white/5 flex items-center justify-center text-[#888] transition-all duration-200 hover:text-white hover:border-white/25 hover:bg-white/10 hover:-translate-y-0.5"
                           onmouseenter="this.style.boxShadow='0 0 14px rgba(152,0,239,0.30)'"
                           onmouseleave="this.style.boxShadow='none'">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M23.495 6.205a3.007 3.007 0 0 0-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 0 0 .527 6.205a31.247 31.247 0 0 0-.522 5.805 31.247 31.247 0 0 0 .522 5.783 3.007 3.007 0 0 0 2.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 0 0 2.088-2.088 31.247 31.247 0 0 0 .5-5.783 31.247 31.247 0 0 0-.5-5.805zM9.609 15.601V8.408l6.264 3.602z"/>
                            </svg>
                        </a>
                        @endif

                        @if($settings->google_maps_url)
                        <a href="{{ $settings->google_maps_url }}" target="_blank" rel="noopener noreferrer"
                           aria-label="Lokasi Haseera di Google Maps"
                           class="w-9 h-9 rounded-lg border border-white/10 bg-white/5 flex items-center justify-center text-[#888] transition-all duration-200 hover:text-white hover:border-white/25 hover:bg-white/10 hover:-translate-y-0.5"
                           onmouseenter="this.style.boxShadow='0 0 14px rgba(181,255,65,0.20)'"
                           onmouseleave="this.style.boxShadow='none'">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </a>
                        @endif

                    </div>
                </div>

                {{-- Navigation --}}
                @php
                    $footerNav = $navItems->filter(fn($i) => in_array(
                        $i->navigation_location instanceof \App\Enums\NavigationLocation
                            ? $i->navigation_location->value
                            : $i->navigation_location,
                        ['footer','both']
                    ));
                @endphp
                @if($footerNav->isNotEmpty())
                <div class="min-w-0">
                    <h3 class="text-sm font-semibold text-white uppercase tracking-widest mb-4">Navigasi</h3>
                    <ul class="space-y-2">
                        @foreach($footerNav as $item)
                        <li>
                            <a href="{{ $item->url }}"
                               @if($item->open_new_tab) target="_blank" rel="noopener noreferrer" @endif
                               class="text-sm text-[#666] hover:text-white transition-colors">
                                {{ $item->label }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Contact --}}
                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-widest mb-4">Kontak</h3>
                    <ul class="space-y-3">
                        @if($settings->email)
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 shrink-0" style="color: #9800EF;" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <a href="mailto:{{ $settings->email }}" class="min-w-0 break-all text-sm text-[#666] hover:text-white transition-colors">{{ $settings->email }}</a>
                        </li>
                        @endif
                        @if($settings->phone)
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 shrink-0" style="color: #9800EF;" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <a href="tel:{{ $settings->phone }}" class="text-sm text-[#666] hover:text-white transition-colors">{{ $settings->phone }}</a>
                        </li>
                        @endif
                        @if($settings->address)
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 shrink-0" style="color: #9800EF;" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            @if($settings->google_maps_url)
                            <a href="{{ $settings->google_maps_url }}" target="_blank" rel="noopener noreferrer" class="text-sm text-[#666] hover:text-white transition-colors">{{ $settings->address }}</a>
                            @else
                            <span class="text-sm text-[#666]">{{ $settings->address }}</span>
                            @endif
                        </li>
                        @endif
                    </ul>
                </div>

            </div>

            {{-- Bottom bar --}}
            <div class="pt-8 border-t border-white/5 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-[#444]">
                    {{ $settings->footer_text ?? '© ' . date('Y') . ' ' . $settings->site_name . '. All rights reserved.' }}
                </p>
            </div>
        </div>
    </div>

</footer>
