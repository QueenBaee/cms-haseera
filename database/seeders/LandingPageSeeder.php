<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\AboutBenefit;
use App\Models\AboutFeature;
use App\Models\AboutSection;
use App\Models\CallToActionSetting;
use App\Models\CompanyStatistic;
use App\Models\HeroSlide;
use App\Models\LandingPageSetting;
use App\Models\NavigationItem;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\SocialMediaLink;
use App\Models\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LandingPageSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Site Settings (singleton)
        SiteSetting::updateOrCreate(['id' => 1], [
            'site_name' => 'Haseera',
            'site_tagline' => 'Creative Digital Agency',
            'company_description' => 'Kami adalah studio kreatif yang menghadirkan solusi digital premium — dari motion design, visual production, hingga pengalaman digital yang imersif.',
            'phone' => '085691420774',
            'whatsapp' => '085691420774',
            'email' => 'haseeradigitalcreative@gmail.com',
            'address' => 'Jl. Sudirman No. 123, Jakarta Selatan, DKI Jakarta 12190',
            'google_maps_url' => 'https://maps.app.goo.gl/YxLTqtZxuRSmWUEt6',
            'instagram_url' => 'https://instagram.com/haseeradigitalcreative',
            'facebook_url' => null,
            'youtube_url' => null,
            'linkedin_url' => null,
            'tiktok_url' => null,
            'footer_text' => '© '.date('Y').' Haseera. All rights reserved.',
            'seo_title' => 'Haseera — Creative Digital Agency',
            'seo_description' => 'Studio kreatif untuk motion design, visual production, dan pengalaman digital yang imersif.',
            'hero_badge' => 'Creative Digital Agency',
            'hero_title' => "Motion\nDigital & Visual Production\nCreative Design",
            'hero_description' => 'Kami menghadirkan pengalaman visual yang memukau dan solusi digital yang mendorong pertumbuhan bisnis Anda ke level berikutnya.',
            'hero_primary_button_text' => 'Mulai Proyek',
            'hero_primary_button_url' => '#contact',
            'hero_secondary_button_text' => 'Lihat Portofolio',
            'hero_secondary_button_url' => '#portfolio',
            'about_eyebrow' => 'Tentang Kami',
            'about_title' => "Mitra Kreatif untuk\nTransformasi Digital Anda",
            'about_description' => 'Haseera hadir sebagai mitra strategis dalam perjalanan transformasi digital Anda. Dengan tim yang berpengalaman dan pendekatan yang inovatif, kami memastikan setiap proyek menghasilkan dampak nyata.',
            'services_eyebrow' => 'Layanan Kami',
            'services_title' => 'Solusi Kreatif untuk Kebutuhan Anda',
            'services_description' => 'Dari konsep hingga eksekusi, kami menyediakan layanan lengkap untuk kebutuhan digital dan kreatif bisnis Anda.',
            'projects_eyebrow' => 'Portofolio',
            'projects_title' => 'Kolaborasi & Proyek Unggulan',
            'projects_description' => 'Setiap proyek adalah cerita sukses yang kami bangun bersama klien kami.',
            'testimonials_eyebrow' => 'Testimoni',
            'testimonials_title' => 'Klien yang Berkembang Bersama Kami',
            'testimonials_description' => 'Kepercayaan klien adalah motivasi terbesar kami untuk terus berinovasi.',
            'cta_title' => 'Punya Ide Project? Mari Diskusi',
            'cta_description' => 'Ceritakan visi Anda kepada kami. Tim kami siap membantu mewujudkan ide menjadi kenyataan.',
            'cta_button_text' => 'Hubungi Kami Sekarang',
            'cta_button_url' => 'mailto:hello@haseera.id',
        ]);

        // Legacy LandingPageSetting (singleton)
        LandingPageSetting::updateOrCreate(['id' => 1], [
            'site_name' => 'Haseera',
            'company_name' => 'PT Haseera Indonesia',
            'site_tagline' => 'Creative Digital Agency',
            'primary_email' => 'haseeradigitalcreative@gmail.com',
            'whatsapp' => '085691420774',
            'google_maps_url' => 'https://maps.app.goo.gl/YxLTqtZxuRSmWUEt6',
            'instagram_url' => 'https://instagram.com/haseeradigitalcreative',
            'tiktok_url' => null,
            'youtube_url' => null,
        ]);

        // CallToActionSetting (singleton)
        CallToActionSetting::updateOrCreate(['id' => 1], [
            'title' => 'Punya Ide Project? Mari Diskusi',
            'primary_button_text' => 'Hubungi Kami',
            'primary_button_url' => '#contact',
            'is_active' => true,
        ]);

        // Navigation items (5)
        $navItems = [
            ['label' => 'Beranda',    'url' => '#hero',      'navigation_location' => 'both',   'sort_order' => 1],
            ['label' => 'Tentang',    'url' => '#about',     'navigation_location' => 'both',   'sort_order' => 2],
            ['label' => 'Layanan',    'url' => '#services',  'navigation_location' => 'both',   'sort_order' => 3],
            ['label' => 'Portofolio', 'url' => '#portfolio', 'navigation_location' => 'both',   'sort_order' => 4],
            ['label' => 'Kontak',     'url' => '#contact',   'navigation_location' => 'footer', 'sort_order' => 5],
        ];
        foreach ($navItems as $item) {
            NavigationItem::withTrashed()->updateOrCreate(
                ['label' => $item['label']],
                array_merge($item, ['is_active' => true])
            );
        }

        // Hero slides (2)
        $heroSlides = [
            ['title' => 'Solusi Digital untuk Bisnis Anda', 'sort_order' => 1, 'is_active' => true],
            ['title' => 'Inovasi Tanpa Batas',              'sort_order' => 2, 'is_active' => true],
        ];
        foreach ($heroSlides as $slide) {
            HeroSlide::withTrashed()->updateOrCreate(['title' => $slide['title']], $slide);
        }

        // Company statistics (3)
        $statistics = [
            ['value' => '50++', 'label' => 'Proyek dan event sukses', 'sort_order' => 1],
            ['value' => '20+', 'label' => 'Dipercaya oleh perusahaan/instansi lokal & internasional', 'sort_order' => 2],
            ['value' => '2thn+', 'label' => 'Pengalaman didalam industri', 'sort_order' => 3],
        ];

        $activeStatisticIds = [];

        foreach ($statistics as $stat) {
            $companyStatistic = CompanyStatistic::withTrashed()->updateOrCreate(
                ['sort_order' => $stat['sort_order']],
                array_merge($stat, [
                    'prefix' => null,
                    'suffix' => null,
                    'description' => null,
                    'is_active' => true,
                    'deleted_at' => null,
                ])
            );

            $activeStatisticIds[] = $companyStatistic->id;
        }

        CompanyStatistic::query()
            ->whereNotIn('id', $activeStatisticIds)
            ->delete();

        // About benefits
        $benefits = [
            ['title' => 'Kreativitas & Teknologi',         'sort_order' => 1],
            ['title' => 'Tim Profesional & Berpengalaman', 'sort_order' => 2],
            ['title' => 'Tepat Waktu & Efisien',           'sort_order' => 3],
            ['title' => 'Hasil Berkualitas Premium',       'sort_order' => 4],
            ['title' => 'Dukungan Penuh Pasca-Proyek',     'sort_order' => 5],
        ];
        foreach ($benefits as $benefit) {
            AboutBenefit::updateOrCreate(
                ['title' => $benefit['title']],
                array_merge($benefit, ['is_active' => true])
            );
        }

        // About section (1) with features (4)
        $about = AboutSection::withTrashed()->updateOrCreate(
            ['title' => 'Tentang Haseera'],
            [
                'eyebrow' => 'Tentang Kami',
                'title' => 'Tentang Haseera',
                'short_description' => 'Studio kreatif untuk solusi digital premium.',
                'description' => 'Haseera hadir sebagai mitra terpercaya dalam perjalanan transformasi digital bisnis Anda.',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );
        $features = [
            ['title' => 'Tim Berpengalaman', 'sort_order' => 1],
            ['title' => 'Teknologi Modern',  'sort_order' => 2],
            ['title' => 'Dukungan 24/7',     'sort_order' => 3],
            ['title' => 'Harga Terjangkau',  'sort_order' => 4],
        ];
        foreach ($features as $feature) {
            AboutFeature::updateOrCreate(
                ['about_section_id' => $about->id, 'title' => $feature['title']],
                array_merge($feature, ['about_section_id' => $about->id, 'is_active' => true])
            );
        }

        // Services (3)
        $services = [
            [
                'title' => 'Graphic Design',
                'slug' => 'graphic-design',
                'short_description' => 'Solusi desain grafis profesional untuk kebutuhan visual brand Anda.',
                'items' => [
                    ['label' => '2D & 3D Design'],
                    ['label' => 'Interior & Eksterior Design'],
                    ['label' => 'Stage, Booth Exhibition Design'],
                ],
                'sort_order' => 1,
                'is_featured' => false,
            ],
            [
                'title' => 'Visual Event',
                'slug' => 'visual-event',
                'short_description' => 'Konten visual imersif untuk event dan pertunjukan yang memukau.',
                'items' => [
                    ['label' => 'Bumper Event Animation'],
                    ['label' => 'Motion Graphic Design'],
                    ['label' => 'Wedding Background Animation'],
                    ['label' => 'LED Visual Content'],
                ],
                'sort_order' => 2,
                'is_featured' => true,
            ],
            [
                'title' => 'Video Production',
                'slug' => 'video-production',
                'short_description' => 'Produksi video berkualitas tinggi dari konsep hingga hasil akhir.',
                'items' => [
                    ['label' => 'Editing'],
                    ['label' => 'Company Profile'],
                    ['label' => 'Event Teaser'],
                    ['label' => 'Wedding Teaser'],
                    ['label' => 'Executive Spotlight'],
                ],
                'sort_order' => 3,
                'is_featured' => false,
            ],
        ];
        foreach ($services as $service) {
            Service::withTrashed()->updateOrCreate(
                ['title' => $service['title']],
                array_merge($service, ['is_active' => true])
            );
        }

        // Portfolio categories (3)
        $categories = [
            ['name' => 'Motion Design',     'slug' => 'motion-design',     'sort_order' => 1],
            ['name' => 'Visual Production', 'slug' => 'visual-production', 'sort_order' => 2],
            ['name' => 'Branding',          'slug' => 'branding',          'sort_order' => 3],
        ];
        $categoryIds = [];
        foreach ($categories as $cat) {
            $category = PortfolioCategory::withTrashed()->updateOrCreate(
                ['name' => $cat['name']],
                array_merge($cat, ['is_active' => true])
            );
            $categoryIds[$cat['name']] = $category->id;
        }

        // Portfolios (6)
        $portfolios = [
            ['title' => 'Brand Film — Startup Fintech',    'slug' => 'brand-film-startup-fintech',    'category' => 'Motion Design',    'client_name' => 'FinPay Indonesia',   'sort_order' => 1],
            ['title' => 'Campaign Visual — Fashion Brand', 'slug' => 'campaign-visual-fashion-brand', 'category' => 'Visual Production', 'client_name' => 'Nusantara Wear',     'sort_order' => 2],
            ['title' => 'Identitas Visual — Tech Company', 'slug' => 'identitas-visual-tech-company', 'category' => 'Branding',          'client_name' => 'TechNova Labs',      'sort_order' => 3],
            ['title' => 'Motion Reel — Event Organizer',   'slug' => 'motion-reel-event-organizer',   'category' => 'Motion Design',    'client_name' => 'Spekta Events',      'sort_order' => 4],
            ['title' => 'Product Launch — FMCG Brand',     'slug' => 'product-launch-fmcg-brand',     'category' => 'Visual Production', 'client_name' => 'Segar Nusantara',    'sort_order' => 5],
            ['title' => 'Rebranding — Hospitality Group',  'slug' => 'rebranding-hospitality-group',  'category' => 'Branding',          'client_name' => 'Archipelago Hotels', 'sort_order' => 6],
        ];
        foreach ($portfolios as $portfolio) {
            Portfolio::withTrashed()->updateOrCreate(
                ['title' => $portfolio['title']],
                [
                    'title' => $portfolio['title'],
                    'slug' => $portfolio['slug'],
                    'portfolio_category_id' => $categoryIds[$portfolio['category']],
                    'client_name' => $portfolio['client_name'],
                    'short_description' => 'Proyek '.$portfolio['title'].' yang berhasil meningkatkan brand awareness klien secara signifikan.',
                    'sort_order' => $portfolio['sort_order'],
                    'is_active' => true,
                    'is_featured' => $portfolio['sort_order'] <= 2,
                ]
            );
        }

        // Testimonials (4)
        $testimonials = [
            ['name' => 'Rizky Pratama', 'position' => 'CEO',               'company' => 'FinPay Indonesia', 'content' => 'Haseera benar-benar memahami visi kami. Hasil kerjanya melampaui ekspektasi dan timeline selalu tepat.', 'rating' => 5, 'sort_order' => 1],
            ['name' => 'Sari Dewi',     'position' => 'Brand Manager',     'company' => 'Nusantara Wear',   'content' => 'Tim yang sangat kreatif dan profesional. Konten visual yang mereka buat viral di semua platform kami.', 'rating' => 5, 'sort_order' => 2],
            ['name' => 'Budi Santoso',  'position' => 'Founder',           'company' => 'TechNova Labs',    'content' => 'Identitas visual baru kami mendapat respons luar biasa dari investor dan pelanggan. Terima kasih Haseera!', 'rating' => 5, 'sort_order' => 3],
            ['name' => 'Anisa Rahma',   'position' => 'Marketing Director', 'company' => 'Spekta Events',   'content' => 'Kolaborasi yang menyenangkan dan hasilnya selalu premium. Kami akan terus bekerja sama dengan Haseera.', 'rating' => 5, 'sort_order' => 4],
        ];
        foreach ($testimonials as $testimonial) {
            Testimonial::withTrashed()->updateOrCreate(
                ['name' => $testimonial['name'], 'company' => $testimonial['company']],
                array_merge($testimonial, ['is_active' => true, 'is_featured' => false])
            );
        }

        // Social media links (4)
        $socialLinks = [
            ['platform' => 'Instagram', 'label' => 'Instagram', 'url' => 'https://instagram.com/haseera',        'sort_order' => 1],
            ['platform' => 'Facebook',  'label' => 'Facebook',  'url' => 'https://facebook.com/haseera',         'sort_order' => 2],
            ['platform' => 'YouTube',   'label' => 'YouTube',   'url' => 'https://youtube.com/@haseera',         'sort_order' => 3],
            ['platform' => 'LinkedIn',  'label' => 'LinkedIn',  'url' => 'https://linkedin.com/company/haseera', 'sort_order' => 4],
        ];
        foreach ($socialLinks as $link) {
            SocialMediaLink::withTrashed()->updateOrCreate(
                ['platform' => $link['platform']],
                array_merge($link, ['is_active' => true])
            );
        }
    }
}
