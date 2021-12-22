<?php

namespace App\Entity;

use App\Repository\PrescripteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PrescripteurRepository::class)
 */
class Prescripteur
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
    private $prescripteurName;

    /**
     * @ORM\OneToMany(targetEntity=Apprenant::class, mappedBy="prescripteur")
     */
    private $apprenants;

    public function __construct()
    {
        $this->apprenants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrescripteurName(): ?string
    {
        return $this->prescripteurName;
    }

    public function setPrescripteurName(string $prescripteurName): self
    {
        $this->prescripteurName = $prescripteurName;

        return $this;
    }

    /**
     * @return Collection|Apprenant[]
     */
    public function getApprenants(): Collection
    {
        return $this->apprenants;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenants->contains($apprenant)) {
            $this->apprenants[] = $apprenant;
            $apprenant->setPrescripteur($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenants->removeElement($apprenant)) {
            // set the owning side to null (unless already changed)
            if ($apprenant->getPrescripteur() === $this) {
                $apprenant->setPrescripteur(null);
            }
        }

        return $this;
    }
}
