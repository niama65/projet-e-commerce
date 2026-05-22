<?php

namespace App\Cart;

use App\Entity\Cart;
use App\Entity\CartItem;

class ApiCart implements CartInterface
{
    public function add(CartItem $item, Cart $cart): Cart
    {
        dd('ApiCart add');
    }

    public function remove(CartItem $item, Cart $cart): Cart
    {
        dd('ApiCart remove');
    }

    public function getCart(string $identifier): Cart
    {
        dd('ApiCart getCart');
    }

    public function clearCart(string $identifier): void
    {
        dd('ApiCart clearCart');
    }
}