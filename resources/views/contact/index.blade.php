<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak — {{ $settings->site_name }}</title>
    <meta name="description" content="Hubungi tim {{ $settings->site_name }}. Ceritakan kebutuhan proyek Anda.">
    <link rel="canonical" href="{{ url('/kontak') }}">
    @if($settings->favicon)
    <link rel="icon" href="{{ asset('storage/' . $settings->favicon) }}">
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#111111] text-white antialiased">

    @include('components.sections.navbar', ['settings' => $settings, 'navItems' => $navItems])

    <main>

        {{-- ── CONTACT HERO ──────────────────────────────────────────────── --}}
        <section class="relative pt-32 pb-16 sm:pt-36 sm:pb-20 overflow-hidden">
            {{-- Background glow --}}
            <div class="absolute inset-0 pointer-events-none" aria-hidden="true"
                 style="background: radial-gradient(ellipse at 50% 0%, rgba(124,58,237,0.18) 0%, transparent 60%);"></div>
            <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-purple-500/30 to-transparent"></div>

            <div class="relative mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
                <p class="inline-block text-xs font-semibold text-purple-400 uppercase tracking-widest mb-4 px-3 py-1 rounded-full border border-purple-500/20 bg-purple-500/10">
                    {{ $settings->contact_badge ?: 'Kontak Kami' }}
                </p>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4 leading-tight">
                    {{ $settings->contact_title ?: 'Mari Wujudkan Ide Anda Bersama Kami' }}
                </h1>
                <p class="text-[#A3A3A3] text-base sm:text-lg max-w-2xl mx-auto mb-8">
                    {{ $settings->contact_description ?: 'Punya proyek, kebutuhan produksi, atau ingin berdiskusi? Hubungi tim kami dan ceritakan kebutuhan Anda.' }}
                </p>
                <div class="flex flex-wrap items-center justify-center gap-3">
                    <a href="#contact-form"
                       class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-[#20C997] text-[#111111] font-semibold text-sm hover:bg-[#1aad82] transition-all duration-200 hover:scale-105 shadow-lg shadow-emerald-500/20">
                        Kirim Permintaan
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>
                    @if($settings->whatsapp)
                    @php
                        $wa = preg_replace('/\D/', '', $settings->whatsapp);
                        if (str_starts_with($wa, '0')) $wa = '62' . substr($wa, 1);
                        $waUrl = 'https://wa.me/' . $wa;
                    @endphp
                    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-white/10 bg-white/5 text-white font-semibold text-sm hover:bg-white/10 hover:border-white/20 transition-all duration-200">
                        <svg class="w-4 h-4 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        WhatsApp Sekarang
                    </a>
                    @endif
                </div>
            </div>
        </section>

        {{-- ── MAIN CONTENT: INFO + FORM ─────────────────────────────────── --}}
        <section class="pb-20 sm:pb-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                {{-- Flash success --}}
                @if(session('success'))
                <div class="mb-8 flex items-start gap-3 rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-5 py-4 text-emerald-400"
                     x-data="{ show: true }" x-show="show" x-transition>
                    <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                    <button @click="show = false" class="ml-auto text-emerald-400/60 hover:text-emerald-400 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 lg:gap-12">

                    {{-- ── LEFT: Informasi Kontak ──────────────────────── --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div>
                            <p class="text-xs font-semibold text-purple-400 uppercase tracking-widest mb-2">Informasi</p>
                            <h2 class="text-xl sm:text-2xl font-bold text-white">Informasi Kontak</h2>
                        </div>

                        <div class="space-y-4">
                            @if($settings->address)
                            <div class="flex items-start gap-4 p-4 rounded-xl bg-white/[0.03] border border-white/[0.06]">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0" style="background: rgba(152,0,239,0.10); border: 1px solid rgba(152,0,239,0.20);">
                                    <svg class="w-5 h-5" style="color: #9800EF;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-[#666] uppercase tracking-wider mb-1">Alamat</p>
                                    @if($settings->google_maps_url)
                                    <a href="{{ $settings->google_maps_url }}" target="_blank" rel="noopener noreferrer"
                                       class="text-sm text-[#D4D4D4] hover:text-white transition-colors leading-relaxed">{{ $settings->address }}</a>
                                    @else
                                    <p class="text-sm text-[#D4D4D4] leading-relaxed">{{ $settings->address }}</p>
                                    @endif
                                </div>
                            </div>
                            @endif

                            @if($settings->phone)
                            <div class="flex items-start gap-4 p-4 rounded-xl bg-white/[0.03] border border-white/[0.06]">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0" style="background: rgba(152,0,239,0.10); border: 1px solid rgba(152,0,239,0.20);">
                                    <svg class="w-5 h-5" style="color: #9800EF;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-[#666] uppercase tracking-wider mb-1">Telepon</p>
                                    <a href="tel:{{ $settings->phone }}" class="text-sm text-[#D4D4D4] hover:text-white transition-colors">{{ $settings->phone }}</a>
                                </div>
                            </div>
                            @endif

                            @if($settings->email)
                            <div class="flex items-start gap-4 p-4 rounded-xl bg-white/[0.03] border border-white/[0.06]">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0" style="background: rgba(152,0,239,0.10); border: 1px solid rgba(152,0,239,0.20);">
                                    <svg class="w-5 h-5" style="color: #9800EF;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-[#666] uppercase tracking-wider mb-1">Email</p>
                                    <a href="mailto:{{ $settings->email }}" class="text-sm text-[#D4D4D4] hover:text-white transition-colors break-all">{{ $settings->email }}</a>
                                </div>
                            </div>
                            @endif

                            @if($settings->whatsapp)
                            @php
                                $wa = preg_replace('/\D/', '', $settings->whatsapp);
                                if (str_starts_with($wa, '0')) $wa = '62' . substr($wa, 1);
                                $waUrl = 'https://wa.me/' . $wa;
                            @endphp
                            <div class="flex items-start gap-4 p-4 rounded-xl bg-white/[0.03] border border-white/[0.06]">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0" style="background: rgba(152,0,239,0.10); border: 1px solid rgba(152,0,239,0.20);">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" style="color: #9800EF;">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-[#666] uppercase tracking-wider mb-1">WhatsApp</p>
                                    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
                                       class="text-sm text-[#D4D4D4] hover:text-white transition-colors">{{ $settings->whatsapp }}</a>
                                </div>
                            </div>
                            @endif
                        </div>

                        {{-- Quick WhatsApp Box --}}
                        @if($settings->whatsapp)
                        <div class="p-5 rounded-2xl border border-purple-500/20 bg-gradient-to-br from-purple-500/10 to-purple-900/10">
                            <h3 class="text-base font-semibold text-white mb-1">
                                {{ $settings->contact_quick_title ?: 'Butuh respons cepat?' }}
                            </h3>
                            <p class="text-sm text-[#A3A3A3] mb-4">
                                {{ $settings->contact_quick_description ?: 'Chat langsung melalui WhatsApp — tim kami siap membantu.' }}
                            </p>
                            <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#20C997] text-[#111111] font-semibold text-sm hover:bg-[#1aad82] transition-all duration-200 hover:scale-105">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                                Buka WhatsApp
                            </a>
                        </div>
                        @endif
                    </div>

                    {{-- ── RIGHT: Form ─────────────────────────────────── --}}
                    <div id="contact-form" class="lg:col-span-3">
                        <div class="p-6 sm:p-8 rounded-2xl border border-white/[0.07] bg-white/[0.03]">
                            <p class="text-xs font-semibold text-purple-400 uppercase tracking-widest mb-2">Form</p>
                            <h2 class="text-xl sm:text-2xl font-bold text-white mb-6">
                                {{ $settings->contact_form_title ?: 'Kirim Pesan' }}
                            </h2>

                            <form method="POST" action="{{ route('contact.store') }}"
                                  x-data="{ submitting: false }"
                                  @submit="submitting = true"
                                  id="contact-form-el">
                                @csrf

                                {{-- Honeypot --}}
                                <div class="hidden" aria-hidden="true">
                                    <input type="text" name="website" tabindex="-1" autocomplete="off">
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                    {{-- Nama --}}
                                    <div>
                                        <label for="name" class="block text-xs font-medium text-[#A3A3A3] uppercase tracking-wider mb-1.5">
                                            Nama Lengkap <span class="text-red-400">*</span>
                                        </label>
                                        <input type="text" id="name" name="name"
                                               value="{{ old('name') }}"
                                               placeholder="Nama Anda"
                                               class="contact-input w-full @error('name') border-red-500/60 @enderror"
                                               required>
                                        @error('name')
                                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Email --}}
                                    <div>
                                        <label for="email" class="block text-xs font-medium text-[#A3A3A3] uppercase tracking-wider mb-1.5">
                                            Email <span class="text-red-400">*</span>
                                        </label>
                                        <input type="email" id="email" name="email"
                                               value="{{ old('email') }}"
                                               placeholder="email@domain.com"
                                               class="contact-input w-full @error('email') border-red-500/60 @enderror"
                                               required>
                                        @error('email')
                                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                    {{-- Phone --}}
                                    <div>
                                        <label for="phone" class="block text-xs font-medium text-[#A3A3A3] uppercase tracking-wider mb-1.5">
                                            Nomor Telepon / WhatsApp
                                        </label>
                                        <input type="text" id="phone" name="phone"
                                               value="{{ old('phone') }}"
                                               placeholder="08xxxxxxxxxx"
                                               class="contact-input w-full @error('phone') border-red-500/60 @enderror">
                                        @error('phone')
                                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Subject --}}
                                    <div>
                                        <label for="subject" class="block text-xs font-medium text-[#A3A3A3] uppercase tracking-wider mb-1.5">
                                            Subjek
                                        </label>
                                        <input type="text" id="subject" name="subject"
                                               value="{{ old('subject') }}"
                                               placeholder="Topik pesan Anda"
                                               class="contact-input w-full @error('subject') border-red-500/60 @enderror">
                                        @error('subject')
                                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Message --}}
                                <div class="mb-6">
                                    <label for="message" class="block text-xs font-medium text-[#A3A3A3] uppercase tracking-wider mb-1.5">
                                        Pesan <span class="text-red-400">*</span>
                                    </label>
                                    <textarea id="message" name="message" rows="6"
                                              placeholder="Ceritakan kebutuhan Anda — jenis proyek, waktu pelaksanaan, lokasi, anggaran, atau detail lainnya."
                                              class="contact-input w-full resize-none @error('message') border-red-500/60 @enderror"
                                              required>{{ old('message') }}</textarea>
                                    @error('message')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit"
                                        :disabled="submitting"
                                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-xl bg-[#20C997] text-[#111111] font-bold text-sm hover:bg-[#1aad82] transition-all duration-200 hover:scale-[1.02] shadow-lg shadow-emerald-500/20 disabled:opacity-60 disabled:cursor-not-allowed disabled:scale-100">
                                    <span x-show="!submitting">Kirim Pesan</span>
                                    <span x-show="submitting" style="display:none">Mengirim...</span>
                                    <svg x-show="!submitting" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>

    @include('components.sections.footer', ['settings' => $settings, 'navItems' => $navItems])

    {{-- ── VALIDATION ERROR MODAL ──────────────────────────────────────── --}}
    @if($errors->any())
    <div x-data="{ open: true }"
         x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @keydown.escape.window="open = false"
         class="fixed inset-0 z-[9999] flex items-center justify-center"
         style="padding: 16px; background: rgba(0,0,0,0.65); backdrop-filter: blur(3px);">

        <div x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             style="width: calc(100% - 32px); max-width: 480px; background: rgba(18,10,30,0.97); border: 1px solid rgba(152,0,239,0.40); border-radius: 20px; padding: 28px; box-shadow: 0 20px 60px rgba(0,0,0,0.55), 0 0 32px rgba(152,0,239,0.10);">

            {{-- Header: title + close --}}
            <div class="flex items-start justify-between gap-3 mb-4">
                <div class="flex items-center gap-3">
                    <div style="width:36px; height:36px; border-radius:10px; background:rgba(239,68,68,0.12); border:1px solid rgba(239,68,68,0.28); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <svg style="width:18px;height:18px;color:#f87171;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 style="font-size:17px; font-weight:700; color:#fff; line-height:1.3;">Form Belum Lengkap</h3>
                        <p style="font-size:13px; color:#a3a3a3; margin-top:2px;">Mohon periksa kembali data yang Anda masukkan.</p>
                    </div>
                </div>
                <button @click="open = false"
                        style="color:#666; padding:4px; border-radius:6px; line-height:1; flex-shrink:0;"
                        class="hover:text-white transition-colors">
                    <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Divider --}}
            <div style="height:1px; background:rgba(255,255,255,0.06); margin-bottom:16px;"></div>

            {{-- Error list --}}
            <ul style="margin-bottom:20px; display:flex; flex-direction:column; gap:8px;">
                @foreach($errors->all() as $error)
                <li style="display:flex; align-items:flex-start; gap:10px; font-size:13.5px; color:#d4d4d4;">
                    <span style="margin-top:6px; width:6px; height:6px; border-radius:50%; background:#f87171; flex-shrink:0;"></span>
                    {{ $error }}
                </li>
                @endforeach
            </ul>

            {{-- Footer: button kanan --}}
            <div style="display:flex; justify-content:flex-end;">
                <button @click="open = false; $nextTick(() => { const el = document.querySelector('#contact-form-el input.border-red-500\/60, #contact-form-el textarea.border-red-500\/60'); if(el) el.focus(); })"
                        style="background:#b5ff41; color:#111111; font-weight:600; font-size:13.5px; padding:0 22px; height:42px; border-radius:11px; transition:filter 0.15s, transform 0.15s;"
                        class="hover:brightness-105 hover:scale-[1.02]">
                    Periksa Kembali
                </button>
            </div>
        </div>
    </div>
    @endif

</body>
</html>
