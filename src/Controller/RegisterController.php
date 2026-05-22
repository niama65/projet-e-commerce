<?php

namespace App\Controller;

use App\DTO\RegisterUserDto;
use App\Form\Type\RegisterType;
use App\Service\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegisterController extends AbstractController
{
    public function __construct(
        private UserServiceInterface $userService
    ) {}

    #[Route('/register', name: 'app_register')]
    public function index(Request $request): Response
    {
        $dto = new RegisterUserDto();

        $form = $this->createForm(RegisterType::class, $dto);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->register($dto);

            return $this->redirectToRoute('app_login');
        }

        return $this->render('register/index.html.twig', [
            'registerForm' => $form,
        ]);
    }
}