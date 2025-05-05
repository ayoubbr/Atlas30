<?php

namespace App\Repository;

use App\Models\Notification;
use App\Repository\Impl\INotificationRepository;

class NotificationRepository implements INotificationRepository
{
    public function markAllAsRead(int $userId): bool
    {
        $notifications = Notification::where('user_id', $userId)
            ->where('status', 'unread')
            ->get();

        if ($notifications->count() < 1) {
            return false;
        }

        foreach ($notifications as $notification) {
            $notification->status = 'read';
            $notification->save();
        }

        return true;
    }
}
