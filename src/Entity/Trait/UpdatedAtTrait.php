<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

trait UpdatedAtTrait
{
  #[ORM\Column]
  private ?\DateTimeImmutable $updatedAt = null;

  public function getUpdatedAt(): ?\DateTimeImmutable
  {
    return $this->updatedAt;
  }

  #[ORM\PreUpdate]
  #[ORM\PrePersist]
  public function setUpdatedAt(): void
  {
    $this->updatedAt = new \DateTimeImmutable();
  }
}
