<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Licencie $Licence = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLicence(): ?Licencie
    {
        return $this->Licence;
    }

    public function setLicence(Licencie $Licence): static
    {
        $this->Licence = $Licence;

        return $this;
    }
}
