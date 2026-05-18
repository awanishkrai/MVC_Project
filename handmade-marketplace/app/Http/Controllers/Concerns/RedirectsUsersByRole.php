<?php

namespace App\Http\Controllers\Concerns;

use App\Models\User;
use Illuminate\Http\RedirectResponse;

trait RedirectsUsersByRole
{
  /**
   * Send the user to the dashboard that matches their role.
   */
  protected function redirectToRoleDashboard(?User $user = null): RedirectResponse
  {
    $user = $user ?? auth()->user();

    $route = match ($user->role) {
      'admin' => 'admin.dashboard',
      'seller' => 'seller.dashboard',
      default => 'buyer.home',
    };

    return redirect()->route($route);
  }
}
