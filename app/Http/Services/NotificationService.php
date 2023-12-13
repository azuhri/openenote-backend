<?php

namespace App\Http\Services;

use App\Http\Repositories\NotificationRepository;
use Exception;

class NotificationService
{
    public NotificationRepository $notificationRepository;
    public JsonServices $json;

    public function __construct(NotificationRepository $notifRepo, JsonServices $json)
    {
        $this->notificationRepository = $notifRepo;
        $this->json = $json;
    }

    public function getNotification($userId)
    {
        if (!\count($data = $this->notificationRepository->getNotification($userId)))
            throw new Exception("data log transaction not found");

        return $this->json->responseData($data);
    }
}
