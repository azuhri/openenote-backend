<?php

namespace App\Http\Controllers;

use App\Http\Services\JsonServices;
use App\Http\Services\LoggingServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public LoggingServices $service;
    public JsonServices $json;

    public function __construct(LoggingServices $service, JsonServices $json)
    {
        $this->service = $service;
        $this->json = $json;
    }

    public function getLog() {
        try {
            return $this->service->getLogs(Auth::user()->id);
        } catch (\Throwable $error) {
            return $this->json->responseError($error->getMessage());
        }
    }
}
