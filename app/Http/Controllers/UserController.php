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

    public function getAllUser() {
        return $this->service->getAllUser();
    }

    public function setPin(UpdatePinUserRequest $request) {
        try {
            return $this->service->setPinUser($request->user()->id, $request->pin);
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

    public function getUserByPhonenumberOrId($parameterId) {
        try {
            return $this->service->getUserByPhonenumberOrId((int)$parameterId);
        } catch (\Throwable $error) {
            return $this->json->responseError($error->getMessage());
        }
    }

    public function validatePinUser(Request $request) {
        try {
            $request->validate(["pin" => ["required", "digits:6", "numeric"]]);
            return $this->service->validatePinUser($request->user()->id, $request->pin);
        } catch (\Throwable $error) {
            return $this->json->responseError($error->getMessage());
        }
    }
}
