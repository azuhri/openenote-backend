<?php

namespace App\Http\Repositories\Interfaces;

use App\Http\DTO\LogDTO;

interface InterfaceLogRepository {
    public function logging(LogDTO $request, $userId);
    public function getLogs($userId);
}