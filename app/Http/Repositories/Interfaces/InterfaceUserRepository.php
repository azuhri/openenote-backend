<?php

namespace App\Http\Repositories\Interfaces;

use App\Http\DTO\UserDTO;
use Illuminate\Http\Request;
use App\Models\User;

interface InterfaceUserRepository {
    public function createUser(UserDTO $request);
    public function getUserById($userId);
    public function getUserByPhonenumber($phonenumber);
    public function setPinUser(User $user, $pin);
    public function isExistPhonenumber($userId, $phonenumber);
    public function isExistEmail($userId, $phonenumber);
    public function validatePinUser($userId, $pin);
    public function getAllUser();
    public function getUserLogin();
    public function updateUser(UserDTO $user, $userId);
    public function updateBalanceUser($userId, $amount);
}

