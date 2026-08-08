<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Brand;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportClientBrands extends Command
{
    protected $signature = 'brands:import-client-assets';

    protected $description = 'Import logo dari client-assets/clients-brands/ ke storage dan buat record Brand';

    private const SOURCE_DIR = 'client-assets/clients-brands';

    private const DEST_DIR = 'brands';

    private const ALLOWED_EXTENSIONS = ['png', 'jpg', 'jpeg', 'webp', 'svg'];

    public function handle(): int
    {
        $sourceDir = base_path(self::SOURCE_DIR);

        if (! is_dir($sourceDir)) {
            $this->error("Folder tidak ditemukan: {$sourceDir}");

            return self::FAILURE;
        }

        $files = collect(scandir($sourceDir))
            ->filter(fn (string $file) => ! in_array($file, ['.', '..']))
            ->filter(fn (string $file) => in_array(
                strtolower(pathinfo($file, PATHINFO_EXTENSION)),
                self::ALLOWED_EXTENSIONS
            ))
            ->values();

        $found = $files->count();
        $imported = 0;
        $skipped = 0;
        $failed = 0;

        $this->info("Found: {$found}");

        foreach ($files as $order => $filename) {
            $sourcePath = $sourceDir.DIRECTORY_SEPARATOR.$filename;
            $destPath = self::DEST_DIR.'/'.$filename;
            $name = $this->nameFromFilename($filename);

            try {
                // Copy ke public storage jika belum ada
                if (! Storage::disk('public')->exists($destPath)) {
                    Storage::disk('public')->put($destPath, file_get_contents($sourcePath));
                }

                // Idempotent: cek berdasarkan logo path
                $existed = Brand::where('logo', $destPath)->exists();

                Brand::firstOrCreate(
                    ['logo' => $destPath],
                    [
                        'name' => $name,
                        'website_url' => null,
                        'sort_order' => $order,
                        'is_active' => true,
                    ]
                );

                if ($existed) {
                    $skipped++;
                    $this->line("  Skipped: {$filename}");
                } else {
                    $imported++;
                    $this->line("  Imported: {$filename} → {$name}");
                }
            } catch (\Throwable $e) {
                $failed++;
                $this->warn("  Failed: {$filename} — {$e->getMessage()}");
            }
        }

        $this->newLine();
        $this->info("Imported: {$imported}");
        $this->info("Skipped:  {$skipped}");
        $this->info("Failed:   {$failed}");

        return self::SUCCESS;
    }

    private function nameFromFilename(string $filename): string
    {
        $base = pathinfo($filename, PATHINFO_FILENAME);

        // Hapus hash MD5-like (32 hex chars) dan suffix umum
        $base = preg_replace('/^[a-f0-9]{32}$/i', 'Brand', $base) ?? $base;
        $base = preg_replace('/-Photoroom$/i', '', $base);
        $base = preg_replace('/\.svg$/i', '', $base);

        // Ganti separator jadi spasi, title case
        $base = str_replace(['-', '_'], ' ', $base);

        return Str::title(trim($base));
    }
}
