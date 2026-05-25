<?php

namespace App\Controller;

use App\Repository\CategoryRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategoriesController extends AbstractController
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository
    ) {}

    #[Route('/categories', name: 'categories')]
    public function index(): Response
    {
        $categories = $this->categoryRepository->findAllCategories();

        return $this->render('categories/browse_categories.html.twig', [
            'categories' => $categories,
        ]);
    }
}