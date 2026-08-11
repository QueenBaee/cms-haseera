<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Service;
use Illuminate\Console\Command;

class SyncServicesData extends Command
{
    protected $signature = 'services:sync';

    protected $description = 'Sync data layanan: soft-delete lama, upsert 3 layanan baru (Graphic Design, Visual Event, Video Production).';

    public function handle(): int
    {
        $keepSlugs = ['graphic-design', 'visual-event', 'video-production'];

        // Soft-delete semua service yang bukan bagian dari 3 service baru
        $deleted = Service::whereNotIn('slug', $keepSlugs)
            ->whereNull('deleted_at')
            ->get();

        foreach ($deleted as $old) {
            $old->delete();
            $this->line("  Soft-deleted: {$old->title}");
        }

        // Upsert 3 service baru
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
                'is_active' => true,
                'display_variant' => 'card',
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
                'is_active' => true,
                'display_variant' => 'card',
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
                'is_active' => true,
                'display_variant' => 'card',
            ],
        ];

        foreach ($services as $data) {
            $service = Service::withTrashed()->where('slug', $data['slug'])->first();

            if ($service) {
                $service->fill($data);
                $service->deleted_at = null;
                $service->save();
                $this->line("  Updated: {$service->title}");
            } else {
                Service::create($data);
                $this->line("  Created: {$data['title']}");
            }
        }

        $this->info('Sync selesai. Layanan aktif:');
        Service::active()->ordered()->each(function (Service $s) {
            $featured = $s->is_featured ? '[featured]' : '';
            $this->line("  [{$s->sort_order}] {$s->title} {$featured}");
        });

        return self::SUCCESS;
    }
}
