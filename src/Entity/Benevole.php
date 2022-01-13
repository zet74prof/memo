<?php

namespace App\Entity;

use App\Repository\BenevoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BenevoleRepository::class)
 */
class Benevole extends User
{
    /**
     * @ORM\ManyToMany(targetEntity=TypeEnseignement::class, mappedBy="lien_typeEnseignement")
     */
    private $typeEnseignements;

    public function __construct()
    {
        $this->typeEnseignements = new ArrayCollection();
    }

    /**
     * @return Collection|TypeEnseignement[]
     */
    public function getTypeEnseignements(): Collection
    {
        return $this->typeEnseignements;
    }

    public function addTypeEnseignement(TypeEnseignement $typeEnseignement): self
    {
        if (!$this->typeEnseignements->contains($typeEnseignement)) {
            $this->typeEnseignements[] = $typeEnseignement;
            $typeEnseignement->addLienTypeEnseignement($this);
        }

        return $this;
    }

    public function removeTypeEnseignement(TypeEnseignement $typeEnseignement): self
    {
        if ($this->typeEnseignements->removeElement($typeEnseignement)) {
            $typeEnseignement->removeLienTypeEnseignement($this);
        }

        return $this;
    }
}
