<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopStoreRequest;
use App\Http\Requests\ShopUpdateRequest;
use App\Models\Shop;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ShopController extends Controller
{
    /** Public storefront */
    public function show(Shop $shop): View
    {
        $shop->load(['user']);
        $products = $shop->products()
            ->with('category')
            ->where('status', 'published')
            ->latest()
            ->get();

        return view('public.shop.show', [
            'shop' => $shop,
            'products' => $products,
            'productCount' => $products->count(),
        ]);
    }

    public function create(): View|RedirectResponse
    {
        if (auth()->user()->shop) {
            return redirect()->route('seller.shop.index');
        }

        return view('seller.shop.create');
    }

    public function store(ShopStoreRequest $request): RedirectResponse
    {
        if (auth()->user()->shop) {
            return redirect()->route('seller.shop.index')
                ->with('error', 'You already have a shop.');
        }

        $data = [
            'name' => $request->validated('shop_name'),
            'description' => $request->validated('description'),
            'location' => $request->validated('location'),
        ];

        if ($request->hasFile('logo')) {
            $data['logo_url'] = $request->file('logo')->store('shops/logos', 'public');
        }

        auth()->user()->shop()->create($data);

        return redirect()->route('seller.shop.index')
            ->with('success', 'Your shop has been created successfully!');
    }

    public function edit(): View|RedirectResponse
    {
        $shop = auth()->user()->shop;

        if (! $shop) {
            return redirect()->route('seller.shop.create')
                ->with('error', 'Create your shop first.');
        }

        return view('seller.shop.edit', compact('shop'));
    }

    public function update(ShopUpdateRequest $request): RedirectResponse
    {
        $shop = auth()->user()->shop;

        if (! $shop) {
            return redirect()->route('seller.shop.create');
        }

        $data = [
            'name' => $request->validated('shop_name'),
            'description' => $request->validated('description'),
            'location' => $request->validated('location'),
        ];

        if ($request->hasFile('logo')) {
            if ($shop->logo_url) {
                Storage::disk('public')->delete($shop->logo_url);
            }
            $data['logo_url'] = $request->file('logo')->store('shops/logos', 'public');
        }

        $shop->update($data);

        return redirect()->route('seller.shop.index')
            ->with('success', 'Shop updated successfully.');
    }

    public function dashboard(): View|RedirectResponse
    {
        $shop = auth()->user()->shop;

        if (! $shop) {
            return redirect()->route('seller.shop.create');
        }

        $products = $shop->products()->with('category')->latest()->get();

        return view('seller.shop.index', [
            'shop' => $shop,
            'products' => $products,
            'productCount' => $products->count(),
        ]);
    }
}
