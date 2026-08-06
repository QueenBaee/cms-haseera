<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PortfolioCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (PortfolioCategory $category) {
            if (empty($category->slug)) {
                $category->slug = static::generateSlug($category->name);
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

    public function portfolios(): HasMany
    {
        return $this->hasMany(Portfolio::class)->ordered();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('updated_at');
    }
}
