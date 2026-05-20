<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $notifications = $request->user()
            ->notifications()
            ->paginate(20);

        $layout = match (true) {
            $request->user()->isAdmin() => 'layouts.admin',
            $request->user()->isSeller() => 'layouts.seller',
            default => 'layouts.public',
        };

        return view('notifications.index', compact('notifications', 'layout'));
    }

    public function markAsRead(Request $request, string $id): RedirectResponse
    {
        $notification = $this->findNotification($request, $id);
        $notification->markAsRead();

        $url = $notification->data['url'] ?? route('notifications.index');

        return redirect($url);
    }

    public function markAllAsRead(Request $request): RedirectResponse
    {
        $request->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }

    private function findNotification(Request $request, string $id): DatabaseNotification
    {
        $notification = $request->user()->notifications()->where('id', $id)->first();

        abort_unless($notification, 404);

        return $notification;
    }
}
