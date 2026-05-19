<div class="grid gap-6 lg:grid-cols-2">
    <section class="cn-card p-6">
        <h2 class="font-display text-lg font-semibold text-stone-900">Edit profile</h2>
        <form method="POST" action="{{ route('profile.update') }}" class="mt-4 space-y-4">
            @csrf @method('patch')
            <div>
                <label class="cn-label" for="name">Full name</label>
                <input class="cn-input" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="cn-label" for="email">Email</label>
                <input class="cn-input" id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required>
                @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <button type="submit" class="cn-btn-primary">Save changes</button>
        </form>
    </section>
    <section class="cn-card p-6">
        <h2 class="font-display text-lg font-semibold text-stone-900">Change password</h2>
        <form method="POST" action="{{ route('profile.password.update') }}" class="mt-4 space-y-4">
            @csrf @method('put')
            <div>
                <label class="cn-label" for="current_password">Current password</label>
                <input class="cn-input" id="current_password" name="current_password" type="password" required>
                @error('current_password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="cn-label" for="password">New password</label>
                <input class="cn-input" id="password" name="password" type="password" required>
                @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="cn-label" for="password_confirmation">Confirm password</label>
                <input class="cn-input" id="password_confirmation" name="password_confirmation" type="password" required>
            </div>
            <button type="submit" class="cn-btn-primary">Update password</button>
        </form>
    </section>
</div>
<section class="cn-card mt-6 border-red-200 p-6">
    <h2 class="font-display text-lg font-semibold text-red-800">Delete account</h2>
    <form method="POST" action="{{ route('profile.destroy') }}" class="mt-4 max-w-md" onsubmit="return confirm('Delete account permanently?');">
        @csrf @method('delete')
        <label class="cn-label" for="del_password">Password</label>
        <input class="cn-input mb-3" id="del_password" name="password" type="password" required>
        <button type="submit" class="rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">Delete account</button>
    </form>
</section>
