@if($brands->isNotEmpty())
<section id="brands" class="pt-6 pb-12 sm:pt-8 sm:pb-14 relative">

    {{-- Heading --}}
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center mb-8">
        <p class="text-xs font-semibold text-purple-400 uppercase tracking-widest mb-2">
            Mitra Kami
        </p>
        <h2 class="text-xl sm:text-2xl font-bold text-white">
            Dipercaya oleh Berbagai Brand
        </h2>
    </div>

    @php $count = $brands->count(); @endphp

    @if($count === 1)
    {{-- Single brand: centered static --}}
    <div class="flex justify-center px-4">
        @include('components.sections._brand-item', ['brand' => $brands->first()])
    </div>

    @elseif($count <= 3)
    {{-- Few brands: static centered row --}}
    <div class="flex flex-wrap justify-center gap-4 px-4">
        @foreach($brands as $brand)
            @include('components.sections._brand-item', ['brand' => $brand])
        @endforeach
    </div>

    @else
    {{-- Many brands: continuous marquee with edge fade --}}
    <div class="brand-marquee">
        <div class="brand-track">

            {{-- Group 1: original --}}
            <div class="flex items-center gap-4" aria-label="Brand dan mitra kami">
                @foreach($brands as $brand)
                    @include('components.sections._brand-item', ['brand' => $brand])
                @endforeach
            </div>

            {{-- Group 2: duplicate for seamless loop --}}
            <div class="flex items-center gap-4" aria-hidden="true">
                @foreach($brands as $brand)
                    @include('components.sections._brand-item', ['brand' => $brand])
                @endforeach
            </div>

        </div>
    </div>
    @endif

</section>
@endif
