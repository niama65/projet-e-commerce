<?php

namespace App\Repository;

interface CategoryRepositoryInterface
{
    public function findAllCategories(): array;
}