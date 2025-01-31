<?php

namespace App\Service;

use App\Entity\Product;

interface ProductServiceInterface
{
    public function list(): array;
}
