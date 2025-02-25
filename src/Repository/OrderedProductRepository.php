<?php

namespace App\Repository;

use App\Entity\OrderedProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Product;
use App\Entity\Order;

/**
 * @extends ServiceEntityRepository<OrderedProduct>
 */
class OrderedProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderedProduct::class);
    }

    public function findByProductAndOrder(Product $product, Order $order): array
    {
        return $this->createQueryBuilder('op')
           ->select('op')
           ->andWhere('op.product = :product')
           ->andWhere('op.orderItem = :order')
           ->setParameter('product', $product)
           ->setParameter('order', $order)
           ->getQuery()
           ->getResult()
       ;
    }

    public function findByOrder(Order $order): array
    {
        return $this->createQueryBuilder('op')
           ->select('op')
           ->andWhere('op.orderItem = :order')
           ->setParameter('order', $order)
           ->getQuery()
           ->getResult()
       ;
    }

    //    /**
    //     * @return OrderedProduct[] Returns an array of OrderedProduct objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('o.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?OrderedProduct
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
