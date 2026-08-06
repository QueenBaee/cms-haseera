<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LandingPagePolicyBase
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, object $model): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, object $model): bool
    {
        return true;
    }

    public function delete(User $user, object $model): bool
    {
        return true;
    }

    public function restore(User $user, object $model): bool
    {
        return true;
    }

    public function forceDelete(User $user, object $model): bool
    {
        return true;
    }
}
