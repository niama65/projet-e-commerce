<?php

namespace App\Cart;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Repository\ProductRepositoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class SessionCart implements CartInterface
{
    public function __construct(
        private RequestStack $requestStack,
        private ProductRepositoryInterface $productRepository
    ) {}

    public function add(CartItem $item, Cart $cart): Cart
{
    $session = $this->requestStack->getSession();

    $items = $session->get('cart_items', []);

    $items[] = [
        'product_id' => $item->getProduct()->getId(),
        'quantity' => $item->getQuantity(),
        'price' => $item->getPrice(),
    ];

    $session->set('cart_items', $items);

    #dd($session->get('cart_items'));

    return $this->getCart('cart_items');
}
public function remove(CartItem $item, Cart $cart): Cart
{
    $this->removeByProductId($item->getProduct()->getId());

    return $this->getCart('cart_items');
}
    public function removeByProductId(int $productId): void
{
    $session = $this->requestStack->getSession();

    $items = $session->get('cart_items', []);

    foreach ($items as $key => $item) {
        if ($item['product_id'] == $productId) {
            unset($items[$key]);
            break;
        }
    }

    $session->set('cart_items', array_values($items));
}

    public function getCart(string $identifier): Cart
    {
        $session = $this->requestStack->getSession();
        $items = $session->get($identifier, []);

        $cart = new Cart();

        foreach ($items as $sessionItem) {
            $product = $this->productRepository->findProductById($sessionItem['product_id']);

            if (!$product) {
                continue;
            }

            $cartItem = new CartItem();
            $cartItem->setProduct($product);
            $cartItem->setQuantity($sessionItem['quantity']);
            $cartItem->setPrice($sessionItem['price']);

            $cart->addCartItem($cartItem);
        }

        return $cart;
    }

    public function clearCart(string $identifier): void
    {
        $this->requestStack->getSession()->remove($identifier);
    }
}