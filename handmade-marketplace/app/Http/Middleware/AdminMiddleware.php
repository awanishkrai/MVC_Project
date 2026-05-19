<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
  /**
   * Allow only authenticated admin users.
   */
  public function handle(Request $request, Closure $next): Response
  {
    if (! auth()->check()) {
      return redirect()->route('login')
        ->with('error', 'Please log in to continue.');
    }

    if (! auth()->user()->isAdmin()) {
      return redirect()->route('home')
        ->with('error', 'Access denied. Admin area only.');
    }

    return $next($request);
  }
}
