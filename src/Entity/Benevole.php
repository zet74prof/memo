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
     * @ORM\ManyToMany(targetEntity=TypeFormation::class, inversedBy="benevole")
     */
    private $lien_type_enseignement;

    public function __construct()
    {
        $this->lien_type_enseignement = new ArrayCollection();
    }

    /**
     * @return Collection|TypeFormation[]
     */
    public function getLienTypeEnseignement(): Collection
    {
        return $this->lien_type_enseignement;
    }

    public function addLienTypeEnseignement(TypeFormation $lienTypeEnseignement): self
    {
        if (!$this->lien_type_enseignement->contains($lienTypeEnseignement)) {
            $this->lien_type_enseignement[] = $lienTypeEnseignement;
            $lienTypeEnseignement->setBenevole($this);
        }

        return $this;
    }

    public function removeLienTypeEnseignement(TypeFormation $lienTypeEnseignement): self
    {
        if ($this->lien_type_enseignement->removeElement($lienTypeEnseignement)) {
            // set the owning side to null (unless already changed)
            if ($lienTypeEnseignement->getBenevole() === $this) {
                $lienTypeEnseignement->setBenevole(null);
            }
        }

        return $this;
    }
}
