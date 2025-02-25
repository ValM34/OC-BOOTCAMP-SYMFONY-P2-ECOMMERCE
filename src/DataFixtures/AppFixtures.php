<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Customer;
use App\Entity\Order;
use App\Entity\OrderedProduct;
use App\Entity\Product;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $orders = [];
        for($i = 0; $i < 20; $i++) {
            $customer = new Customer();
            $customer->setEmail('customer_'.$i.'@mail.com');
            $customer->setPassword($this->passwordHasher->hashPassword($customer, '12345678'));
            $customer->setFirstName($faker->firstName());
            $customer->setLastName($faker->lastName());
            $manager->persist($customer);

            for($j = 0; $j < mt_rand(2, 5); $j++) {
                $order = new Order();
                $order->setCustomer($customer);
                $order->setValidated(true);
                $manager->persist($order);
                $orders[] = $order;
            }

            $order = new Order();
            $order->setCustomer($customer);
            $order->setValidated(false);
            $manager->persist($order);
            $orders[] = $order;
        }

        $products = [];
        for($i = 0; $i < 20; $i++) {
            $product = new Product();
            $product->setName("Product name " . $i);
            $product->setShortDescription($faker->sentence());
            $product->setFullDescription($faker->paragraph() . $faker->paragraph() . $faker->paragraph());
            $product->setPrice(mt_rand(10, 100));
            $product->setPicturePath('images/products/product-default.jpg');
            $manager->persist($product);
            $products[] = $product;
        }

        foreach($orders as $order) {
            for($i = 0; $i < mt_rand(2, 4); $i++) {
                $orderedProduct = new OrderedProduct();
                $randomProduct = $products[array_rand($products)];
                $orderedProduct->setProduct($randomProduct);
                $orderedProduct->setOrderItem($order);
                $orderedProduct->setQuantity(mt_rand(1, 5));
                $manager->persist($orderedProduct);
            }
        }

        $manager->flush();
    }
}
