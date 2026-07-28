<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $notifications = AppNotification::where('user_id', $request->user()->id)
            ->orderByDesc('id')
            ->limit(20)
            ->get();

        return response()->json([
            'notifications' => $notifications,
            'unread_count'  => AppNotification::where('user_id', $request->user()->id)->unread()->count(),
        ]);
    }

    public function markRead(Request $request, AppNotification $notification): RedirectResponse
    {
        abort_unless($notification->user_id === $request->user()->id, 403);

        $notification->update(['read_at' => now()]);

        return back();
    }

    public function markAllRead(Request $request): RedirectResponse
    {
        AppNotification::where('user_id', $request->user()->id)->unread()->update(['read_at' => now()]);

        return back();
    }
}
