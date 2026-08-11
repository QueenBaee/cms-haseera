<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        // Soft-delete semua service yang bukan bagian dari 3 service baru
        $keepSlugs = ['graphic-design', 'visual-event', 'video-production'];

        DB::table('services')
            ->whereNotIn('slug', $keepSlugs)
            ->whereNull('deleted_at')
            ->update(['deleted_at' => $now]);

        // Upsert 3 service baru
        $services = [
            [
                'title' => 'Graphic Design',
                'slug' => 'graphic-design',
                'short_description' => 'Solusi desain grafis profesional untuk kebutuhan visual brand Anda.',
                'items' => json_encode([
                    ['label' => '2D & 3D Design'],
                    ['label' => 'Interior & Eksterior Design'],
                    ['label' => 'Stage, Booth Exhibition Design'],
                ]),
                'sort_order' => 1,
                'is_featured' => 0,
                'is_active' => 1,
                'display_variant' => 'card',
                'open_new_tab' => 0,
            ],
            [
                'title' => 'Visual Event',
                'slug' => 'visual-event',
                'short_description' => 'Konten visual imersif untuk event dan pertunjukan yang memukau.',
                'items' => json_encode([
                    ['label' => 'Bumper Event Animation'],
                    ['label' => 'Motion Graphic Design'],
                    ['label' => 'Wedding Background Animation'],
                    ['label' => 'LED Visual Content'],
                ]),
                'sort_order' => 2,
                'is_featured' => 1,
                'is_active' => 1,
                'display_variant' => 'card',
                'open_new_tab' => 0,
            ],
            [
                'title' => 'Video Production',
                'slug' => 'video-production',
                'short_description' => 'Produksi video berkualitas tinggi dari konsep hingga hasil akhir.',
                'items' => json_encode([
                    ['label' => 'Editing'],
                    ['label' => 'Company Profile'],
                    ['label' => 'Event Teaser'],
                    ['label' => 'Wedding Teaser'],
                    ['label' => 'Executive Spotlight'],
                ]),
                'sort_order' => 3,
                'is_featured' => 0,
                'is_active' => 1,
                'display_variant' => 'card',
                'open_new_tab' => 0,
            ],
        ];

        foreach ($services as $data) {
            $existing = DB::table('services')
                ->where('slug', $data['slug'])
                ->first();

            if ($existing) {
                // Update record existing (restore jika soft-deleted)
                DB::table('services')
                    ->where('slug', $data['slug'])
                    ->update(array_merge($data, [
                        'deleted_at' => null,
                        'updated_at' => $now,
                    ]));
            } else {
                // Insert baru
                DB::table('services')->insert(array_merge($data, [
                    'created_at' => $now,
                    'updated_at' => $now,
                    'deleted_at' => null,
                ]));
            }
        }
    }

    public function down(): void
    {
        // Restore service lama yang di-soft-delete (tidak bisa sempurna, tapi aman)
        DB::table('services')
            ->whereIn('slug', ['graphic-design', 'visual-event', 'video-production'])
            ->update(['deleted_at' => now()]);
    }
};
