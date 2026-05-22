<?php

namespace App\Mapper;

use App\DTO\RegisterUserDto;
use App\Entity\User;

class UserMapper
{
    public function toEntity(RegisterUserDto $dto): User
    {
        $user = new User();

        $user->setNom($dto->getNom());
        $user->setPrenom($dto->getPrenom());
        $user->setEmail($dto->getEmail());
        $user->setRoles(['ROLE_USER']);

        return $user;
    }
}