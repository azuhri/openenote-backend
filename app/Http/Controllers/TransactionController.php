<?php

namespace App\Http\Controllers;

use App\Http\DTO\TransactionDTO;
use App\Http\Requests\CreateTransactionRequest;
use App\Http\Services\JsonServices;
use Illuminate\Http\Request;
use App\Http\Services\TransactionService;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public TransactionService $service;
    public JsonServices $json;
    public function __construct(TransactionService $service, JsonServices $json)
    {
        $this->service = $service;
        $this->json = $json;
    }

    public function createTransaction(CreateTransactionRequest $request) {
        try {
            return $this->service->createTransaction($request->receiver_phonenumber, $request->pin, $request->amount);
        } catch (\Throwable $error) {
            return $this->json->responseError($error->getMessage());
        }
    }

    public function topUpSaldo(Request $request)  {
        try {
            $request->validate(["amount" => ["required","min:1000","numeric"]]);
            return $this->service->topup($request->amount);
        } catch (\Throwable $error) {
            return $this->json->responseError($error->getMessage());
        }
    }

    public function getDataTransactionUser() {
        try {
            return $this->service->getUserTransactionById(Auth::user()->id);
        } catch (\Throwable $error) {
            return $this->json->responseError($error->getMessage());
        }
    }
}
