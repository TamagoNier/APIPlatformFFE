<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateInscription = null;

    #[ORM\ManyToMany(targetEntity: Restauration::class)]
    private Collection $restauration;

    #[ORM\ManyToMany(targetEntity: Atelier::class, mappedBy: 'insciptions')]
    private Collection $ateliers;

    #[ORM\OneToMany(mappedBy: 'inscription', targetEntity: Nuite::class, cascade:["persist"])]
    private Collection $nuites;

    #[Assert\Choice(['En Attente', 'Valide'])]
    #[ORM\Column(length: 255)]
    private ?string $status = null;

    public function __construct() {
        $this->nuites = new ArrayCollection();
        $this->restauration = new ArrayCollection();
        $this->ateliers = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getDateInscription(): ?\DateTimeInterface {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): static {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    /**
     * @return Collection<int, Nuite>
     */
    public function getNuites(): Collection {
        return $this->nuites;
    }

    public function addNuite(Nuite $nuite): static {
        if (!$this->nuites->contains($nuite)) {
            $this->nuites->add($nuite);
        }

        return $this;
    }

    public function removeNuite(Nuite $nuite): static {
        if ($this->nuites->removeElement($nuite)) {
            // set the owning side to null (unless already changed)
            if ($nuite->getInscription() === $this) {
                $nuite->setInscription(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Restauration>
     */
    public function getRestauration(): Collection {
        return $this->restauration;
    }

    public function addRestauration(Restauration $restauration): static {
        if (!$this->restauration->contains($restauration)) {
            $this->restauration->add($restauration);
        }

        return $this;
    }

    public function removeRestauration(Restauration $restauration): static {
        $this->restauration->removeElement($restauration);

        return $this;
    }

    /**
     * @return Collection<int, Atelier>
     */
    public function getAteliers(): Collection {
        return $this->ateliers;
    }

    public function addAtelier(Atelier $atelier): static {
        if (!$this->ateliers->contains($atelier)) {
            $this->ateliers->add($atelier);
            $atelier->addInsciption($this);
        }

        return $this;
    }

    public function removeAtelier(Atelier $atelier): static {
        if ($this->ateliers->removeElement($atelier)) {
            $atelier->removeInsciption($this);
        }

        return $this;
    }

    public function addAteliers(Collection $ateliers): static {
        foreach ($ateliers as $atelier) {
            $this->addAtelier($atelier);
        }
        return $this;
    }

    public function addRestaurations(Collection $restaurations): static {
        foreach ($restaurations as $restauration) {
            $this->addRestauration($restauration);
        }
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }
}
