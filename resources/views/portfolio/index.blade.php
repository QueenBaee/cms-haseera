<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Portfolio — {{ $settings->site_name }}</title>
    <meta name="description" content="Seluruh proyek dan karya {{ $settings->site_name }}.">
    <link rel="canonical" href="{{ url('/portfolio') }}">

    @if($settings->favicon)
    <link rel="icon" href="{{ asset('storage/' . $settings->favicon) }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body
    class="bg-[#111111] text-white antialiased"
    style="
        @if(filled($settings?->background_image))
            background-image: url('{{ \Illuminate\Support\Facades\Storage::disk('public')->url($settings->background_image) }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        @endif
        --btn-primary: {{ $settings?->button_color ?? '#b5ff41' }};
    "
>
    @if(filled($settings?->background_image))
        <div class="fixed inset-0 z-0 bg-black/50 pointer-events-none" aria-hidden="true"></div>
    @endif

    <div class="relative z-10">

    @include('components.sections.navbar', ['settings' => $settings, 'navItems' => $navItems])

    <main class="pt-16">

        {{-- ── Page Hero ────────────────────────────────────────────────────── --}}
        <div class="relative py-16 sm:py-20 overflow-hidden">
            <div class="absolute inset-0 pointer-events-none" aria-hidden="true"
                 style="background: radial-gradient(ellipse at 50% 0%, rgba(124,58,237,0.15) 0%, transparent 60%);"></div>
            <div class="absolute inset-0 bg-grid opacity-40 pointer-events-none" aria-hidden="true"></div>

            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
                <p class="text-sm font-semibold text-purple-400 uppercase tracking-widest mb-4">Portfolio</p>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4">
                    Proyek &amp; Karya Kami
                </h1>
                <p class="text-[#A3A3A3] text-base sm:text-lg max-w-xl mx-auto">
                    Kumpulan proyek yang telah kami kerjakan bersama klien dari berbagai industri.
                </p>
            </div>
        </div>

        {{-- ── Portfolio Grid ───────────────────────────────────────────────── --}}
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pb-20">

            @if($portfolios->isNotEmpty())

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($portfolios as $portfolio)
                <article class="group flex flex-col rounded-2xl border border-white/[0.08] bg-[#1A1A1A] overflow-hidden hover:border-purple-500/30 transition-all duration-300">

                    {{-- Image --}}
                    <div class="relative overflow-hidden bg-[#141414]">
                        <div class="aspect-[16/10]">
                            @if($portfolio->thumbnail || $portfolio->cover_image)
                            <img src="{{ asset('storage/' . ($portfolio->thumbnail ?? $portfolio->cover_image)) }}"
                                 alt="{{ $portfolio->title }}"
                                 loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                            <div class="w-full h-full flex items-center justify-center"
                                 style="background: linear-gradient(135deg, rgba(124,58,237,0.15) 0%, rgba(20,20,20,1) 100%);">
                                <svg class="w-12 h-12 text-purple-500/20" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            @endif
                        </div>

                        {{-- Badges --}}
                        <div class="absolute top-3 left-3 flex items-center gap-2">
                            @if($portfolio->is_featured)
                            <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-purple-500/30 border border-purple-500/40 text-purple-200">
                                ★ Featured
                            </span>
                            @endif
                            @if($portfolio->category)
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-black/50 border border-white/10 text-white/70">
                                {{ $portfolio->category->name }}
                            </span>
                            @endif
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="flex flex-col flex-1 p-5">

                        @if($portfolio->client_name)
                        <p class="text-xs font-semibold text-purple-400 uppercase tracking-widest mb-1.5">
                            {{ $portfolio->client_name }}
                        </p>
                        @endif

                        <h2 class="text-base font-bold text-white mb-2 group-hover:text-purple-200 transition-colors leading-tight">
                            {{ $portfolio->title }}
                        </h2>

                        @if($portfolio->short_description)
                        <p class="text-[#A3A3A3] text-sm leading-relaxed mb-3 line-clamp-2 flex-1">
                            {{ $portfolio->short_description }}
                        </p>
                        @endif

                        @if($portfolio->technologies && count($portfolio->technologies))
                        <div class="flex flex-wrap gap-1.5 mb-4">
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
                           class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#20C997] hover:text-[#1aad82] transition-colors mt-auto self-start">
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

            {{-- ── Pagination ───────────────────────────────────────────────── --}}
            @if($portfolios->hasPages())
            <div class="mt-12 flex items-center justify-center gap-1">
                {{-- Previous --}}
                @if($portfolios->onFirstPage())
                <span class="px-3 py-2 rounded-lg text-sm text-white/20 cursor-not-allowed select-none">
                    ← Sebelumnya
                </span>
                @else
                <a href="{{ $portfolios->previousPageUrl() }}"
                   class="px-3 py-2 rounded-lg text-sm text-[#A3A3A3] hover:text-white hover:bg-white/5 border border-white/[0.08] hover:border-white/20 transition-all duration-200">
                    ← Sebelumnya
                </a>
                @endif

                {{-- Page numbers --}}
                @foreach($portfolios->getUrlRange(1, $portfolios->lastPage()) as $page => $url)
                @if($page == $portfolios->currentPage())
                <span class="w-9 h-9 flex items-center justify-center rounded-lg text-sm font-semibold bg-purple-600 text-white border border-purple-500">
                    {{ $page }}
                </span>
                @else
                <a href="{{ $url }}"
                   class="w-9 h-9 flex items-center justify-center rounded-lg text-sm text-[#A3A3A3] hover:text-white hover:bg-white/5 border border-white/[0.08] hover:border-white/20 transition-all duration-200">
                    {{ $page }}
                </a>
                @endif
                @endforeach

                {{-- Next --}}
                @if($portfolios->hasMorePages())
                <a href="{{ $portfolios->nextPageUrl() }}"
                   class="px-3 py-2 rounded-lg text-sm text-[#A3A3A3] hover:text-white hover:bg-white/5 border border-white/[0.08] hover:border-white/20 transition-all duration-200">
                    Berikutnya →
                </a>
                @else
                <span class="px-3 py-2 rounded-lg text-sm text-white/20 cursor-not-allowed select-none">
                    Berikutnya →
                </span>
                @endif
            </div>
            @endif

            @else
            {{-- Empty state --}}
            <div class="py-24 text-center">
                <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-500/40" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="text-[#666] text-sm">Belum ada proyek yang ditampilkan.</p>
            </div>
            @endif

        </div>

    </main>

    @include('components.sections.footer', ['settings' => $settings, 'navItems' => $navItems])
    </div>

</body>
</html>
