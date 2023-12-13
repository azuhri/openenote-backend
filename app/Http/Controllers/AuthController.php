<?php

namespace App\Http\Controllers;

use App\Http\DTO\UserDTO;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Services\UserService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public UserService $service;
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }
 
    public function register(UserRegisterRequest $request) {
        try {
            $dtoUser = new UserDTO(
                $request->name,
                $request->email,
                $request->phonenumber
            );
            $dtoUser->setPassword($request->password);
            return $this->service->register($dtoUser);
        } catch (\Throwable $error) {
            return \response()->json(["errors" => $error->getMessage()], 500);
        }
    }

    public function login(LoginRequest $request) {
        try {
            if($request->email) {
                return $this->service->loginWithEmail($request->email, $request->password);
            }
            if($request->phonenumber) {
                return $this->service->loginWithPhonenumber($request->phonenumber, $request->password);
            }
        } catch (\Throwable $error) {
            return \response()->json(["errors" => $error->getMessage()], 500);
        }
    }
}