<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

trait CreatedAtTrait
{
  #[ORM\Column]
  private ?\DateTimeImmutable $createdAt = null;

  public function getCreatedAt(): ?\DateTimeImmutable
  {
    return $this->createdAt;
  }

  #[ORM\PrePersist]
  public function setCreatedAtValue(): void
  {
      $this->createdAt = new \DateTimeImmutable();
  }
}
