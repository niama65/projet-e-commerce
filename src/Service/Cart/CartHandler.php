<?php

namespace App\Service\Cart;

use App\Entity\Cart;

class CartHandler
{
    public function handle(Cart $cart, CartInterface $strategy): Cart
    {
        return $strategy->getCart('cart_items');
    }
}