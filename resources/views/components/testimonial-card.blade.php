<article class="testimonial-card-item flex flex-col rounded-2xl border border-white/[0.08] bg-[#1A1A1A] p-6 hover:border-purple-500/30 transition-colors duration-300">

    {{-- Stars --}}
    @if($testimonial->rating)
    <div class="flex gap-1 mb-4" aria-label="Rating {{ $testimonial->rating }} dari 5">
        @for($i = 1; $i <= 5; $i++)
        <svg class="w-4 h-4 {{ $i <= $testimonial->rating ? 'text-amber-400' : 'text-white/10' }}"
             fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
        </svg>
        @endfor
    </div>
    @endif

    {{-- Quote --}}
    <blockquote class="text-[#B3B3B3] text-sm leading-relaxed flex-1 mb-6">
        "{{ $testimonial->content }}"
    </blockquote>

    {{-- Author --}}
    <div class="flex items-center gap-3 pt-4 border-t border-white/5">
        @if($testimonial->photo)
        <img src="{{ asset('storage/' . $testimonial->photo) }}"
             alt="{{ $testimonial->name }}"
             loading="lazy"
             class="w-10 h-10 rounded-full object-cover border border-white/10 shrink-0">
        @else
        <div class="w-10 h-10 rounded-full bg-purple-500/20 border border-purple-500/30 flex items-center justify-center text-purple-300 font-semibold text-sm shrink-0" aria-hidden="true">
            {{ strtoupper(substr($testimonial->name, 0, 1)) }}
        </div>
        @endif

        <div class="min-w-0">
            <div class="text-sm font-semibold text-white truncate">{{ $testimonial->name }}</div>
            @if($testimonial->position || $testimonial->company)
            <div class="text-xs text-[#666] truncate">
                {{ collect([$testimonial->position, $testimonial->company])->filter()->implode(', ') }}
            </div>
            @endif
        </div>
    </div>

</article>
