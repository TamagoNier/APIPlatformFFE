<?php

namespace App\Entity;

use App\Repository\AtelierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AtelierRepository::class)]
class Atelier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column]
    private ?int $nbPlacesMaxi = null;

    #[ORM\ManyToMany(targetEntity: Inscription::class, inversedBy: 'ateliers')]
    private Collection $insciptions;

    #[ORM\ManyToMany(targetEntity: Theme::class, mappedBy: 'ateliers')]
    private Collection $themes;

    #[ORM\OneToMany(mappedBy: 'atelier', targetEntity: Vacation::class, orphanRemoval: true)]
    private Collection $vacation;

    public function __construct()
    {
        $this->insciptions = new ArrayCollection();
        $this->themes = new ArrayCollection();
        $this->vacation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getNbPlacesMaxi(): ?int
    {
        return $this->nbPlacesMaxi;
    }

    public function setNbPlacesMaxi(int $nbPlacesMaxi): static
    {
        $this->nbPlacesMaxi = $nbPlacesMaxi;

        return $this;
    }

    /**
     * @return Collection<int, Inscription>
     */
    public function getInsciptions(): Collection
    {
        return $this->insciptions;
    }

    public function addInsciption(Inscription $insciption): static
    {
        if (!$this->insciptions->contains($insciption)) {
            $this->insciptions->add($insciption);
        }

        return $this;
    }

    public function removeInsciption(Inscription $insciption): static
    {
        $this->insciptions->removeElement($insciption);

        return $this;
    }

    /**
     * @return Collection<int, Theme>
     */
    public function getThemes(): Collection
    {
        return $this->themes;
    }

    public function addTheme(Theme $theme): static
    {
        if (!$this->themes->contains($theme)) {
            $this->themes->add($theme);
            $theme->addAtelier($this);
        }

        return $this;
    }

    public function removeTheme(Theme $theme): static
    {
        if ($this->themes->removeElement($theme)) {
            $theme->removeAtelier($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Vacation>
     */
    public function getVacation(): Collection
    {
        return $this->vacation;
    }

    public function addVacation(Vacation $vacation): static
    {
        if (!$this->vacation->contains($vacation)) {
            $this->vacation->add($vacation);
            $vacation->setAtelier($this);
        }

        return $this;
    }

    public function removeVacation(Vacation $vacation): static
    {
        if ($this->vacation->removeElement($vacation)) {
            // set the owning side to null (unless already changed)
            if ($vacation->getAtelier() === $this) {
                $vacation->setAtelier(null);
            }
        }

        return $this;
    }
}
