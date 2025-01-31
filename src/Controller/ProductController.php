<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ProductServiceInterface;
use App\Entity\Product;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

class ProductController extends AbstractController
{
    public function __construct(private ProductServiceInterface $productService)
    {
    }

    #[Route(path: '/', name: 'app_home')]
    public function index(): Response
    {
        $products = $this->productService->list();

        return $this->render(view: 'home/home.html.twig', parameters: ['products' => $products]);
    }

    #[Route(path: '/product/{id}', name: 'app_product_show')]
    public function show(Product $product = null): Response
    {
        return $this->render(view: 'product/show.html.twig', parameters: ['product' => $product]);
    }
}
