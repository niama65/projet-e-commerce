<?php

namespace App\DTO;

class AddCartItemDto
{
    public function __construct(
        public int $productId,
        public int $quantity = 1
    ) {}
}