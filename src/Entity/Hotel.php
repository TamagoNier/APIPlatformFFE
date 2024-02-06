<?php

namespace App\Entity;

use App\Repository\HotelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HotelRepository::class)]
class Hotel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse2 = null;

    #[ORM\Column(length: 5)]
    private ?string $cp = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column(length: 10)]
    private ?string $tel = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\OneToMany(mappedBy: 'hotel', targetEntity: Nuite::class, orphanRemoval: true)]
    private Collection $nuites;

    #[ORM\OneToMany(mappedBy: 'hotel', targetEntity: Proposer::class, orphanRemoval: true)]
    private Collection $tarifs;

    public function __construct()
    {
        $this->nuites = new ArrayCollection();
        $this->tarifs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAdresse1(): ?string
    {
        return $this->adresse1;
    }

    public function setAdresse1(string $adresse1): static
    {
        $this->adresse1 = $adresse1;

        return $this;
    }

    public function getAdresse2(): ?string
    {
        return $this->adresse2;
    }

    public function setAdresse2(?string $adresse2): static
    {
        $this->adresse2 = $adresse2;

        return $this;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(string $cp): static
    {
        $this->cp = $cp;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * @return Collection<int, Nuite>
     */
    public function getNuites(): Collection
    {
        return $this->nuites;
    }

    public function addNuite(Nuite $nuite): static
    {
        if (!$this->nuites->contains($nuite)) {
            $this->nuites->add($nuite);
            $nuite->setHotel($this);
        }

        return $this;
    }

    public function removeNuite(Nuite $nuite): static
    {
        if ($this->nuites->removeElement($nuite)) {
            // set the owning side to null (unless already changed)
            if ($nuite->getHotel() === $this) {
                $nuite->setHotel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Proposer>
     */
    public function getTarifs(): Collection
    {
        return $this->tarifs;
    }

    public function addTarif(Proposer $tarif): static
    {
        if (!$this->tarifs->contains($tarif)) {
            $this->tarifs->add($tarif);
            $tarif->setHotel($this);
        }

        return $this;
    }

    public function removeTarif(Proposer $tarif): static
    {
        if ($this->tarifs->removeElement($tarif)) {
            // set the owning side to null (unless already changed)
            if ($tarif->getHotel() === $this) {
                $tarif->setHotel(null);
            }
        }

        return $this;
    }
}
