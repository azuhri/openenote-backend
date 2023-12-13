<?php

namespace App\Http\Repositories;

use App\Http\DTO\UserDTO;
use App\Http\Repositories\Interfaces\InterfaceUserRepository;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRepository implements InterfaceUserRepository {

    public function createUser(UserDTO $request)  {
        return User::create([
            "name" => $request->name,
            "email" => $request->email, 
            "phonenumber" => $request->phonenumber,
            "password" => $request->password,
        ]);   
    }

    public function getUserById($userId)  {
        return User::find($userId);   
    }

    public function getUserLogin() {
        return Auth::user();
    }

    public function setPinUser(User $user, $pin) {
        $user->pin = $pin;
        $user->update();
        return $user;
    }

    public function getUserByPhonenumber($phonenumber){
        return User::where("phonenumber", $phonenumber)->first();
    }

    public function getAllUser()  {
        return User::all(); 
    }

    public function updateUser(UserDTO $request, $userId)  {
        $user = User::find($userId);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phonenumber = $request->phonenumber;
        $user->save();
        return $user;   
    }

    public function isExistPhonenumber($userId, $phonenumber)
    {
        return User::where("id","!=", $userId)->where("phonenumber", $phonenumber)->first();
    }

    public function isExistEmail($userId, $email)
    {
        return User::where("id","!=", $userId)->where("email", $email)->first();
    }

    public function validatePinUser($userId, $pin)
    {
        return User::where("id", $userId)->where("pin", $pin)->first();
    }

    public function updateBalanceUser($userId, $amount) {
        $user = $this->getUserById($userId);
        $user->balance = $amount;
        $user->update();
        return $user;
    }
}
