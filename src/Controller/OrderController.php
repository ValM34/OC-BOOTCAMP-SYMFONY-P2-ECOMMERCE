<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OrderRepository;
use App\Repository\OrderedProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;
use App\Entity\Order;
use App\Entity\OrderedProduct;
use Symfony\Component\Security\Http\Attribute\IsGranted;
class OrderController extends AbstractController
{
  public function __construct(
    private OrderRepository $orderRepository,
    private OrderedProductRepository $orderedProductRepository,
    private EntityManagerInterface $entityManager
  )
  {
  }

  #[Route(path: '/utilisateur/mon-compte', name: 'app_account')]
  public function listOrdersPaid(): Response
  {
    $orders = $this->orderRepository->findByCustomerAndValidated($this->getUser());

    return $this->render('order/list-account.html.twig', ['orders' => $orders]);
  }

  #[Route(path: '/utilisateur/toggle-api-access', name: 'app_toggle_api_access')]
  public function toggleApiAccess(): Response
  {
    $this->getUser()->setApiAccess(!$this->getUser()->getApiAccess());
    $this->entityManager->flush();
    
    return $this->redirectToRoute('app_account');
  }

  #[Route(path: '/utilisateur/panier', name: 'app_card')]
  public function listOrderInProgress(): Response
  {
    $card = $this->orderRepository->findByCustomer($this->getUser());

    if(!$card) {
      return $this->render('order/list-card.html.twig');
    }

    return $this->render('order/list-card.html.twig', ['card' => $card]);
  }

  #[Route(path: '/utilisateur/panier/valider/{id}', name: 'app_card_validate', methods: ['GET'])]
  public function validateCard($id): Response
  {
    $card = $this->orderRepository->find($id);

    if(!$this->isGranted('validate', $card)) {
      $this->addFlash('error', 'Vous n\'avez pas les droits pour valider cette commande');
      return $this->redirectToRoute('app_card');
    }

    $card->setValidated(true);
    $this->entityManager->flush();

    $this->addFlash('success', 'Commande validée avec succès');

    return $this->redirectToRoute('app_card');
  }

  #[Route(path: '/utilisateur/panier/vider/{id}', name: 'app_card_clear')]
  public function clearCard($id): Response
  {
    $card = $this->orderRepository->find($id);

    $this->entityManager->remove($card);
    $this->entityManager->flush();

    return $this->redirectToRoute('app_card');
  }
}
