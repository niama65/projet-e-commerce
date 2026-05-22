<?php

namespace App\Controller;

use App\DTO\AddCartItemDto;
use App\Service\CartServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CartController extends AbstractController
{
    public function __construct(
        private CartServiceInterface $cartService
    ) {}

    #[Route('/cart', name: 'cart_show')]
    public function index(): Response
    {
        $cart = $this->cartService->getCart();

        return $this->render('cart/cart.html.twig', [
            'cart' => $cart,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'cart_add', methods: ['GET', 'POST'])]
    public function add(int $id, Request $request): Response
    {
        $quantity = (int) $request->request->get('quantity', 1);

        $dto = new AddCartItemDto($id, $quantity);

        $this->cartService->addToCart($dto);

        return $this->redirectToRoute('cart_show');
    }

    #[Route('/cart/clear', name: 'cart_clear')]
    public function clear(): Response
    {
        $this->cartService->clearCart();

        return $this->redirectToRoute('cart_show');
    }
    #[Route('/cart/remove/{id}', name: 'cart_remove')]
public function remove(int $id): Response
{
    $this->cartService->removeFromCart($id);

    return $this->redirectToRoute('cart_show');
}
}