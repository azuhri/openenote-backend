<?php 

namespace App\Http\Repositories\Interfaces;
use App\Http\DTO\TransactionDTO;

interface InterfaceTransactionRepository {
    public function createTransaction(TransactionDTO $request);
    public function createTransactionTopUp($userId, $amount);
    public function getTransactionByTransactionCode($transactionCode);
    public function getUserTransactionById($userId);
}