<?php

namespace App\Http\Services;

use App\Http\DTO\LogDTO;
use App\Http\Repositories\LogRepository;
use Exception;

class LoggingServices {
    public LogRepository $logRepository;
    public JsonServices $json;

    public function __construct(LogRepository $logRepo, JsonServices $json) {
        $this->logRepository = $logRepo;
        $this->json = $json;
    }

    public function getLogs($userId) {
        if(!\count($data = $this->logRepository->getLogs($userId)))
            throw new Exception("data log transaction not found");

        return $this->json->responseData($data);
    }
}