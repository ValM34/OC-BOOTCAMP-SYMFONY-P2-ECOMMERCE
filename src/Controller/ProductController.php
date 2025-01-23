<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/home.html.twig', []);
    }

    // #[Route('/product/{id}', name: 'app_product_show')]
    #[Route('/product/1', name: 'app_product_show')]
    // public function show(int $id): Response
    public function show(): Response
    {
        return $this->render('product/show.html.twig', []);
    }
}
