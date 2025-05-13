<?php

namespace App\Http\Controllers;

use App\Repository\Impl\INotificationRepository;

class NotificationController extends Controller
{
    private $notificationRepository;

    public function __construct(INotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function markAllAsRead()
    {
        $userId = auth()->user()->id;
        $result = $this->notificationRepository->markAllAsRead($userId);

        if (!$result) {
            return redirect()->back()->with('error', 'Something went wrong!');
        } else {
            return redirect()->back()->with('success', 'All Notifications set to read');
        }
    }
}
