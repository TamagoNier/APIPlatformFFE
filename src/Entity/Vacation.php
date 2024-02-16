<?php

namespace App\Entity;

use App\Repository\VacationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VacationRepository::class)]
class Vacation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateheureDebut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateheureFin = null;

    #[ORM\ManyToOne(inversedBy: 'vacation')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Atelier $atelier = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateheureDebut(): ?\DateTimeInterface
    {
        return $this->dateheureDebut;
    }

    public function setDateheureDebut(\DateTimeInterface $dateheureDebut): static
    {
        $this->dateheureDebut = $dateheureDebut;

        return $this;
    }

    public function getDateheureFin(): ?\DateTimeInterface
    {
        return $this->dateheureFin;
    }

    public function setDateheureFin(\DateTimeInterface $dateheureFin): static
    {
        $this->dateheureFin = $dateheureFin;

        return $this;
    }

    public function getAtelier(): ?Atelier
    {
        return $this->atelier;
    }

    public function setAtelier(?Atelier $atelier): static
    {
        $this->atelier = $atelier;

        return $this;
    }
}
