<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShopController extends Controller
{
    public function create()
    {
        if (auth()->user()->shop) {
            return redirect()->route('seller.dashboard');
        }
        return Inertia::render('Shop/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
        ]);

        auth()->user()->shop()->create($request->all());

        return redirect()->route('seller.dashboard');
    }

    public function dashboard()
    {
        $shop = auth()->user()->shop;
        if (! $shop) {
            return redirect()->route('shop.create');
        }
        
        $products = $shop->products()->with('images')->latest()->get();

        return Inertia::render('Seller/Dashboard', [
            'shop' => $shop,
            'products' => $products,
        ]);
    }
}
