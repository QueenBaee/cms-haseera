<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\NavigationLocation;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NavigationItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'label',
        'url',
        'navigation_location',
        'icon',
        'open_new_tab',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'open_new_tab' => 'boolean',
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

    public function getNavigationLocationOptions(): array
    {
        return NavigationLocation::options();
    }

    protected function navigationLocation(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ? NavigationLocation::from($value) : null,
            set: fn (NavigationLocation|string|null $value) => $value instanceof NavigationLocation ? $value->value : $value,
        );
    }
}
