<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SellerMiddleware
{
  /**
   * Allow only authenticated seller users.
   */
  public function handle(Request $request, Closure $next): Response
  {
    if (! auth()->check()) {
      return redirect()->route('login')
        ->with('error', 'Please log in to continue.');
    }

    if (! auth()->user()->isSeller()) {
      return redirect()->route('buyer.home')
        ->with('error', 'Access denied. Seller area only.');
    }

    return $next($request);
  }
}
