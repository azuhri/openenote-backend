<?php

namespace App\Http\DTO;

class NotificationDTO {
    public $userId;
    public $message;

    public function __construct($userId, $message)
    {
        $this->userId = $userId;
        $this->message = $message;
    }
    
}