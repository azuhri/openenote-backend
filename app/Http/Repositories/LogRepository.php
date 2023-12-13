<?php

namespace App\Http\Repositories;

use App\Http\DTO\LogDTO;
use App\Http\Repositories\Interfaces\InterfaceLogRepository;
use App\Models\Log;

class LogRepository implements InterfaceLogRepository {
    public function logging(LogDTO $request, $userId)
    {
        return Log::create([
            "user_id" => $userId,
            "transaction_type" => $request->transactionType,
            "previous_balance" => $request->previousBalance,
            "balance" => $request->balance,
        ]);
    }

    public function getLogs($userId)
    {
        return Log::where("user_id", $userId)->orderBy("created_at", "ASC")->get();
    }
}