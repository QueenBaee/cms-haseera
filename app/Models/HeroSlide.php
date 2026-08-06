<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ContentAlignment;
use App\Enums\VerticalAlignment;
use App\Traits\HandlesMediaCleanup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeroSlide extends Model
{
    use HandlesMediaCleanup, HasFactory;
    use SoftDeletes;

    protected array $mediaFields = ['desktop_image', 'mobile_image', 'background_image'];

    protected $fillable = [
        'eyebrow',
        'title',
        'highlighted_text',
        'subtitle',
        'description',
        'desktop_image',
        'mobile_image',
        'background_image',
        'primary_button_text',
        'primary_button_url',
        'primary_button_new_tab',
        'secondary_button_text',
        'secondary_button_url',
        'secondary_button_new_tab',
        'content_alignment',
        'vertical_alignment',
        'overlay_opacity',
        'sort_order',
        'is_active',
        'published_at',
    ];

    protected $casts = [
        'primary_button_new_tab' => 'boolean',
        'secondary_button_new_tab' => 'boolean',
        'is_active' => 'boolean',
        'published_at' => 'datetime',
        'overlay_opacity' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('updated_at');
    }

    public function scopePublished($query)
    {
        return $query->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    public function getContentAlignmentOptions(): array
    {
        return ContentAlignment::options();
    }

    public function getVerticalAlignmentOptions(): array
    {
        return VerticalAlignment::options();
    }
}
