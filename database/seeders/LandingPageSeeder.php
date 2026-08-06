<?php

declare(strict_types=1);

namespace Database\Seeders;

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
use App\Models\SocialMediaLink;
use App\Models\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LandingPageSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Singleton settings
        LandingPageSetting::updateOrCreate(['id' => 1], [
            'site_name' => 'Haseera',
            'company_name' => 'PT Haseera Indonesia',
            'site_tagline' => 'Solusi Digital Terpercaya',
            'show_header' => true,
            'show_hero' => true,
            'show_statistics' => true,
            'show_about' => true,
            'show_services' => true,
            'show_portfolio' => true,
            'show_testimonials' => true,
            'show_cta' => true,
            'show_footer' => true,
        ]);

        CallToActionSetting::updateOrCreate(['id' => 1], [
            'title' => 'Siap Memulai Proyek Anda?',
            'highlighted_text' => 'Proyek Anda',
            'description' => 'Hubungi kami sekarang dan wujudkan ide Anda bersama tim profesional kami.',
            'primary_button_text' => 'Hubungi Kami',
            'primary_button_url' => '#contact',
            'is_active' => true,
        ]);

        // Navigation items (5)
        $navItems = [
            ['label' => 'Beranda', 'url' => '#hero', 'navigation_location' => 'header', 'sort_order' => 1],
            ['label' => 'Tentang', 'url' => '#about', 'navigation_location' => 'header', 'sort_order' => 2],
            ['label' => 'Layanan', 'url' => '#services', 'navigation_location' => 'both', 'sort_order' => 3],
            ['label' => 'Portofolio', 'url' => '#portfolio', 'navigation_location' => 'both', 'sort_order' => 4],
            ['label' => 'Kontak', 'url' => '#contact', 'navigation_location' => 'both', 'sort_order' => 5],
        ];

        foreach ($navItems as $item) {
            NavigationItem::withTrashed()->updateOrCreate(
                ['label' => $item['label']],
                array_merge($item, ['is_active' => true])
            );
        }

        // Hero slides (2)
        $heroSlides = [
            [
                'title' => 'Solusi Digital untuk Bisnis Anda',
                'highlighted_text' => 'Digital',
                'subtitle' => 'Kami hadir untuk membantu bisnis Anda berkembang',
                'description' => 'Tim profesional kami siap memberikan solusi terbaik untuk kebutuhan digital Anda.',
                'primary_button_text' => 'Mulai Sekarang',
                'primary_button_url' => '#contact',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Inovasi Tanpa Batas',
                'highlighted_text' => 'Inovasi',
                'subtitle' => 'Teknologi terkini untuk hasil terbaik',
                'description' => 'Kami menggunakan teknologi mutakhir untuk menghadirkan produk berkualitas tinggi.',
                'primary_button_text' => 'Lihat Portofolio',
                'primary_button_url' => '#portfolio',
                'sort_order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($heroSlides as $slide) {
            HeroSlide::withTrashed()->updateOrCreate(
                ['title' => $slide['title']],
                $slide
            );
        }

        // Company statistics (4)
        $statistics = [
            ['value' => '150', 'suffix' => '+', 'label' => 'Proyek Selesai', 'sort_order' => 1],
            ['value' => '50', 'suffix' => '+', 'label' => 'Klien Puas', 'sort_order' => 2],
            ['value' => '10', 'suffix' => '+', 'label' => 'Tahun Pengalaman', 'sort_order' => 3],
            ['value' => '25', 'suffix' => '+', 'label' => 'Tim Profesional', 'sort_order' => 4],
        ];

        foreach ($statistics as $stat) {
            CompanyStatistic::withTrashed()->updateOrCreate(
                ['label' => $stat['label']],
                array_merge($stat, ['is_active' => true])
            );
        }

        // About section (1) with features (4)
        $about = AboutSection::withTrashed()->updateOrCreate(
            ['title' => 'Tentang Haseera'],
            [
                'eyebrow' => 'Tentang Kami',
                'title' => 'Tentang Haseera',
                'highlighted_text' => 'Haseera',
                'short_description' => 'Kami adalah perusahaan teknologi yang berfokus pada solusi digital.',
                'description' => 'Haseera hadir sebagai mitra terpercaya dalam perjalanan transformasi digital bisnis Anda. Dengan pengalaman lebih dari satu dekade, kami telah membantu ratusan klien mencapai tujuan mereka.',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        $features = [
            ['title' => 'Tim Berpengalaman', 'description' => 'Didukung oleh para profesional berpengalaman di bidangnya.', 'sort_order' => 1],
            ['title' => 'Teknologi Modern', 'description' => 'Menggunakan teknologi terkini untuk hasil yang optimal.', 'sort_order' => 2],
            ['title' => 'Dukungan 24/7', 'description' => 'Layanan dukungan tersedia kapan saja Anda membutuhkan.', 'sort_order' => 3],
            ['title' => 'Harga Terjangkau', 'description' => 'Solusi berkualitas dengan harga yang kompetitif.', 'sort_order' => 4],
        ];

        foreach ($features as $feature) {
            AboutFeature::updateOrCreate(
                ['about_section_id' => $about->id, 'title' => $feature['title']],
                array_merge($feature, ['about_section_id' => $about->id, 'is_active' => true])
            );
        }

        // Services (4)
        $services = [
            ['title' => 'Pengembangan Web', 'short_description' => 'Membangun website profesional dan responsif.', 'sort_order' => 1],
            ['title' => 'Aplikasi Mobile', 'short_description' => 'Aplikasi mobile iOS dan Android berkualitas tinggi.', 'sort_order' => 2],
            ['title' => 'Desain UI/UX', 'short_description' => 'Desain antarmuka yang menarik dan mudah digunakan.', 'sort_order' => 3],
            ['title' => 'Konsultasi Digital', 'short_description' => 'Strategi transformasi digital untuk bisnis Anda.', 'sort_order' => 4],
        ];

        foreach ($services as $service) {
            $serviceModel = Service::withTrashed()->firstOrNew(['title' => $service['title']]);
            $serviceModel->fill(array_merge($service, ['is_active' => true, 'is_featured' => false]));
            $serviceModel->slug ??= Service::generateSlug($service['title']);
            $serviceModel->save();
        }

        // Portfolio categories (3)
        $categories = [
            ['name' => 'Website', 'description' => 'Proyek pengembangan website.', 'sort_order' => 1],
            ['name' => 'Mobile App', 'description' => 'Proyek aplikasi mobile.', 'sort_order' => 2],
            ['name' => 'Branding', 'description' => 'Proyek desain dan branding.', 'sort_order' => 3],
        ];

        $categoryIds = [];
        foreach ($categories as $cat) {
            $category = PortfolioCategory::withTrashed()->firstOrNew(['name' => $cat['name']]);
            $category->fill(array_merge($cat, ['is_active' => true]));
            $category->slug ??= PortfolioCategory::generateSlug($cat['name']);
            $category->save();
            $categoryIds[$cat['name']] = $category->id;
        }

        // Portfolios (6)
        $portfolios = [
            ['title' => 'Website Perusahaan A', 'category' => 'Website', 'sort_order' => 1],
            ['title' => 'Website Toko Online B', 'category' => 'Website', 'sort_order' => 2],
            ['title' => 'Aplikasi Kasir C', 'category' => 'Mobile App', 'sort_order' => 3],
            ['title' => 'Aplikasi Delivery D', 'category' => 'Mobile App', 'sort_order' => 4],
            ['title' => 'Branding Startup E', 'category' => 'Branding', 'sort_order' => 5],
            ['title' => 'Identitas Visual F', 'category' => 'Branding', 'sort_order' => 6],
        ];

        foreach ($portfolios as $portfolio) {
            $portfolioModel = Portfolio::withTrashed()->firstOrNew(['title' => $portfolio['title']]);
            $portfolioModel->fill([
                'title' => $portfolio['title'], 'portfolio_category_id' => $categoryIds[$portfolio['category']],
                'short_description' => 'Deskripsi singkat '.$portfolio['title'], 'sort_order' => $portfolio['sort_order'],
                'is_active' => true, 'is_featured' => false,
            ]);
            $portfolioModel->slug ??= Portfolio::generateSlug($portfolio['title']);
            $portfolioModel->save();
        }

        // Testimonials (4)
        $testimonials = [
            ['name' => 'Budi Santoso', 'position' => 'CEO', 'company' => 'PT Maju Bersama', 'content' => 'Layanan yang sangat memuaskan dan profesional.', 'rating' => 5, 'sort_order' => 1],
            ['name' => 'Siti Rahayu', 'position' => 'Marketing Manager', 'company' => 'CV Berkah Jaya', 'content' => 'Tim yang responsif dan hasil kerja yang luar biasa.', 'rating' => 5, 'sort_order' => 2],
            ['name' => 'Ahmad Fauzi', 'position' => 'Founder', 'company' => 'Startup Inovasi', 'content' => 'Sangat puas dengan kualitas dan ketepatan waktu pengerjaan.', 'rating' => 5, 'sort_order' => 3],
            ['name' => 'Dewi Lestari', 'position' => 'Director', 'company' => 'PT Digital Nusantara', 'content' => 'Rekomendasi terbaik untuk kebutuhan digital bisnis Anda.', 'rating' => 5, 'sort_order' => 4],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::withTrashed()->updateOrCreate(
                ['name' => $testimonial['name'], 'company' => $testimonial['company']],
                array_merge($testimonial, ['is_active' => true, 'is_featured' => false])
            );
        }

        // Social media links (4)
        $socialLinks = [
            ['platform' => 'Instagram', 'label' => 'Instagram', 'url' => 'https://instagram.com/haseera', 'sort_order' => 1],
            ['platform' => 'Facebook', 'label' => 'Facebook', 'url' => 'https://facebook.com/haseera', 'sort_order' => 2],
            ['platform' => 'Twitter', 'label' => 'Twitter', 'url' => 'https://twitter.com/haseera', 'sort_order' => 3],
            ['platform' => 'LinkedIn', 'label' => 'LinkedIn', 'url' => 'https://linkedin.com/company/haseera', 'sort_order' => 4],
        ];

        foreach ($socialLinks as $link) {
            SocialMediaLink::withTrashed()->updateOrCreate(
                ['platform' => $link['platform']],
                array_merge($link, ['is_active' => true])
            );
        }
    }
}
