<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'category', 'stock', 'sort']);
        $categories = Category::withCount(['products' => fn ($q) => $q->published()])->orderBy('name')->get();

        $products = Product::with(['shop.user', 'category'])
            ->published()
            ->filter($filters)
            ->paginate(12)
            ->withQueryString();

        return view('public.products.index', compact('products', 'categories', 'filters'));
    }

    public function show(Request $request, Product $product): View
    {
        abort_unless($product->status === 'published', 404);

        $product->load(['shop.user', 'category']);

        $related = Product::published()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        $reviewSort = $request->query('review_sort', 'newest');
        $reviews = $product->reviews()
            ->with('user')
            ->sorted($reviewSort)
            ->paginate(8)
            ->withQueryString();

        $ratingDistribution = $product->ratingDistribution();

        $userReview = auth()->check()
            ? $product->reviews()->where('user_id', auth()->id())->first()
            : null;

        $canReview = auth()->check()
            && ! $userReview
            && $request->user()->can('create', [Review::class, $product]);

        $isWishlisted = auth()->check() && auth()->user()->hasWishlisted($product->id);

        return view('public.products.show', compact(
            'product',
            'related',
            'reviews',
            'reviewSort',
            'ratingDistribution',
            'userReview',
            'canReview',
            'isWishlisted'
        ));
    }

    public function manage(Request $request): View
    {
        $products = auth()->user()->products()
            ->with('category')
            ->latest()
            ->paginate(12);

        return view('seller.products.index', compact('products'));
    }

    public function create(): View|RedirectResponse
    {
        if (! auth()->user()->shop) {
            return redirect()->route('seller.shop.create')
                ->with('error', 'Create your shop before adding products.');
        }

        return view('seller.products.create', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(ProductStoreRequest $request): RedirectResponse
    {
        $shop = auth()->user()->shop;
        $data = $request->safe()->except('image');
        $data['shop_id'] = $shop->id;
        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($request->title).'-'.Str::random(6);
        $data['status'] = 'published';
        $data['image'] = $request->file('image')->store('products', 'public');

        Product::create($data);

        return redirect()->route('seller.products.index')
            ->with('success', 'Product published successfully!');
    }

    public function edit(Product $product): View|RedirectResponse
    {
        $this->authorizeProduct($product);

        return view('seller.products.edit', [
            'product' => $product,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(ProductUpdateRequest $request, Product $product): RedirectResponse
    {
        $this->authorizeProduct($product);

        $data = $request->safe()->except('image');

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        if ($request->title !== $product->title) {
            $data['slug'] = Str::slug($request->title).'-'.Str::random(6);
        }

        $product->update($data);

        return redirect()->route('seller.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->authorizeProduct($product);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('seller.products.index')
            ->with('success', 'Product deleted.');
    }

    private function authorizeProduct(Product $product): void
    {
        abort_unless(
            auth()->user()->isSeller() && $product->user_id === auth()->id(),
            403
        );
    }
}
