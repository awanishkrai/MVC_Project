<?php

namespace App\Http\Controllers\Concerns;

use App\Models\User;
use Illuminate\Http\RedirectResponse;

trait RedirectsUsersByRole
{
    protected function redirectToRoleDashboard(?User $user = null): RedirectResponse
    {
        $user = $user ?? auth()->user();

        $route = match ($user->role) {
            'admin' => 'admin.dashboard',
            'seller' => 'seller.dashboard',
            default => 'home',
        };

        return redirect()->route($route);
    }
}
