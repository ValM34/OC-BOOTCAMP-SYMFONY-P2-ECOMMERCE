<?php

namespace App\Service;

use App\Entity\OrderedProduct;
use App\Entity\Product;
use App\Service\ProductServiceInterface;
use App\Repository\ProductRepository;
use App\Entity\Customer;
use App\Repository\CustomerRepository;
use App\Repository\OrderRepository;
use App\Repository\OrderedProductRepository;

class ProductService implements ProductServiceInterface
{
  public function __construct(private ProductRepository $productRepository, private CustomerRepository $customerRepository, private OrderRepository $orderRepository, private OrderedProductRepository $orderedProductRepository)
  {
  }

  public function list(): array
  {
    return $this->productRepository->findAll();
  }

  public function getOrderedProduct(Customer $customer): OrderedProduct
  {
    $orders = $this->orderRepository->findBy(criteria: ['customer' => $customer, 'validated' => false]);
    $orderedProducts = $this->orderedProductRepository->findBy(criteria: ['orderItem' => $orders[0]]);
    dd($orderedProducts);
  }
}
