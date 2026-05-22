<?php

namespace App\Service;

use App\Cart\CartHandler;
use App\Cart\CartInterface;
use App\DTO\AddCartItemDto;
use App\Entity\Cart;
use App\Mapper\CartItemMapper;
use App\Repository\ProductRepositoryInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class CartService implements CartServiceInterface
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private CartItemMapper $cartItemMapper,
        private CartHandler $cartHandler,

        #[Autowire(service: 'App\Cart\SessionCart')]
        private CartInterface $cartStrategy
    ) {}

    public function addToCart(AddCartItemDto $dto): Cart
    {
        $product = $this->productRepository->findProductById($dto->productId);

        if (!$product) {
            throw new \Exception('Produit introuvable');
        }

        $cart = $this->cartHandler->handle(new Cart(), $this->cartStrategy);

        $item = $this->cartItemMapper->toCartItem($dto, $product);

        return $this->cartStrategy->add($item, $cart);
    }

    public function getCart(): Cart
    {
        return $this->cartHandler->handle(new Cart(), $this->cartStrategy);
    }

    public function clearCart(): void
    {
        $this->cartStrategy->clearCart('cart_items');
    }

    public function removeFromCart(int $productId): void
    {
        if (method_exists($this->cartStrategy, 'removeByProductId')) {
            $this->cartStrategy->removeByProductId($productId);
        }
    }
}