<?php

namespace App\Http\Controllers;

use App\Http\DTO\UserDTO;
use App\Http\Requests\UpdatePinUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Services\JsonServices;
use Illuminate\Http\Request;
use App\Http\Services\UserService;

class UserController extends Controller
{
    public UserService $service;
    public JsonServices $json;
    public function __construct(UserService $service, JsonServices $json)
    {
        $this->service = $service;
        $this->json = $json;
    }

    public function getUser() {
        try {
            return $this->service->getUserLogin();
        } catch (\Throwable $error) {
            return $this->json->responseError($error->getMessage());
        }
    }

    public function updateUser(UpdateUserRequest $request) {
        try {
            $dtoUser = new UserDTO(
                $request->name,
                $request->email,
                $request->phonenumber
            );
            return $this->service->updateDataUser($dtoUser, $request->user()->id);
        } catch (\Throwable $error) {
            return $this->json->responseError($error->getMessage());
        }
    }
}
