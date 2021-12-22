<?php

namespace App\Entity;

use App\Repository\ApprenantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApprenantRepository::class)
 */
class Apprenant extends User
{

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $enfantACharge;

    /**
     * @ORM\ManyToOne(targetEntity=Ressource::class, inversedBy="apprenants")
     * @ORM\JoinColumn(nullable=true)
     */
    private $ressource;

    /**
     * @ORM\OneToMany(targetEntity=NivFormHisto::class, mappedBy="apprenant", orphanRemoval=true)
     * @ORM\JoinColumn(nullable=true)
     */
    private $niveauFormation;

    /**
     * @ORM\ManyToOne(targetEntity=TypeFormation::class, inversedBy="apprenants")
     * @ORM\JoinColumn(nullable=true)
     */
    private $typeFormation;

    /**
     * @ORM\ManyToOne(targetEntity=Prescripteur::class, inversedBy="apprenants")
     * @ORM\JoinColumn(nullable=true)
     */
    private $prescripteur;

    /**
     * @ORM\ManyToOne(targetEntity=QPV::class, inversedBy="apprenants")
     * @ORM\JoinColumn(nullable=true)
     */
    private $qpv;

    /**
     * @ORM\Column(type="integer")
     */
    private $situationFamiliale;

    public function __construct()
    {
        parent::__construct();
        $this->niveauFormation = new ArrayCollection();
    }

    public function getEnfantACharge(): ?int
    {
        return $this->enfantACharge;
    }

    public function setEnfantACharge(?int $enfantACharge): self
    {
        $this->enfantACharge = $enfantACharge;

        return $this;
    }

    public function getRessource(): ?Ressource
    {
        return $this->ressource;
    }

    public function setRessource(?Ressource $ressource): self
    {
        $this->ressource = $ressource;

        return $this;
    }

    /**
     * @return Collection|NivFormHisto[]
     */
    public function getNiveauFormation(): Collection
    {
        return $this->niveauFormation;
    }

    public function getLastNiveauFormation():NiveauFormation
    {
        return $this->niveauFormation->last()->getNiveauFormation();
    }

    public function addNiveauFormation(NivFormHisto $niveauFormation): self
    {
        if (!$this->niveauFormation->contains($niveauFormation)) {
            $this->niveauFormation[] = $niveauFormation;
            $niveauFormation->setApprenant($this);
        }

        return $this;
    }

    public function removeNiveauFormation(NivFormHisto $niveauFormation): self
    {
        if ($this->niveauFormation->removeElement($niveauFormation)) {
            // set the owning side to null (unless already changed)
            if ($niveauFormation->getApprenant() === $this) {
                $niveauFormation->setApprenant(null);
            }
        }

        return $this;
    }

    public function getTypeFormation(): ?TypeFormation
    {
        return $this->typeFormation;
    }

    public function setTypeFormation(?TypeFormation $typeFormation): self
    {
        $this->typeFormation = $typeFormation;

        return $this;
    }

    public function getPrescripteur(): ?Prescripteur
    {
        return $this->prescripteur;
    }

    public function setPrescripteur(?Prescripteur $prescripteur): self
    {
        $this->prescripteur = $prescripteur;

        return $this;
    }

    public function getQpv(): ?QPV
    {
        return $this->qpv;
    }

    public function setQpv(?QPV $qpv): self
    {
        $this->qpv = $qpv;

        return $this;
    }

    public function getSituationFamiliale(): ?string
    {
        return $this->situationFamiliale;
    }

    public function setSituationFamiliale(string $situationFamiliale): self
    {
        $this->situationFamiliale = $situationFamiliale;

        return $this;
    }
}
