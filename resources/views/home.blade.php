<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- SEO --}}
    <title>{{ $settings->seo_title ?: $settings->site_name }}</title>
    <meta name="description" content="{{ $settings->seo_description ?: $settings->site_tagline }}">
    @if($settings->seo_keywords)
    <meta name="keywords" content="{{ $settings->seo_keywords }}">
    @endif
    <link rel="canonical" href="{{ url('/') }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="{{ $settings->seo_title ?: $settings->site_name }}">
    <meta property="og:description" content="{{ $settings->seo_description ?: $settings->site_tagline }}">
    @if($settings->og_image)
    <meta property="og:image" content="{{ asset('storage/' . $settings->og_image) }}">
    @endif

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $settings->seo_title ?: $settings->site_name }}">
    <meta name="twitter:description" content="{{ $settings->seo_description ?: $settings->site_tagline }}">

    {{-- Favicon --}}
    @if($settings->favicon)
    <link rel="icon" href="{{ asset('storage/' . $settings->favicon) }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body
    class="bg-[#111111] text-white antialiased"
    style="--btn-primary: {{ $settings?->button_color ?? '#b5ff41' }};"
>
    <div class="relative z-10">

    @include('components.sections.navbar', ['settings' => $settings, 'navItems' => $navItems])

    <main>
        @include('components.sections.hero', ['settings' => $settings])
        {{-- Stats + Brands share one gradient background --}}
        <div class="stats-brands-wrapper">
            @include('components.sections.statistics', ['statistics' => $statistics])
            @include('components.sections.brands', ['brands' => $brands])
        </div>
        @include('components.sections.about', ['settings' => $settings, 'benefits' => $benefits])
        @include('components.sections.services', ['settings' => $settings, 'services' => $services])
        @include('components.sections.portfolio', ['settings' => $settings, 'featuredPortfolios' => $featuredPortfolios, 'portfolios' => $portfolios, 'hasMorePortfolios' => $hasMorePortfolios])
        @include('components.sections.testimonials', ['settings' => $settings, 'testimonials' => $testimonials])
    </main>

    @include('components.sections.footer', ['settings' => $settings, 'navItems' => $navItems])
    </div>

</body>
</html>
