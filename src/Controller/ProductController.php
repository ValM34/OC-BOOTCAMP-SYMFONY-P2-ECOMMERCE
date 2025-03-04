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
use App\Entity\Customer;
use App\Repository\OrderRepository;
use App\Form\EditOrderedProductQuantityType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\OrderedProductRepository;
use App\Entity\Order;
use App\Entity\OrderedProduct;

class ProductController extends AbstractController
{
  public function __construct(
    private ProductServiceInterface $productService,
    private OrderRepository $orderRepository,
    private EntityManagerInterface $entityManager,
    private OrderedProductRepository $orderedProductRepository
  ) {}

  #[Route(path: '/', name: 'app_home')]
  public function index(): Response
  {
    $products = $this->productService->list();

    return $this->render(view: 'home/home.html.twig', parameters: ['products' => $products]);
  }

  #[Route(path: '/product/{id}', name: 'app_product_show')]
  public function show(?Product $product = null, Request $request): Response
  {
    if (!$this->getUser()) {
      return $this->render(view: 'product/show.html.twig', parameters: ['product' => $product]);
    }

    $order = $this->orderRepository->findByCustomer($this->getUser());

    if (!$order) {
      $form = $this->createForm(EditOrderedProductQuantityType::class);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $order = new Order();
        $order->setCustomer($this->getUser());
        $order->setValidated(false);
        $orderedProduct = $form->getData();
        $orderedProduct->setProduct($product);
        $orderedProduct->setOrderItem($order);
        
        $this->entityManager->persist($order);
        $this->entityManager->persist($orderedProduct);
        $this->entityManager->flush();
      }

      return $this->render(
        view: 'product/show.html.twig',
        parameters: ['product' => $product, 'form' => $form->createView(),
        'btn_text' => 'Ajouter au panier']
      );
    }

    $orderedProduct = $this->orderedProductRepository->findByProductAndOrder($product, $order);

    if (!$orderedProduct) {
      $form = $this->createForm(EditOrderedProductQuantityType::class);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $orderedProduct = $form->getData();
        $orderedProduct->setProduct($product);
        $orderedProduct->setOrderItem($order);
        $this->entityManager->persist($orderedProduct);
        $this->entityManager->flush();
      }

      return $this->render(
        view: 'product/show.html.twig',
        parameters: ['product' => $product, 'order' => $order, 'form' => $form->createView(),
        'btn_text' => 'Mettre à jour']
      );
    }

    $form = $this->createForm(EditOrderedProductQuantityType::class, $orderedProduct);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      if($orderedProduct->getQuantity() === 0) {
        $orderedProducts = $this->orderedProductRepository->findByOrder($order);
        if(count($orderedProducts) === 1) {
          $this->entityManager->remove($order);
        } else {
          $this->entityManager->remove($orderedProduct);
        }
        $this->entityManager->flush();

        return $this->render(
          view: 'product/show.html.twig',
          parameters: ['product' => $product, 'order' => $order, 'form' => $form->createView(),
          'btn_text' => 'Ajouter au panier']
        );
      }
      $this->entityManager->persist($form->getData());
      $this->entityManager->flush();
    }

    return $this->render(
      view: 'product/show.html.twig',
      parameters: ['product' => $product, 'order' => $order, 'form' => $form->createView(),
      'btn_text' => 'Mettre à jour']
    );
  }
}
