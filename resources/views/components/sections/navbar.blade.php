<header class="fixed top-0 left-0 right-0 z-50 border-b border-white/5 bg-[#111111]/90 backdrop-blur-md"
    x-data="{
        open: false,
        active: '',
        isHome: {{ request()->is('/') || request()->routeIs('home') ? 'true' : 'false' }},
        resolveUrl(url) {
            // Anchor-only link (#section): di non-home prefix dengan /
            if (url.startsWith('#')) return this.isHome ? url : '/' + url;
            return url;
        },
        init() {
            if (!this.isHome) return;
            const sections = document.querySelectorAll('section[id], div[id]');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) this.active = '#' + entry.target.id;
                });
            }, { rootMargin: '-40% 0px -55% 0px', threshold: 0 });
            sections.forEach(s => observer.observe(s));
        }
    }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">

            {{-- Logo --}}
            <a href="/" class="flex items-center gap-2 shrink-0" aria-label="{{ $settings->site_name }}">
                @if($settings->logo)
                    <img src="{{ asset('storage/' . $settings->logo) }}"
                         alt="{{ $settings->site_name }}"
                         class="h-8 w-auto">
                @else
                    <span class="text-xl font-bold tracking-tight text-white">
                        {{ $settings->site_name }}
                    </span>
                @endif
            </a>

            {{-- Desktop nav --}}
            <nav class="hidden md:flex items-center gap-1" aria-label="Navigasi utama">
                @foreach($navItems->filter(fn($i) => in_array($i->navigation_location instanceof \App\Enums\NavigationLocation ? $i->navigation_location->value : $i->navigation_location, ['header','both'])) as $item)
                    <a :href="resolveUrl('{{ $item->url }}')"
                       @if($item->open_new_tab) target="_blank" rel="noopener noreferrer" @endif
                       :class="active === '{{ $item->url }}' ? 'text-white bg-white/10' : 'text-[#A3A3A3] hover:text-white hover:bg-white/5'"
                       class="px-4 py-2 text-sm transition-colors duration-200 rounded-lg">
                        {{ $item->label }}
                    </a>
                @endforeach

                <a href="{{ route('contact.index') }}"
                   class="ml-4 px-5 py-2 text-sm font-semibold rounded-lg text-[#111111] hover:brightness-105 transition-all duration-200"
                   style="background-color: var(--btn-primary);">
                    Hubungi Kami
                </a>
            </nav>

            {{-- Mobile hamburger --}}
            <button @click="open = !open"
                    class="md:hidden p-2 rounded-lg text-[#A3A3A3] hover:text-white hover:bg-white/5 transition-colors"
                    aria-label="Toggle menu"
                    :aria-expanded="open">
                <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden border-t border-white/5 bg-[#141414]"
         style="display:none">
        <nav class="px-4 py-4 flex flex-col gap-1" aria-label="Navigasi mobile">
            @foreach($navItems->filter(fn($i) => in_array($i->navigation_location instanceof \App\Enums\NavigationLocation ? $i->navigation_location->value : $i->navigation_location, ['header','both'])) as $item)
                <a :href="resolveUrl('{{ $item->url }}')"
                   @click="open = false"
                   @if($item->open_new_tab) target="_blank" rel="noopener noreferrer" @endif
                   :class="active === '{{ $item->url }}' ? 'text-white bg-white/10' : 'text-[#A3A3A3] hover:text-white hover:bg-white/5'"
                   class="px-4 py-3 text-sm rounded-lg transition-colors">
                    {{ $item->label }}
                </a>
            @endforeach
            <a href="{{ route('contact.index') }}"
               @click="open = false"
               class="mt-2 px-4 py-3 text-sm font-semibold text-center rounded-lg text-[#111111] hover:brightness-105 transition-all duration-200"
               style="background-color: var(--btn-primary);">
                Hubungi Kami
            </a>
        </nav>
    </div>
</header>
