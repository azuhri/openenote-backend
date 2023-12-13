<?php

namespace App\Http\Repositories;

use App\Http\DTO\NotificationDTO;
use App\Http\Repositories\Interfaces\InterfaceNotificationRepository;
use App\Http\Services\JsonServices;
use App\Models\Notification;
use Exception;

class NotificationRepository implements InterfaceNotificationRepository {

    public function notify(NotificationDTO $request)
    {
        return Notification::create([
            "user_id" => $request->userId,
            "message" => $request->message,
        ]);
    }

    public function getNotification($userId)
    {
        return Notification::where("user_id", $userId)->orderBy("created_at","DESC")->get();
    }
}