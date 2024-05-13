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

    public function navRedirection(CategoriesRepository $categoriesRepo, ProductsRepository $productsRepo): Response
    {
        // Récupérer toutes les catégories
        $categories = $categoriesRepo->findAll();
        
        // Initialisez un tableau pour stocker les produits associés à chaque catégorie
        $productsByCategory = [];
    
        // Pour chaque catégorie, récupérez les produits associés et stockez-les dans le tableau
        foreach ($categories as $categorie) {
            $categoryId = $categorie->getId();
            $products = $productsRepo->findBy(['categorie' => $categoryId]);
            $productsByCategory[$categoryId] = $products;
        }
    
        // Passez les catégories et les produits associés à votre vue Twig (base.html.twig dans ce cas)
        return $this->render('base.html.twig', [
            'categories' => $categories,
            'productsByCategory' => $productsByCategory,
        ]);
    }
    
}
