<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::with(['shop.user', 'category'])
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                  ->orWhereHas('shop', fn ($s) => $s->where('name', 'like', '%'.$request->search.'%'));
            })
            ->when($request->filled('category'), fn ($q) => $q->where('category_id', $request->category))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('stock'), fn ($q) => $q->where('stock_status', $request->stock))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function updateStatus(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:published,draft',
        ]);

        $product->update(['status' => $validated['status']]);

        return back()->with('success', 'Product status updated.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        // Could notify the seller, but keeping it simple for now
        $product->delete();

        return back()->with('success', 'Product deleted.');
    }
}
