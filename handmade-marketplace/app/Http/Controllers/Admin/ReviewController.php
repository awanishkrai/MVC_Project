<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(Request $request): View
    {
        $reviews = Review::with(['user', 'product'])
            ->when($request->filled('product'), function ($q) use ($request) {
                $q->whereHas('product', fn ($p) => $p->where('title', 'like', '%'.$request->product.'%')
                    ->orWhere('slug', 'like', '%'.$request->product.'%'));
            })
            ->when($request->filled('rating'), fn ($q) => $q->where('rating', $request->integer('rating')))
            ->when($request->filled('user'), function ($q) use ($request) {
                $q->whereHas('user', fn ($u) => $u->where('name', 'like', '%'.$request->user.'%')
                    ->orWhere('email', 'like', '%'.$request->user.'%'));
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.reviews.index', compact('reviews'));
    }

    public function destroy(Review $review): RedirectResponse
    {
        $this->authorize('delete', $review);

        $review->delete();

        return back()->with('success', 'Review removed.');
    }
}
