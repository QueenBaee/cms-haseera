<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HandlesMediaCleanup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortfolioImage extends Model
{
    use HandlesMediaCleanup, HasFactory;

    protected array $mediaFields = ['image'];

    protected $fillable = [
        'portfolio_id',
        'image',
        'caption',
        'alt_text',
        'sort_order',
    ];

    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('updated_at');
    }
}
