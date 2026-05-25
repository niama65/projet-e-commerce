<?php

namespace App\Controller;

use App\DTO\AddCartItemDto;
use App\Entity\Cart;
use App\Entity\CartItem;
use App\Repository\ProductRepositoryInterface;
use App\Service\Cart\CartHandler;
use App\Service\Cart\CartInterface;
use App\Service\Cart\SessionCart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CartController extends AbstractController
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private CartHandler $cartHandler,

        #[Autowire(service: SessionCart::class)]
        private CartInterface $cartStrategy
    ) {}

    #[Route('/cart', name: 'cart_show')]
    public function index(): Response
    {
        $cart = $this->cartHandler->handle(new Cart(), $this->cartStrategy);

        return $this->render('cart/cart.html.twig', [
            'cart' => $cart,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'cart_add', methods: ['GET', 'POST'])]
    public function add(int $id, Request $request): Response
    {
        $product = $this->productRepository->findProductById($id);

        if (!$product) {
            throw $this->createNotFoundException('Produit introuvable');
        }

        $quantity = (int) $request->request->get('quantity', 1);

        $dto = new AddCartItemDto($id, $quantity);

        $item = new CartItem();
        $item->setProduct($product);
        $item->setQuantity($dto->quantity);
        $item->setPrice($product->getPrice());

        $cart = $this->cartHandler->handle(new Cart(), $this->cartStrategy);

        $this->cartStrategy->add($item, $cart);

        return $this->redirectToRoute('cart_show');
    }

    #[Route('/cart/clear', name: 'cart_clear')]
    public function clear(): Response
    {
        $this->cartStrategy->clearCart('cart_items');

        return $this->redirectToRoute('cart_show');
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function remove(int $id): Response
    {
        $this->cartStrategy->removeByProductId($id);

        return $this->redirectToRoute('cart_show');
    }
}