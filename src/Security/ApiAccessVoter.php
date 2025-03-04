<?php

namespace App\Security;

use App\Entity\Customer;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ApiAccessVoter extends Voter
{
  const API_ACCESS = 'api_access';

  protected function supports(string $attribute, mixed $subject): bool
  {
    if (!in_array($attribute, [self::API_ACCESS])) {
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

    return match ($attribute) {
      self::API_ACCESS => $this->canAccessToApi($customer),
      default => throw new \LogicException('This code should not be reached!')
    };
  }

  private function canAccessToApi(Customer $customer): bool
  {
    return $customer->getApiAccess();
  }
}
