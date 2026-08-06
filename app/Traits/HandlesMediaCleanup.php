<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

trait HandlesMediaCleanup
{
    public static function bootHandlesMediaCleanup(): void
    {
        static::updating(function (Model $model): void {
            if (! property_exists($model, 'mediaFields')) {
                return;
            }

            foreach ($model->mediaFields as $field) {
                if ($model->isDirty($field)) {
                    $oldValue = $model->getOriginal($field);
                    $newValue = $model->{$field};

                    if ($oldValue && $oldValue !== $newValue) {
                        if (! static::mediaQuery()->where($field, $oldValue)->where('id', '!=', $model->id)->exists()) {
                            Storage::disk('public')->delete($oldValue);
                        }
                    }
                }
            }
        });

        if (in_array(SoftDeletes::class, class_uses_recursive(static::class), true)) {
            static::forceDeleted(function (Model $model): void {
                foreach ($model->mediaFields as $field) {
                    $path = $model->{$field};

                    if ($path && ! static::mediaQuery()->where($field, $path)->where('id', '!=', $model->id)->exists()) {
                        Storage::disk('public')->delete($path);
                    }
                }
            });
        }

        static::deleted(function (Model $model): void {
            if (in_array(SoftDeletes::class, class_uses_recursive($model), true) || ! property_exists($model, 'mediaFields')) {
                return;
            }

            foreach ($model->mediaFields as $field) {
                if ($model->{$field}) {
                    Storage::disk('public')->delete($model->{$field});
                }
            }
        });
    }

    private static function mediaQuery(): Builder
    {
        $query = static::query();

        return in_array(SoftDeletes::class, class_uses_recursive(static::class), true) ? $query->withTrashed() : $query;
    }
}
