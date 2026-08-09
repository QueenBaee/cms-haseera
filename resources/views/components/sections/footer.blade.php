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

                    {{-- Social media --}}
                    <div class="flex gap-3">
                        @foreach([
                            ['url' => $settings->instagram_url, 'label' => 'Instagram', 'icon' => 'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z'],
                            ['url' => $settings->facebook_url, 'label' => 'Facebook', 'icon' => 'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z'],
                            ['url' => $settings->youtube_url, 'label' => 'YouTube', 'icon' => 'M23.495 6.205a3.007 3.007 0 0 0-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 0 0 .527 6.205a31.247 31.247 0 0 0-.522 5.805 31.247 31.247 0 0 0 .522 5.783 3.007 3.007 0 0 0 2.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 0 0 2.088-2.088 31.247 31.247 0 0 0 .5-5.783 31.247 31.247 0 0 0-.5-5.805zM9.609 15.601V8.408l6.264 3.602z'],
                            ['url' => $settings->linkedin_url, 'label' => 'LinkedIn', 'icon' => 'M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z'],
                            ['url' => $settings->tiktok_url, 'label' => 'TikTok', 'icon' => 'M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z'],
                        ] as $social)
                            @if($social['url'])
                            <a href="{{ $social['url'] }}"
                               target="_blank" rel="noopener noreferrer"
                               aria-label="{{ $social['label'] }}"
                               class="w-9 h-9 rounded-lg border border-white/10 bg-white/5 flex items-center justify-center text-[#666] hover:text-white hover:border-white/20 hover:bg-white/10 transition-all duration-200">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="{{ $social['icon'] }}"/>
                                </svg>
                            </a>
                            @endif
                        @endforeach
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
                            <svg class="w-4 h-4 text-purple-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <a href="{{ route('contact.index') }}" class="min-w-0 break-all text-sm text-[#666] hover:text-white transition-colors">{{ $settings->email }}</a>
                        </li>
                        @endif
                        @if($settings->phone)
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-purple-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <a href="{{ route('contact.index') }}" class="text-sm text-[#666] hover:text-white transition-colors">{{ $settings->phone }}</a>
                        </li>
                        @endif
                        @if($settings->address)
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-purple-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-sm text-[#666]">{{ $settings->address }}</span>
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
