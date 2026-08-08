@php
    $hasLogo  = $brand->logo && Storage::disk('public')->exists($brand->logo);
    $logoUrl  = $hasLogo ? Storage::disk('public')->url($brand->logo) : null;
    $tag      = $brand->website_url ? 'a' : 'div';
    $bg       = $brand->logo_background ?? 'auto';
    $scale    = max(70, min(180, (int) ($brand->logo_scale ?? 100)));

    $plateStyle = match ($bg) {
        'light'       => 'background: #F5F5F5;',
        'dark'        => 'background: #1C1C1C;',
        'transparent' => 'background: transparent;',
        default       => 'background: rgba(245,245,245,0.92);', // auto = light-safe
    };
@endphp

<{{ $tag }}
    @if($brand->website_url)
        href="{{ $brand->website_url }}"
        target="_blank"
        rel="noopener noreferrer"
        aria-label="Kunjungi website {{ $brand->name }}"
    @endif
    class="brand-card flex-none flex items-center justify-center rounded-xl border border-white/[0.05] bg-white/[0.03] transition-all duration-300 hover:border-purple-500/25 hover:bg-white/[0.06] hover:scale-[1.01] {{ $brand->website_url ? 'cursor-pointer' : '' }}"
>
    {{-- Inner logo plate --}}
    <div
        class="brand-logo-plate flex items-center justify-center rounded-lg overflow-hidden"
        style="{{ $plateStyle }}"
    >
        @if($logoUrl)
            <img
                src="{{ $logoUrl }}"
                alt="{{ $brand->name }}"
                loading="lazy"
                class="object-contain brand-logo-img"
                style="transform: scale({{ $scale / 100 }}); transform-origin: center; max-width: 145px; max-height: 50px; width: auto; height: auto;"
            >
        @else
            <span class="text-[11px] font-semibold text-neutral-600 text-center leading-tight px-2">
                {{ $brand->name }}
            </span>
        @endif
    </div>
</{{ $tag }}>
