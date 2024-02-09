<?php

namespace App\Entity;

use App\Repository\RestaurationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestaurationRepository::class)]
class Restauration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateRestauration = null;

    #[ORM\Column(length: 60)]
    private ?string $typeRepas = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateRestauration(): ?\DateTimeInterface
    {
        return $this->dateRestauration;
    }

    public function setDateRestauration(\DateTimeInterface $dateRestauration): static
    {
        $this->dateRestauration = $dateRestauration;

        return $this;
    }

    public function getTypeRepas(): ?string
    {
        return $this->typeRepas;
    }

    public function setTypeRepas(string $typeRepas): static
    {
        $this->typeRepas = $typeRepas;

        return $this;
    }
}
