<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\NavigationItem;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        $settings = SiteSetting::instance();
        $navItems = NavigationItem::active()->ordered()->get();

        return view('contact.index', compact('settings', 'navItems'));
    }

    public function store(Request $request): RedirectResponse
    {
        // Honeypot: jika field website terisi, tolak diam-diam
        if ($request->filled('website')) {
            return redirect()->route('contact.index')
                ->with('success', 'Pesan berhasil dikirim. Tim kami akan segera menghubungi Anda.');
        }

        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:150'],
            'email'   => ['required', 'email', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:50'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ], [
            'name.required'    => 'Nama lengkap wajib diisi.',
            'name.max'         => 'Nama lengkap maksimal 150 karakter.',
            'email.required'   => 'Email wajib diisi.',
            'email.email'      => 'Format email tidak valid.',
            'email.max'        => 'Email maksimal 255 karakter.',
            'phone.max'        => 'Nomor telepon maksimal 50 karakter.',
            'subject.max'      => 'Subjek maksimal 255 karakter.',
            'message.required' => 'Pesan wajib diisi.',
            'message.min'      => 'Pesan minimal :min karakter.',
            'message.max'      => 'Pesan maksimal :max karakter.',
        ]);

        ContactMessage::create([
            ...$validated,
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 500),
        ]);

        return redirect()->route('contact.index')
            ->with('success', 'Pesan berhasil dikirim. Tim kami akan segera menghubungi Anda.');
    }
}
