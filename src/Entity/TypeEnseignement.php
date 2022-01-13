<?php

namespace App\Entity;

use App\Repository\TypeEnseignementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeEnseignementRepository::class)
 */
class TypeEnseignement
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
     * @ORM\ManyToMany(targetEntity=Benevole::class, inversedBy="typeEnseignements")
     */
    private $lien_typeEnseignement;

    public function __construct()
    {
        $this->lien_typeEnseignement = new ArrayCollection();
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
     * @return Collection|benevole[]
     */
    public function getLienTypeEnseignement(): Collection
    {
        return $this->lien_typeEnseignement;
    }

    public function addLienTypeEnseignement(benevole $lienTypeEnseignement): self
    {
        if (!$this->lien_typeEnseignement->contains($lienTypeEnseignement)) {
            $this->lien_typeEnseignement[] = $lienTypeEnseignement;
        }

        return $this;
    }

    public function removeLienTypeEnseignement(benevole $lienTypeEnseignement): self
    {
        $this->lien_typeEnseignement->removeElement($lienTypeEnseignement);

        return $this;
    }
}
