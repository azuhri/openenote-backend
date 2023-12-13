<?php

namespace App\Http\Repositories\Interfaces;

use App\Http\DTO\NotificationDTO;

interface InterfaceNotificationRepository {
    public function notify(NotificationDTO $request);
    public function getNotification($userId);
}