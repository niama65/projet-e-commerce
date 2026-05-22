<?php

namespace App\Service;

use App\DTO\RegisterUserDto;
use App\Entity\User;
use App\Mapper\UserMapper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService implements UserServiceInterface
{
    public function __construct(
        private UserMapper $userMapper,
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function register(RegisterUserDto $dto): User
    {
        $user = $this->userMapper->toEntity($dto);

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $dto->getPassword()
        );

        $user->setPassword($hashedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}