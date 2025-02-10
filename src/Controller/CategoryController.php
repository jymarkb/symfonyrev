<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/category', name: 'category.')]
final class CategoryController extends AbstractController
{

    private CategoryRepository $categoryRepository;
    private PostRepository $postResitory;
    public function __construct(CategoryRepository $categoryRepository, PostRepository $postResitory)
    {
        $this->categoryRepository = $categoryRepository;
        $this->postResitory = $postResitory;
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $categories = $this->categoryRepository->getCategories();
        $posts = $this->postResitory->findAll();
        // dump($posts);
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
            'posts' => $posts
        ]);
    }

    #[Route('/api/{id}', name: 'selectCategoryById', methods:'GET')]
    public function showByCategory(int $id) : JsonResponse
    {
        $category = $this->categoryRepository->find($id);

        if (!$category) {
            return $this->json(
                ['error' => 'Category not found'],
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        $posts = $this->postResitory->findPostByCategoryId($category->getId());

        return $this->json(
            ['category' => $category->getId(), 'post' => $posts],
            JsonResponse::HTTP_OK,
            [],
            ['groups' => 'category:read']
        );
    }
}
