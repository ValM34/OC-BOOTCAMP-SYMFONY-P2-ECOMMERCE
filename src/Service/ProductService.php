<?php

namespace App\Service;

use App\Entity\Product;
use App\Service\ProductServiceInterface;
use App\Repository\ProductRepository;

class ProductService implements ProductServiceInterface
{
  public function __construct(private ProductRepository $productRepository)
  {
  }

  public function list(): array
  {
    return $this->productRepository->findAll();
  }
}
