<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function create(): View|RedirectResponse
    {
        if (auth()->user()->shop) {
            return redirect()->route('shop.dashboard');
        }

        return view('shop.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
        ]);

        auth()->user()->shop()->create($request->only('name', 'description', 'location'));

        return redirect()->route('shop.dashboard')
            ->with('success', 'Your shop has been created!');
    }

    public function dashboard(): View|RedirectResponse
    {
        $shop = auth()->user()->shop;

        if (! $shop) {
            return redirect()->route('shop.create');
        }

        $products = $shop->products()->with('images')->latest()->get();

        return view('shop.dashboard', compact('shop', 'products'));
    }
}
