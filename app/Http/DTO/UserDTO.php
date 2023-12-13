<?php
namespace App\Http\DTO;

class UserDTO {
    public string $name;
    public string $email;
    public string $phonenumber;
    public string $password;
    public string $pin;
    

    public function __construct(string $name, string $email, string $phonenumber)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phonenumber = $phonenumber;
    }

    public function setPassword(string $password) {
        $this->password = \bcrypt($password);
    }

    public function setPin(int $pin) {
        $this->pin = $pin;
    }
}