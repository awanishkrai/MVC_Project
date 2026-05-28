@extends('layouts.admin')
@section('title', 'Users')
@section('page-title', 'User management')
@section('page-subtitle', 'Manage all marketplace members')

@section('content')
<form method="GET" class="mb-6 flex flex-wrap items-end gap-3 rounded-2xl border border-slate-800 bg-slate-900 p-4">
    <div class="min-w-[140px] flex-1">
        <label class="mb-1 block text-xs text-slate-400">Search</label>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or email" class="w-full rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-sm text-white">
    </div>
    <div class="min-w-[120px]">
        <label class="mb-1 block text-xs text-slate-400">Role</label>
        <select name="role" class="w-full rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-sm text-white">
            <option value="">All roles</option>
            <option value="buyer" @selected(request('role') === 'buyer')>Buyer</option>
            <option value="seller" @selected(request('role') === 'seller')>Seller</option>
            <option value="admin" @selected(request('role') === 'admin')>Admin</option>
        </select>
    </div>
    <button type="submit" class="rounded-lg bg-craft-600 px-4 py-2 text-sm font-semibold text-white hover:bg-craft-500">Filter</button>
    <a href="{{ route('admin.users.index') }}" class="rounded-lg border border-slate-700 px-4 py-2 text-sm text-slate-300 hover:bg-slate-800">Reset</a>
</form>

@if ($users->isEmpty())
    <div class="rounded-2xl border border-dashed border-slate-700 px-8 py-16 text-center">
        <p class="text-4xl">👥</p>
        <h3 class="mt-4 font-display text-xl font-semibold text-white">No users found</h3>
        <p class="mt-2 text-sm text-slate-400">Try adjusting your filters.</p>
    </div>
@else
    <div class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] text-left text-sm">
                <thead class="border-b border-slate-800 bg-slate-950/50 text-xs uppercase tracking-wider text-slate-400">
                    <tr>
                        <th class="px-5 py-4">User</th>
                        <th class="px-5 py-4">Role</th>
                        <th class="px-5 py-4">Orders</th>
                        <th class="px-5 py-4">Joined</th>
                        <th class="px-5 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @foreach ($users as $user)
                        <tr class="hover:bg-slate-800/30">
                            <td class="px-5 py-4">
                                <p class="font-semibold text-slate-200">{{ $user->name }}</p>
                                <p class="text-xs text-slate-500">{{ $user->email }}</p>
                            </td>
                            <td class="px-5 py-4">
                                @if (auth()->id() === $user->id)
                                    <span class="rounded-lg bg-slate-800 px-2 py-1 text-xs text-white capitalize">{{ $user->role }}</span>
                                @else
                                    <form action="{{ route('admin.users.update-role', $user) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" class="rounded-lg border border-slate-700 bg-slate-800 px-2 py-1 text-xs text-white" onchange="this.form.submit()">
                                            <option value="buyer" @selected($user->role === 'buyer')>Buyer</option>
                                            <option value="seller" @selected($user->role === 'seller')>Seller</option>
                                            <option value="admin" @selected($user->role === 'admin')>Admin</option>
                                        </select>
                                    </form>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-slate-300">{{ $user->orders_count }}</td>
                            <td class="px-5 py-4 text-slate-400">{{ $user->created_at->format('M j, Y') }}</td>
                            <td class="px-5 py-4 text-right">
                                @if (auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user completely?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-medium text-red-400 hover:text-red-300">Delete</button>
                                    </form>
                                @else
                                    <span class="text-xs text-slate-500">Active</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-6">{{ $users->links() }}</div>
@endif
@endsection
