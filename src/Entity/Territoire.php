<?php

namespace App\Entity;

use App\Repository\TerritoireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TerritoireRepository::class)
 */
class Territoire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Site::class, mappedBy="territoire")
     */
    private $sites;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Prescripteur::class, mappedBy="territoire")
     */
    private $prescripteurs;

    public function __construct()
    {
        $this->sites = new ArrayCollection();
        $this->prescripteurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Site[]
     */
    public function getSite(): Collection
    {
        return $this->sites;
    }

    public function addSite(Site $sites): self
    {
        if (!$this->sites->contains($sites)) {
            $this->sites[] = $sites;
            $sites->setTerritoire($this);
        }

        return $this;
    }

    public function removeSite(Site $sites): self
    {
        if ($this->site->removeElement($sites)) {
            // set the owning side to null (unless already changed)
            if ($sites->getTerritoire() === $this) {
                $sites->setTerritoire(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Prescripteur[]
     */
    public function getPrescripteurs(): Collection
    {
        return $this->prescripteurs;
    }

    public function addPrescripteur(Prescripteur $prescripteur): self
    {
        if (!$this->prescripteurs->contains($prescripteur)) {
            $this->prescripteurs[] = $prescripteur;
            $prescripteur->setTerritoire($this);
        }

        return $this;
    }

    public function removePrescripteur(Prescripteur $prescripteur): self
    {
        if ($this->prescripteurs->removeElement($prescripteur)) {
            // set the owning side to null (unless already changed)
            if ($prescripteur->getTerritoire() === $this) {
                $prescripteur->setTerritoire(null);
            }
        }

        return $this;
    }
}
