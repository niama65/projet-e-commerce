<?php

namespace App\Mapper;

use App\DTO\AddCartItemDto;
use App\Entity\CartItem;
use App\Entity\Product;

class CartItemMapper
{
    public function toCartItem(AddCartItemDto $dto, Product $product): CartItem
    {
        $item = new CartItem();
        $item->setProduct($product);
        $item->setQuantity($dto->quantity);
        $item->setPrice($product->getPrice());

        return $item;
    }
}