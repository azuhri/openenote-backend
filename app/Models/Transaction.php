<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        "sender_id",
        "receiver_id",
        "amount",
        "transaction_code"
    ];

    public function sender() {
        return $this->belongsTo(User::class, "sender_id","id");
    }

    public function receiver() {
        return $this->belongsTo(User::class, "receiver_id","id");
    }
}
