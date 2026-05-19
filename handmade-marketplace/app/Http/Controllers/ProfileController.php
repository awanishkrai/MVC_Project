<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfilePasswordUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(Request $request): View
    {
        $user = $request->user()->load('shop');
        $view = match (true) {
            $user->isSeller() && $request->routeIs('seller.settings') => 'seller.settings',
            $user->isAdmin() && $request->routeIs('admin.settings') => 'admin.settings',
            default => 'public.profile.show',
        };

        return view($view, compact('user'));
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return $this->profileRedirect()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(ProfilePasswordUpdateRequest $request): RedirectResponse
    {
        $request->user()->update([
            'password' => Hash::make($request->validated('password')),
        ]);

        return $this->profileRedirect()->with('success', 'Password changed successfully.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Your account has been deleted.');
    }

    private function profileRedirect(): RedirectResponse
    {
        $user = auth()->user();

        if ($user->isSeller()) {
            return redirect()->route('seller.settings');
        }
        if ($user->isAdmin()) {
            return redirect()->route('admin.settings');
        }

        return redirect()->route('profile.show');
    }
}
