<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewStoreRequest;
use App\Http\Requests\ReviewUpdateRequest;
use App\Models\Product;
use App\Models\Review;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;

class ReviewController extends Controller
{
    public function store(ReviewStoreRequest $request, Product $product): RedirectResponse
    {
        abort_unless($product->status === 'published', 404);

        $this->authorize('create', [Review::class, $product]);

        $review = $product->reviews()->create([
            'user_id' => $request->user()->id,
            'rating' => $request->validated('rating'),
            'title' => $request->validated('title'),
            'comment' => $request->validated('comment'),
            'is_verified_purchase' => true,
        ]);

        app(NotificationService::class)->notifySellerNewReview($review);

        return redirect()
            ->route('products.show', $product)
            ->with('success', 'Thank you! Your review has been published.');
    }

    public function update(ReviewUpdateRequest $request, Product $product, Review $review): RedirectResponse
    {
        abort_unless($review->product_id === $product->id, 404);

        $this->authorize('update', $review);

        $review->update($request->validated());

        return redirect()
            ->route('products.show', $product)
            ->with('success', 'Your review has been updated.');
    }

    public function destroy(Product $product, Review $review): RedirectResponse
    {
        abort_unless($review->product_id === $product->id, 404);

        $this->authorize('delete', $review);

        $review->delete();

        return redirect()
            ->route('products.show', $product)
            ->with('success', 'Your review has been removed.');
    }
}
