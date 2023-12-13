<?php

namespace App\Http\Repositories;

use App\Http\DTO\TransactionDTO;
use App\Http\Repositories\Interfaces\InterfaceTransactionRepository;
use App\Models\Topup;
use App\Models\Transaction;
use Illuminate\Support\Str;

class TransactionRepository implements InterfaceTransactionRepository
{
    public function createTransaction(TransactionDTO $request)
    {
        return Transaction::create([
            "sender_id" => $request->senderId,
            "receiver_id" => $request->receiverId,
            "amount" => $request->amount,
            "transaction_code" => $request->transaactionCode
        ]);
    }

    public function getTransactionByTransactionCode($transactionCode)
    {
        return Transaction::where("transaction_code", $transactionCode)->first();
    }

    public function createTransactionTopUp($userId, $amount)
    {
        return Topup::create([
            "user_id" => $userId,
            "amount" => $amount,
            "transaction_code" => "TRX-" . date("YmdHis") . \strtoupper(Str::random(6))
        ]);
    }

    public function getUserTransactionById($userId)
    {
        $transactions = Transaction::with([
            'sender:id,name,phonenumber',
            'receiver:id,name,phonenumber'
        ])->where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->get(['id', 'sender_id', 'receiver_id', 'transaction_code', 'amount', 'created_at', 'updated_at']);

        $transactions = $transactions->map(function ($transaction) use ($userId) {
            $transaction->transaction_type = $transaction->sender_id == $userId ? 'DEBIT' : 'CREDIT';
            return $transaction;
        });

        return $transactions;
    }
}
