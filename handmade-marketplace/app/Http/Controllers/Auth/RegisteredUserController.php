<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Concerns\RedirectsUsersByRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
  use RedirectsUsersByRole;

  public function create(): View
  {
    return view('auth.register');
  }

  public function store(Request $request): RedirectResponse
  {
    $validated = $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
      'password' => ['required', 'confirmed', 'min:8'],
      'role' => ['required', 'string', 'in:buyer,seller'],
    ], [
      'name.required' => 'Full name is required.',
      'email.unique' => 'This email is already registered.',
      'password.min' => 'Password must be at least 8 characters.',
      'password.confirmed' => 'Password confirmation does not match.',
      'role.in' => 'Please select Buyer or Seller.',
    ]);

    $user = User::create([
      'name' => $validated['name'],
      'email' => $validated['email'],
      'password' => $validated['password'],
      'role' => $validated['role'],
    ]);

    event(new Registered($user));

    Auth::login($user);
    $request->session()->regenerate();

    return $this->redirectToRoleDashboard($user)
      ->with('success', 'Welcome to CraftNest! Your account has been created.');
  }
}
