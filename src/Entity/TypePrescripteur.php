<?php

namespace App\Entity;

use App\Repository\TypePrescripteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypePrescripteurRepository::class)
 */
class TypePrescripteur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Prescripteur::class, mappedBy="type")
     */
    private $prescripteurs;

    public function __construct()
    {
        $this->prescripteurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $prescripteur->setType($this);
        }

        return $this;
    }

    public function removePrescripteur(Prescripteur $prescripteur): self
    {
        if ($this->prescripteurs->removeElement($prescripteur)) {
            // set the owning side to null (unless already changed)
            if ($prescripteur->getType() === $this) {
                $prescripteur->setType(null);
            }
        }

        return $this;
    }
}
