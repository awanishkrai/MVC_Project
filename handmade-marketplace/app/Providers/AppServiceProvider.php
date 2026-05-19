<?php

namespace App\Providers;

use App\Models\Product;
use App\Policies\WishlistPolicy;
use App\Services\CartService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);

        Gate::policy(Product::class, WishlistPolicy::class);

        View::composer(['partials.public.navbar', 'components.product-card'], function ($view) {
            $view->with('cartCount', app(CartService::class)->count());

            if (auth()->check()) {
                $view->with('wishlistCount', auth()->user()->wishlists()->count());
                $view->with(
                    'wishlistedProductIds',
                    auth()->user()->wishlists()->pluck('product_id')->all()
                );
            } else {
                $view->with('wishlistCount', 0);
                $view->with('wishlistedProductIds', []);
            }
        });
    }
}
