<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Customer;

/**
 * @extends ServiceEntityRepository<Order>
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function findByCustomer(Customer $customer): ?Order
    {
        return $this->createQueryBuilder('o')
           ->select('o')
           ->andWhere('o.customer = :customer')
           ->setParameter('customer', $customer)
           ->andWhere('o.validated = false')
           ->leftJoin('o.orderedProducts', 'op')
           ->leftJoin('op.product', 'p')
           ->getQuery()
           ->getOneOrNullResult()
       ;
    }

    public function findByCustomerAndValidated(Customer $customer): array
    {
        return $this->createQueryBuilder('o')
           ->select('o')
           ->andWhere('o.customer = :customer')
           ->setParameter('customer', $customer)
           ->andWhere('o.validated = true')
           ->leftJoin('o.orderedProducts', 'op')
           ->leftJoin('op.product', 'p')
           ->getQuery()
           ->getResult()
       ;
    }

//    /**
//     * @return Order[] Returns an array of Order objects
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

//    public function findOneBySomeField($value): ?Order
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
