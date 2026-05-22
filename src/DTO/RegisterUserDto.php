<?php

namespace App\DTO;

use App\Validator\Constraints\PasswordField;
use App\Validator\Constraints\RequiredField;
use Symfony\Component\Validator\Constraints as Assert;

class RegisterUserDto
{
    #[RequiredField]
    private ?string $nom = null;

    #[RequiredField]
    private ?string $prenom = null;

    #[Assert\Email(message: 'Cette adresse email est invalide.')]
    #[RequiredField]
    private ?string $email = null;

    #[RequiredField]
    #[PasswordField(message: 'Le mot de passe doit contenir au minimum 8 caractères, une majuscule, une minuscule, un chiffre et @, - ou _.')]
    private ?string $password = null;

    public function getNom(): ?string { return $this->nom; }
    public function setNom(?string $nom): void { $this->nom = $nom; }

    public function getPrenom(): ?string { return $this->prenom; }
    public function setPrenom(?string $prenom): void { $this->prenom = $prenom; }

    public function getEmail(): ?string { return $this->email; }
    public function setEmail(?string $email): void { $this->email = $email; }

    public function getPassword(): ?string { return $this->password; }
    public function setPassword(?string $password): void { $this->password = $password; }
}