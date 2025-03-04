<?php

namespace App\Security;

use App\Entity\Order;
use App\Entity\Customer;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class OrderValidationVoter extends Voter
{
  const VALIDATE = 'validate';

  protected function supports(string $attribute, mixed $subject): bool
  {
    // if the attribute isn't one we support, return false
    if (!in_array($attribute, [self::VALIDATE])) {
      return false;
    }

    // only vote on `Post` objects
    if (!$subject instanceof Order) {
      return false;
    }

    return true;
  }

  protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
  {
    $customer = $token->getUser();

    if (!$customer instanceof Customer) {
      // the user must be logged in; if not, deny access
      return false;
    }

    /** @var Order $order */
    $order = $subject;

    return match ($attribute) {
      self::VALIDATE => $this->canValidate($order, $customer),
      default => throw new \LogicException('This code should not be reached!')
    };
  }

  private function canValidate(Order $order, Customer $customer): bool
  {
    return $customer === $order->getCustomer();
  }
}
