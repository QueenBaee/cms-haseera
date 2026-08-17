<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Brand;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class ImportBrands extends Command
{
    private const SOURCE_DIRECTORY = 'brands-bulk';

    private const DESTINATION_DIRECTORY = 'brands';

    private const SUPPORTED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp', 'svg'];

    protected $signature = 'brands:import';

    protected $description = 'Import brand logos from the public brands-bulk directory';

    public function handle(): int
    {
        $disk = Storage::disk('public');

        if (! $disk->directoryExists(self::SOURCE_DIRECTORY)) {
            $this->error('[ERROR] Source directory does not exist: storage/app/public/'.self::SOURCE_DIRECTORY);

            return self::FAILURE;
        }

        if (! $disk->directoryExists(self::DESTINATION_DIRECTORY)
            && ! $disk->makeDirectory(self::DESTINATION_DIRECTORY)) {
            $this->error('[ERROR] Failed to create destination directory: storage/app/public/'.self::DESTINATION_DIRECTORY);

            return self::FAILURE;
        }

        $files = collect($disk->files(self::SOURCE_DIRECTORY))
            ->filter(fn (string $path): bool => in_array(
                strtolower(pathinfo($path, PATHINFO_EXTENSION)),
                self::SUPPORTED_EXTENSIONS,
                true,
            ))
            ->sort()
            ->values();

        $imported = 0;
        $skipped = 0;
        $failed = 0;

        foreach ($files as $sourcePath) {
            $filename = basename($sourcePath);
            $logoPath = self::DESTINATION_DIRECTORY.'/'.$filename;
            $formattedName = $this->formatBrandName($filename);

            if (Brand::query()->where('logo', $logoPath)->exists()) {
                $skipped++;
                $this->warn("[SKIPPED] {$filename} -> Brand already exists");

                continue;
            }

            if ($disk->exists($logoPath)) {
                $failed++;
                $this->error("[ERROR] {$filename} -> Destination file already exists");

                continue;
            }

            if (! $disk->move($sourcePath, $logoPath)) {
                $failed++;
                $this->error("[ERROR] {$filename} -> Failed to move file");

                continue;
            }

            try {
                Brand::query()->create([
                    'name' => $formattedName,
                    'logo' => $logoPath,
                    'is_active' => true,
                    'sort_order' => 0,
                    'logo_background' => 'auto',
                ]);

                $imported++;
                $this->info("[IMPORTED] {$filename} -> {$formattedName}");
            } catch (Throwable $exception) {
                $failed++;
                $restored = $disk->move($logoPath, $sourcePath);
                $restoreMessage = $restored ? '' : '; failed to restore source file';

                $this->error("[ERROR] {$filename} -> {$exception->getMessage()}{$restoreMessage}");
            }
        }

        $this->newLine();
        $this->info('Import summary:');
        $this->line("Total files found: {$files->count()}");
        $this->line("Successfully imported: {$imported}");
        $this->line("Skipped: {$skipped}");
        $this->line("Failed: {$failed}");

        return $failed === 0 ? self::SUCCESS : self::FAILURE;
    }

    private function formatBrandName(string $filename): string
    {
        return Str::of(pathinfo($filename, PATHINFO_FILENAME))
            ->replace(['-', '_'], ' ')
            ->squish()
            ->title()
            ->toString();
    }
}
