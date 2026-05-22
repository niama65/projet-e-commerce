<?php

namespace App\Service;

use App\DTO\RegisterUserDto;
use App\Entity\User;

interface UserServiceInterface
{
    public function register(RegisterUserDto $dto): User;
}