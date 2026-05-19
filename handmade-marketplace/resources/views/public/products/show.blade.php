@extends('layouts.public')
@section('title', $product->title . ' — CraftNest')

@section('content')
<div class="cn-container py-8 sm:py-10 lg:py-12">
    <nav class="mb-6 text-sm text-stone-500">
        <a href="{{ route('products.index') }}" class="hover:text-craft-700">Marketplace</a>
        <span class="mx-2">/</span>
        @if ($product->category)
            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-craft-700">{{ $product->category->name }}</a>
            <span class="mx-2">/</span>
        @endif
        <span class="text-stone-800 line-clamp-1">{{ $product->title }}</span>
    </nav>

    <div class="grid gap-8 lg:grid-cols-12 lg:gap-12">
        {{-- Gallery --}}
        <div class="lg:col-span-6 xl:col-span-7">
            <div class="cn-card overflow-hidden">
                <div class="aspect-square max-h-[min(520px,70vh)] w-full overflow-hidden bg-craft-50">
                    <x-product-image :product="$product" img-class="h-full w-full object-cover" fallback-class="flex aspect-square max-h-[min(520px,70vh)] w-full items-center justify-center bg-gradient-to-br from-craft-100 to-stone-100" />
                </div>
            </div>
        </div>

        {{-- Product info --}}
        <div class="lg:col-span-6 xl:col-span-5">
            <div class="lg:sticky lg:top-24">
                @if ($product->category)
                    <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="inline-flex items-center gap-1 rounded-full bg-craft-100 px-3 py-1 text-sm font-semibold text-craft-800 transition hover:bg-craft-200">
                        {{ $product->category->icon }} {{ $product->category->name }}
                    </a>
                @endif

                <h1 class="mt-3 font-display text-3xl font-bold leading-tight text-stone-900 sm:text-4xl">{{ $product->title }}</h1>

                <div class="mt-4 flex flex-wrap items-center gap-3">
                    <p class="text-3xl font-bold text-craft-700">${{ number_format($product->price, 2) }}</p>
                    <x-stock-badge :status="$product->stock_status" />
                    @if ($product->hasReviews())
                        <div class="flex items-center gap-1.5 text-sm text-stone-600">
                            <x-rating-stars :rating="$product->average_rating" size="sm" />
                            <span>({{ $product->reviews_count }})</span>
                        </div>
                    @endif
                </div>

                <p class="mt-6 leading-relaxed text-stone-600">{{ $product->description }}</p>

                <dl class="mt-8 grid gap-4 rounded-2xl border border-stone-100 bg-craft-50/60 p-5 text-sm sm:grid-cols-2">
                    @if ($product->handmade_material)
                        <div><dt class="font-semibold text-stone-700">Material</dt><dd class="mt-0.5 text-stone-600">{{ $product->handmade_material }}</dd></div>
                    @endif
                    @if ($product->delivery_time)
                        <div><dt class="font-semibold text-stone-700">Delivery</dt><dd class="mt-0.5 text-stone-600">{{ $product->delivery_time }}</dd></div>
                    @endif
                    <div><dt class="font-semibold text-stone-700">Available</dt><dd class="mt-0.5 capitalize text-stone-600">{{ str_replace('_', ' ', $product->stock_status) }} · {{ $product->quantity }} left</dd></div>
                </dl>

                <div class="mt-8 rounded-2xl border border-stone-200 bg-white p-5 shadow-sm">
                    @if ($product->isInStock())
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="flex flex-col gap-4 sm:flex-row sm:items-end">
                            @csrf
                            <div>
                                <label class="cn-label" for="quantity">Quantity</label>
                                <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->quantity }}" class="cn-input !w-24 !py-2.5 text-center">
                            </div>
                            <button type="submit" class="cn-btn-primary flex-1 sm:flex-none sm:px-8">Add to cart</button>
                        </form>
                    @else
                        <button type="button" class="cn-btn-primary w-full cursor-not-allowed opacity-60" disabled>Out of stock</button>
                    @endif
                    <div class="mt-3 flex flex-col gap-2 sm:flex-row">
                        @auth
                            @if (auth()->id() !== $product->user_id)
                                @if ($isWishlisted)
                                    <form action="{{ route('wishlist.destroy', $product) }}" method="POST" class="flex-1">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="cn-btn-secondary w-full">♥ Saved to wishlist</button>
                                    </form>
                                @else
                                    <form action="{{ route('wishlist.store', $product) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="cn-btn-secondary w-full">♡ Save to wishlist</button>
                                    </form>
                                @endif
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="cn-btn-secondary flex-1 text-center">♡ Save to wishlist</a>
                        @endauth
                        <a href="{{ route('shops.show', $product->shop) }}" class="cn-btn-secondary flex-1 text-center">Visit shop</a>
                    </div>
                </div>

                <div class="cn-card mt-6 flex items-center gap-4 p-5">
                    <x-shop-logo :shop="$product->shop" size="sm" />
                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Sold by</p>
                        <p class="truncate font-display text-lg font-semibold text-stone-900">{{ $product->shop->shop_name }}</p>
                        <p class="text-sm text-stone-500">{{ $product->shop->user->name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Reviews --}}
    <section id="reviews" class="mt-16 border-t border-stone-200/80 pt-12">
        <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="cn-eyebrow">Customer feedback</p>
                <h2 class="font-display text-2xl font-bold text-stone-900">Reviews</h2>
            </div>
            @if ($product->hasReviews())
                <form method="GET" class="flex items-center gap-2">
                    <label for="review_sort" class="sr-only">Sort reviews</label>
                    <select id="review_sort" name="review_sort" onchange="this.form.submit()" class="cn-input !w-auto !py-2 !text-sm">
                        <option value="newest" @selected($reviewSort === 'newest')>Newest</option>
                        <option value="highest" @selected($reviewSort === 'highest')>Highest rated</option>
                        <option value="lowest" @selected($reviewSort === 'lowest')>Lowest rated</option>
                    </select>
                </form>
            @endif
        </div>

        @if ($product->hasReviews())
            <x-review-summary :product="$product" :distribution="$ratingDistribution" class="mb-8" />
        @endif

        @auth
            @if ($userReview)
                <x-review-card :review="$userReview" :editable="true" class="mb-6" />
                <x-review-form :product="$product" :review="$userReview" form-id="edit-review-form" class="mb-8 hidden" />
            @elseif ($canReview)
                <x-review-form :product="$product" class="mb-8" />
            @elseif(auth()->id() === $product->user_id)
                <p class="cn-card mb-8 p-5 text-sm text-stone-500">You cannot review your own product.</p>
            @elseif(! \App\Models\Review::userHasPurchased(auth()->user(), $product))
                <p class="cn-card mb-8 p-5 text-sm text-stone-500">Purchase this product to leave a verified review.</p>
            @endif
        @else
            <p class="cn-card mb-8 p-5 text-sm text-stone-500">
                <a href="{{ route('login') }}" class="font-medium text-craft-700 hover:underline">Sign in</a> to write a review after purchase.
            </p>
        @endauth

        @if ($reviews->isEmpty())
            <x-empty-state title="No reviews yet" description="Be the first to share your experience with this handmade piece." icon="⭐" />
        @else
            <div class="space-y-4">
                @foreach ($reviews as $review)
                    @continue(auth()->check() && $userReview && $review->id === $userReview->id)
                    <x-review-card :review="$review" />
                @endforeach
            </div>
            <div class="mt-8">{{ $reviews->links() }}</div>
        @endif
    </section>

    @if ($related->isNotEmpty())
    <section class="mt-16 border-t border-stone-200/80 pt-12">
        <h2 class="font-display text-2xl font-bold text-stone-900">You may also like</h2>
        <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($related as $item)
                <x-product-card :product="$item" />
            @endforeach
        </div>
    </section>
    @endif
</div>
@endsection
