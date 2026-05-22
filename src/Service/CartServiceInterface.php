<?php

namespace App\Service;

use App\DTO\AddCartItemDto;
use App\Entity\Cart;

interface CartServiceInterface
{
    public function addToCart(AddCartItemDto $dto): Cart;

    public function getCart(): Cart;

    public function clearCart(): void;
    public function removeFromCart(int $productId): void;
}