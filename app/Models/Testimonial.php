<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TestimonialCardVariant;
use App\Traits\HandlesMediaCleanup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use HandlesMediaCleanup, HasFactory;
    use SoftDeletes;

    protected array $mediaFields = ['photo'];

    protected $fillable = [
        'name',
        'position',
        'company',
        'photo',
        'content',
        'rating',
        'source',
        'source_url',
        'card_variant',
        'sort_order',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

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

    public function getCardVariantOptions(): array
    {
        return TestimonialCardVariant::options();
    }
}
