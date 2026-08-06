<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ServiceDisplayVariant;
use App\Traits\HandlesMediaCleanup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Service extends Model
{
    use HandlesMediaCleanup, HasFactory;
    use SoftDeletes;

    protected array $mediaFields = ['image', 'background_image'];

    protected $fillable = [
        'title',
        'slug',
        'eyebrow',
        'short_description',
        'description',
        'icon',
        'image',
        'background_image',
        'button_text',
        'button_url',
        'open_new_tab',
        'display_variant',
        'sort_order',
        'is_featured',
        'is_active',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'open_new_tab' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Service $service) {
            if (empty($service->slug)) {
                $service->slug = static::generateSlug($service->title);
            }
        });
    }

    public static function generateSlug(string $value): string
    {
        $slug = Str::slug($value);
        $count = 0;

        while (static::withTrashed()->where('slug', $slug.($count ? "-{$count}" : ''))->exists()) {
            $count++;
        }

        return $slug.($count ? "-{$count}" : '');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('updated_at');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getDisplayVariantOptions(): array
    {
        return ServiceDisplayVariant::options();
    }
}
