<?php

namespace App\Http\DTO;

class LogDTO {
    public $transactionType;
    public $previousBalance;
    public $balance;

    public function __construct($transactionType, $previousBalance, $balance)
    {
        $this->transactionType = $transactionType;
        $this->previousBalance = $previousBalance;
        $this->balance = $balance;
    }
}