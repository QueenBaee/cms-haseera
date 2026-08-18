<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ContentAlignment;
use App\Enums\ImageFit;
use App\Enums\PortfolioLayoutVariant;
use App\Traits\HandlesMediaCleanup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Portfolio extends Model
{
    use HandlesMediaCleanup, HasFactory;
    use SoftDeletes;

    protected array $mediaFields = ['thumbnail', 'cover_image', 'logo', 'video_file'];

    protected $fillable = [
        'portfolio_category_id',
        'title',
        'slug',
        'eyebrow',
        'client_name',
        'project_date',
        'location',
        'short_description',
        'description',
        'thumbnail',
        'cover_image',
        'logo',
        'video_file',
        'project_url',
        'button_text',
        'technologies',
        'layout_variant',
        'image_fit',
        'content_alignment',
        'sort_order',
        'is_featured',
        'is_active',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'portfolio_category_id' => 'integer',
        'project_date' => 'date',
        'technologies' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Portfolio $portfolio) {
            if (empty($portfolio->slug)) {
                $portfolio->slug = static::generateSlug($portfolio->title);
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(PortfolioCategory::class, 'portfolio_category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(PortfolioImage::class)->ordered();
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

    public function getLayoutVariantOptions(): array
    {
        return PortfolioLayoutVariant::options();
    }

    public function getImageFitOptions(): array
    {
        return ImageFit::options();
    }

    public function getContentAlignmentOptions(): array
    {
        return ContentAlignment::options();
    }
}
