@php
    $hasLogo = $brand->logo && Storage::disk('public')->exists($brand->logo);
    $logoUrl = $hasLogo ? Storage::disk('public')->url($brand->logo) : null;
    $tag     = $brand->website_url ? 'a' : 'div';
    $scale   = max(70, min(180, (int) ($brand->logo_scale ?? 100)));
    $fallback = mb_strtoupper(mb_substr(trim($brand->name), 0, 2));
@endphp

<{{ $tag }}
    @if($brand->website_url)
        href="{{ $brand->website_url }}"
        target="_blank"
        rel="noopener noreferrer"
        aria-label="Kunjungi website {{ $brand->name }}"
    @endif
    @if(! $brand->website_url)
        aria-label="{{ $brand->name }}"
    @endif
    class="brand-card flex-none flex items-center justify-center rounded-[28px] transition-all duration-300 hover:-translate-y-1.5 {{ $brand->website_url ? 'cursor-pointer' : '' }}"
    style="
        background: linear-gradient(145deg, rgba(255,255,255,0.10) 0%, rgba(255,255,255,0.06) 50%, rgba(139,92,246,0.07) 100%);
        border: 1px solid rgba(255,255,255,0.13);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        box-shadow: 0 0 0 1px rgba(255,255,255,0.05) inset, 0 8px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(255,255,255,0.10);
        transition: border-color 300ms ease, box-shadow 300ms ease, transform 300ms ease;
    "
    onmouseenter="this.style.borderColor='rgba(139,92,246,0.30)'; this.style.boxShadow='0 0 0 1px rgba(255,255,255,0.06) inset, 0 14px 40px rgba(0,0,0,0.40), 0 0 28px rgba(109,40,217,0.14), inset 0 1px 0 rgba(255,255,255,0.10)';"
    onmouseleave="this.style.borderColor='rgba(255,255,255,0.13)'; this.style.boxShadow='0 0 0 1px rgba(255,255,255,0.05) inset, 0 8px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(255,255,255,0.10)';"
>
    @if($logoUrl)
        <img
            src="{{ $logoUrl }}"
            alt=""
            loading="lazy"
            class="object-contain brand-logo-img"
            style="transform: scale({{ $scale / 100 }}); transform-origin: center; max-width: 145px; max-height: 50px; width: auto; height: auto;"
            onerror="this.hidden=true; this.nextElementSibling.classList.remove('hidden'); this.nextElementSibling.classList.add('flex');"
        >
        <span class="hidden items-center justify-center text-lg font-bold tracking-wider text-white/55" aria-hidden="true">
            {{ $fallback }}
        </span>
    @else
        <span class="flex items-center justify-center text-lg font-bold tracking-wider text-white/55" aria-hidden="true">
            {{ $fallback }}
        </span>
    @endif
</{{ $tag }}>
