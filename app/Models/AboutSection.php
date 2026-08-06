<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AboutContentPosition;
use App\Traits\HandlesMediaCleanup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AboutSection extends Model
{
    use HandlesMediaCleanup, HasFactory;
    use SoftDeletes;

    protected array $mediaFields = ['image', 'secondary_image'];

    protected $fillable = [
        'eyebrow',
        'title',
        'highlighted_text',
        'short_description',
        'description',
        'image',
        'secondary_image',
        'video_url',
        'button_text',
        'button_url',
        'button_new_tab',
        'content_position',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'button_new_tab' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function features(): HasMany
    {
        return $this->hasMany(AboutFeature::class)->ordered();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('updated_at');
    }

    public function getContentPositionOptions(): array
    {
        return AboutContentPosition::options();
    }
}
