<?php

namespace App\Services\Implements;

use App\Services\UserService;

class UserServiceImplementation implements UserService
{
    // Implement your methods here
    private array $users = [
        "bagus" => "semesta"
    ];

    function login(string $user, string $password): bool
    {
        if(!isset($this->users[$user])) 
        {
            return false;
        }

        $correctPassword=$this->users[$user];
        return $password == $correctPassword;
    }
}