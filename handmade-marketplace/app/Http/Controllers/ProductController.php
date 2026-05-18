<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function create(): View|RedirectResponse
    {
        if (! auth()->user()->shop) {
            return redirect()->route('shop.create')
                ->with('error', 'Create your shop before adding products.');
        }

        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category' => 'nullable|string',
        ]);

        auth()->user()->shop->products()->create($validated);

        return redirect()->route('shop.dashboard')
            ->with('success', 'Product added successfully.');
    }
}
