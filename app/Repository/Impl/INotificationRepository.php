<?php

namespace App\Repository\Impl;

interface INotificationRepository
{
    public function markAllAsRead(int $userId): bool;
}
