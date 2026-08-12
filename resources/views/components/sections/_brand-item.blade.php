@php
    $hasLogo = $brand->logo && Storage::disk('public')->exists($brand->logo);
    $logoUrl = $hasLogo ? Storage::disk('public')->url($brand->logo) : null;
    $tag     = $brand->website_url ? 'a' : 'div';
    $scale   = max(70, min(180, (int) ($brand->logo_scale ?? 100)));
@endphp

<{{ $tag }}
    @if($brand->website_url)
        href="{{ $brand->website_url }}"
        target="_blank"
        rel="noopener noreferrer"
        aria-label="Kunjungi website {{ $brand->name }}"
    @endif
    class="brand-card flex-none flex items-center justify-center rounded-[28px] transition-all duration-300 hover:-translate-y-1.5 {{ $brand->website_url ? 'cursor-pointer' : '' }}"
    style="
        background: linear-gradient(145deg, rgba(255,255,255,0.055) 0%, rgba(255,255,255,0.025) 50%, rgba(139,92,246,0.04) 100%);
        border: 1px solid rgba(255,255,255,0.09);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        box-shadow: 0 0 0 1px rgba(255,255,255,0.04) inset, 0 8px 48px rgba(0,0,0,0.45), inset 0 1px 0 rgba(255,255,255,0.07);
        transition: border-color 300ms ease, box-shadow 300ms ease, transform 300ms ease;
    "
    onmouseenter="this.style.borderColor='rgba(139,92,246,0.22)'; this.style.boxShadow='0 0 0 1px rgba(255,255,255,0.04) inset, 0 12px 56px rgba(0,0,0,0.50), 0 0 32px rgba(109,40,217,0.10), inset 0 1px 0 rgba(255,255,255,0.07)';"
    onmouseleave="this.style.borderColor='rgba(255,255,255,0.09)'; this.style.boxShadow='0 0 0 1px rgba(255,255,255,0.04) inset, 0 8px 48px rgba(0,0,0,0.45), inset 0 1px 0 rgba(255,255,255,0.07)';"
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
        <span class="text-[11px] font-semibold text-neutral-400 text-center leading-tight px-2">
            {{ $brand->name }}
        </span>
    @endif
</{{ $tag }}>
