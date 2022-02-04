<?php

namespace App\Entity;

use App\Repository\RessourceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RessourceRepository::class)
 */
class Ressource
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
    private $ressourceName;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity=RessourceHisto::class, mappedBy="ressource")
     */
    private $ressourceHistos;

    public function __construct()
    {
        $this->ressourceHistos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRessourceName(): ?string
    {
        return $this->ressourceName;
    }

    public function setRessourceName(string $ressourceName): self
    {
        $this->ressourceName = $ressourceName;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection|RessourceHisto[]
     */
    public function getRessourceHistos(): Collection
    {
        return $this->ressourceHistos;
    }

    public function addRessourceHisto(RessourceHisto $ressourceHisto): self
    {
        if (!$this->ressourceHistos->contains($ressourceHisto)) {
            $this->ressourceHistos[] = $ressourceHisto;
            $ressourceHisto->setRessource($this);
        }

        return $this;
    }

    public function removeRessourceHisto(RessourceHisto $ressourceHisto): self
    {
        if ($this->ressourceHistos->removeElement($ressourceHisto)) {
            // set the owning side to null (unless already changed)
            if ($ressourceHisto->getRessource() === $this) {
                $ressourceHisto->setRessource(null);
            }
        }

        return $this;
    }
}
