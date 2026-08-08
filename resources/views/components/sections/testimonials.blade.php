<section id="testimonials" class="py-20 bg-[#0e0e0e] relative overflow-hidden">

    <div class="absolute bottom-0 right-1/3 w-[500px] h-[400px] opacity-10 pointer-events-none" aria-hidden="true"
         style="background: radial-gradient(ellipse at center, #7C3AED 0%, transparent 70%);"></div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- Section heading --}}
        <div class="text-center mb-12">
            @if($settings->testimonials_eyebrow)
            <p class="text-sm font-semibold text-purple-400 uppercase tracking-widest mb-4">
                {{ $settings->testimonials_eyebrow }}
            </p>
            @endif
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">
                {{ $settings->testimonials_title ?? 'Klien yang Berkembang Bersama Kami' }}
            </h2>
            @if($settings->testimonials_description)
            <p class="text-[#A3A3A3] text-base max-w-2xl mx-auto">
                {{ $settings->testimonials_description }}
            </p>
            @endif
        </div>

    </div>

    @if($testimonials->isNotEmpty())

    {{-- Marquee viewport — full bleed, no max-width constraint --}}
    <div class="testimonial-marquee">
        <div class="testimonial-track">

            {{-- Group 1: original --}}
            <div class="flex gap-5" aria-label="Testimoni klien">
                @foreach($testimonials as $testimonial)
                @include('components.testimonial-card', ['testimonial' => $testimonial])
                @endforeach
            </div>

            {{-- Group 2: duplicate for seamless loop --}}
            <div class="flex gap-5" aria-hidden="true">
                @foreach($testimonials as $testimonial)
                @include('components.testimonial-card', ['testimonial' => $testimonial])
                @endforeach
            </div>

        </div>
    </div>

    @else
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <p class="text-center text-[#666]">Belum ada testimoni yang tersedia.</p>
    </div>
    @endif

</section>
