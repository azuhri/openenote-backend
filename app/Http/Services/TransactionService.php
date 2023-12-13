<?php

namespace App\Http\Services;

use App\Http\DTO\LogDTO;
use App\Http\DTO\NotificationDTO;
use App\Http\DTO\TransactionDTO;
use App\Http\DTO\UserDTO;
use App\Http\Repositories\LogRepository;
use App\Http\Repositories\NotificationRepository;
use App\Http\Repositories\TransactionRepository;
use App\Http\Repositories\UserRepository;
use App\Mail\TransactionNotificationEmail;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class TransactionService
{
    public TransactionRepository $transactionRepository;
    public UserRepository $userRepository;
    public LogRepository $logRepository;
    public NotificationRepository $notificationRepository;
    public JsonServices $json;

    public function __construct(
        TransactionRepository $transactionRepo,
        UserRepository $userRepo,
        LogRepository $logRepo,
        NotificationRepository $notifRepo,
        JsonServices $json
    ) {
        $this->transactionRepository = $transactionRepo;
        $this->userRepository = $userRepo;
        $this->logRepository = $logRepo;
        $this->notificationRepository = $notifRepo;
        $this->json = $json;
    }

    public function createTransaction($receiverPhonenumber, $pin, $amount)
    {
        if (Auth::user()->phonenumber == $receiverPhonenumber)
            throw new Exception("phonenumber receiver cannot be the same as the sender's");

        if(!$this->userRepository->validatePinUser(Auth::user()->id, $pin)) 
            throw new Exception("pin doesnt correct!");
            

        if (!$receiver = $this->userRepository->getUserByPhonenumber($receiverPhonenumber))
            throw new Exception("phonenumber receiver not found");

        if (Auth::user()->balance < $amount)
            throw new Exception("sorry the balance is insufficient");

        $dto = new TransactionDTO(Auth::user()->id, $receiver->id, $amount);

        if (!$transaction = $this->transactionRepository->createTransaction($dto))
            throw new Exception("error when creating new transaction");

        $this->transactionProcess(Auth::user(), $receiver, $amount);

        return $this->json->responseDataWithMessage($transaction, "success create new transaction");
    }

    public function topup($amount)
    {
        $data = $this->transactionRepository->createTransactionTopUp(Auth::user()->id, $amount);
        $this->userRepository->updateBalanceUser(Auth::user()->id, Auth::user()->balance + $amount);
        return  $this->json->responseDataWithMessage($data, "success topup!");
    }

    public function getUserTransactionById($userId)
    {
        if (!count($data = $this->transactionRepository->getUserTransactionById($userId)))
            throw new Exception("data transaction not found!");

        return $this->json->responseData($data);
    }

    public function transactionProcess($sender,  $receiver, $amount) {
        $this->logRepository->logging(new LogDTO("DEBIT", $sender->balance, $sender->balance - $amount), $sender->id);
        $this->userRepository->updateBalanceUser($sender->id, $sender->balance - $amount);
        $this->notificationRepository->notify(new NotificationDTO($sender->id, "Hallo, Kak  ".$sender->name.". Anda baru tranfer uang sejumlah Rp".number_format($amount, 0, ",", '.')." ke ".$receiver->name));

        $this->logRepository->logging(new LogDTO("CREDIT", $receiver->balance, $receiver->balance - $amount), $receiver->id);
        $this->userRepository->updateBalanceUser($receiver->id, $receiver->balance + $amount);
        $this->notificationRepository->notify(new NotificationDTO($sender->id, "Hallo, Kak  ".$receiver->name.". Anda baru ditranfer uang sejumlah Rp".number_format($amount, 0, ",", '.')." dari ".Auth::user()->name));
        
        Mail::to($sender->email)->send(new TransactionNotificationEmail([
            "subject" => "Anda Berhasil Mengirimkan Dana Sejumlah Rp".number_format($amount, 0, ",", '.')." ke ".$receiver->name,
            "message" => "Hallo, Kak {$sender->name}. Anda berhasil mentransfer dana Sejumlah Rp".number_format($amount, 0, ",", '.')." ke ".$receiver->name,
            "balance" => $sender->balance + $amount,
        ]));

        Mail::to($receiver->email)->send(new TransactionNotificationEmail([
            "subject" => "Anda Berhasil Dikirimi Dana Sejumlah Rp".number_format($amount, 0, ",", '.')." oleh ".$sender->name,
            "message" => "Hallo, Kak {$receiver->name}. Anda ditransfer dana Sejumlah Rp".number_format($amount, 0, ",", '.')." oleh ".$sender->name,
            "balance" => $receiver->balance + $amount,
        ]));
    }
}
