<?php

namespace App\Entity;

use App\Repository\BailleurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BailleurRepository::class)
 */
class Bailleur
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
     * @ORM\OneToMany(targetEntity=BailleurHisto::class, mappedBy="bailleur")
     */
    private $bailleurHistos;

    public function __construct()
    {
        $this->bailleurHistos = new ArrayCollection();
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
     * @return Collection|BailleurHisto[]
     */
    public function getBailleurHistos(): Collection
    {
        return $this->bailleurHistos;
    }

    public function addBailleurHisto(BailleurHisto $bailleurHisto): self
    {
        if (!$this->bailleurHistos->contains($bailleurHisto)) {
            $this->bailleurHistos[] = $bailleurHisto;
            $bailleurHisto->setBailleur($this);
        }

        return $this;
    }

    public function removeBailleurHisto(BailleurHisto $bailleurHisto): self
    {
        if ($this->bailleurHistos->removeElement($bailleurHisto)) {
            // set the owning side to null (unless already changed)
            if ($bailleurHisto->getBailleur() === $this) {
                $bailleurHisto->setBailleur(null);
            }
        }

        return $this;
    }
}
