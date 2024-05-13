<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Category;
use App\Entity\Products;
use App\Repository\ProductsRepository;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(CategoriesRepository $categoriesRepo, ProductsRepository $productsRepo): Response
    {
        $categories = $categoriesRepo->findAll();
        $latestProducts = $productsRepo->findBy([], ['createdAt' => 'DESC'], 3);

        return $this->render('home/index.html.twig', [
            'categories' => $categories,
            'latestProducts' => $latestProducts
        ]);
    }

    #[Route('/categories', name: 'categories')]
    public function getCategories(CategoriesRepository $categoriesRepo): Response
    {
        $categories = $categoriesRepo->findAll();

        return $this->render('home/categories.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/category/{id}', name: 'category.products')]
    public function categoryProducts(Categories $category, ProductsRepository $productRepository): Response
    {
        // $products = $category->getProducts(); (Directement depuis l'entité)

        // $products = $em->getRepository(Products::class)->findBy(
        //     ['category' => $category],
        //     ['id' => 'DESC'] 
        // );

        $products = $productRepository->findProductsByCategorySortedByIdDesc($category);

        return $this->render('home/category_products.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/product/{id}', name: 'product.details')]
    public function showProductDetails(Products $product): Response
    {
        return $this->render('home/products.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/basket}', name: 'basket.details')]
    public function getBasket(): Response
    {
        return $this->render('home/basket.html.twig');
    }

}
