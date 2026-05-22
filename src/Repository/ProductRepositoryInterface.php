<?php

namespace App\Repository;

use App\Entity\Product;

interface ProductRepositoryInterface
{
    public function findProductById(int $id): ?Product;

    public function findByCategory($categoryId): array;
}