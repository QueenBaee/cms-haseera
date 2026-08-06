<?php

declare(strict_types=1);

namespace App\Observers;

use App\Services\LandingPageService;

class LandingPageCacheObserver
{
    public function created(object $model): void
    {
        LandingPageService::clearAllCache();
    }

    public function updated(object $model): void
    {
        LandingPageService::clearAllCache();
    }

    public function deleted(object $model): void
    {
        LandingPageService::clearAllCache();
    }

    public function restored(object $model): void
    {
        LandingPageService::clearAllCache();
    }

    public function forceDeleted(object $model): void
    {
        LandingPageService::clearAllCache();
    }
}
