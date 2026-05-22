<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Compound;

#[\Attribute]
class RequiredField extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\NotNull(message: 'Champ obligatoire'),
            new Assert\NotBlank(message: 'Ce champ ne doit pas etre vide'),
        ];
    }
}