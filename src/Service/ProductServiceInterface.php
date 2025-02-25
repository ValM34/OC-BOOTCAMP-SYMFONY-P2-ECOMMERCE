<?php

namespace App\Service;

use App\Entity\Product;
use App\Entity\Customer;
use App\Entity\OrderedProduct;

interface ProductServiceInterface
{
    public function list(): array;
    public function getOrderedProduct(Customer $customer): OrderedProduct;
}
