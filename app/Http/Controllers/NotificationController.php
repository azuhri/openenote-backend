<?php

namespace App\Http\Controllers;

use App\Http\Services\JsonServices;
use App\Http\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public NotificationService $service;
    public JsonServices $json;

    public function __construct(NotificationService $service, JsonServices $json)
    {
        $this->service = $service;
        $this->json = $json;
    }

    public function getNotification() {
        try {
            return $this->service->getNotification(Auth::user()->id);
        } catch (\Throwable $error) {
            return $this->json->responseError($error->getMessage());
        }
    }
}
