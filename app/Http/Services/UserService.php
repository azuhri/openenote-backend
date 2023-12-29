<?php

namespace App\Http\Services;

use App\Http\DTO\UserDTO;
use App\Http\Repositories\UserRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService {
    public UserRepository $userRepository;
    public JsonServices $json;

    public function __construct(UserRepository $userRepo, JsonServices $json){
        $this->userRepository = $userRepo;
        $this->json = $json;
    }
    
    public function register(UserDTO $dto) {
        if(!$user = $this->userRepository->createUser($dto)) {
            throw new Exception("error when creating new user!");
        }

        Auth::attempt([
            "email" => $user->email,
            "password" => $user->password,
        ]);
        
        $data = [
            ...$user->toArray(),
            "token" => $user->createToken("tokenUser")->accessToken
        ];
        return $this->json->responseData($data);
    }

    public function loginWithEmail(string $email, $password) {
        $credentials = Auth::attempt([
            "email" => $email,
            "password" => $password
        ]);

        if(!$credentials) 
            throw new Exception("email or password doesnt correct!");

        $user = Auth::user();
        $data =  [...$user->toArray(), "token" => $user->createToken("tokenUser")->accessToken];

        return $this->json->responseData($data);
    }
    
    public function loginWithPhonenumber(string $phonenumber, string $password) {
        if(!$user = $this->userRepository->getUserByPhonenumber($phonenumber))
            throw new Exception("email or password doesnt correct!");

        if(!Hash::check($password, $user->password))
            throw new Exception("email or password doesnt correct!");
    
        Auth::loginUsingId($user->id);
        $user = Auth::user();
        $data =  [...$user->toArray(), "token" => $user->createToken("tokenUser")->accessToken];

        return $this->json->responseData($data);
    }

    public function getUserLogin() {
        if(!$user = Auth::user()) {
            throw new Exception("session login doenst exist!");
        }

        return $this->json->responseData($user);
    }

    public function setPinUser($userId, $pin) {
        if(!$user = $this->userRepository->getUserById($userId))
            throw new Exception("data user not found");

        $this->userRepository->setPinUser($user, $pin);

        return $this->json->responseDataWithMessage($user, "success update pin user");
    }

    public function updateDataUser(UserDTO $user, $userId) {
        if($this->userRepository->isExistEmail($userId, $user->email)) {
            throw new Exception("email already was exist!");
        }

        $user = $this->userRepository->updateUser($user, $userId);

        return $this->json->responseDataWithMessage($user, "success update user");
    }

    public function getAllUser() {
        return $this->json->responseData($this->userRepository->getAllUser());
    }

    public function getUserByPhonenumberOrId($parameterId) {
        if($user = $this->userRepository->getUserById($parameterId)) {
            return $this->json->responseData($user);
        }

        if($user = $this->userRepository->getUserByPhonenumber($parameterId)) {
            return $this->json->responseData($user);
        }
        
        throw new Exception("data user not found");        
    }

    public function validatePinUser($userId, $pin) {
        if(!$user = $this->userRepository->validatePinUser($userId, $pin)) 
            throw new Exception("pin doesnt correct!");

        return $this->json->responseDataWithMessage($user, "pin corrected!");
    }
}