<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
  #[Route('/utilisateur/mon-compte', name: 'app_account')]
  public function listOrdersPaid(): Response
  {
    return $this->render('order/list-account.html.twig', []);
  }

  #[Route('/utilisateur/panier', name: 'app_card')]
  public function listOrderInProgress(): Response
  {
    return $this->render('order/list-card.html.twig', []);
  }
}
