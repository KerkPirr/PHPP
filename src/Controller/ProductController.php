<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;


class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function createProduct(ManagerRegistry $doctrine): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(1999);
        $product->setDescription('Ergonomic and stylish!');
        $entityManager->persist($product);
        $entityManager->flush();
        return new JsonResponse('Saved new product with id '.$product->getId());
    }
    #[Route('/product/{id}', name: 'product_show')]
    public function show(int $id, ProductRepository $productRepository): JsonResponse
    {
        $product = $productRepository
            ->find($id);
        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return new JsonResponse('Check out this great product: '.$product->getName());


    }
}

