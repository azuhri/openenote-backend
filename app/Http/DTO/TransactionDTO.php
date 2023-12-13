<?php 

namespace App\Http\DTO;
use Illuminate\Support\Str;

class TransactionDTO {
    public $senderId;
    public $receiverId;
    public $amount;
    public $transaactionCode;

    public function __construct($senderId, $receiverId, $amount)
    {
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
        $this->amount = $amount;
        $this->transaactionCode = "TRX-".date("YmdHis")."-".\strtoupper(Str::random(6));
    }
}