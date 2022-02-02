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
     * @ORM\OneToMany(targetEntity=NivFormHisto::class, mappedBy="apprenant", orphanRemoval=true, fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)
     */
    private $niveauFormationHistos;

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
     * @ORM\Column(type="integer")
     */
    private $situationFamiliale;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbEnfant;

    public function __construct()
    {
        parent::__construct();
        $this->niveauFormationHistos = new ArrayCollection();
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
    public function getNiveauFormationHistos(): Collection
    {
        return $this->niveauFormationHistos;
    }

    public function addNiveauFormation(NivFormHisto $niveauFormation): self
    {
        if (!$this->niveauFormationHistos->contains($niveauFormation)) {
            $this->niveauFormationHistos[] = $niveauFormation;
            $niveauFormation->setApprenant($this);
        }

        return $this;
    }

    public function removeNiveauFormation(NivFormHisto $niveauFormation): self
    {
        if ($this->niveauFormationHistos->removeElement($niveauFormation)) {
            // set the owning side to null (unless already changed)
            if ($niveauFormation->getApprenant() === $this) {
                $niveauFormation->setApprenant(null);
            }
        }

        return $this;
    }

    /**
     * @return NiveauFormation
     */
    public function getLastNiveauFormation(): NiveauFormation
    {
        $lastNivFormHisto = $this->getNiveauFormationHistos()->last();
        return $lastNivFormHisto->getNiveauFormation();
    }

    /**
     * @param NiveauFormation $niveauFormation
     * @return NivFormHisto|null
     * Get a NiveauFormation, checks if the niveau de formation has changed and returns a NivFormHisto object to persist
     */
    public function setNiveauFormationWithHisto(NiveauFormation $niveauFormation): ?NivFormHisto
    {
        if ($this->getLastNiveauFormation() != $niveauFormation)
        {
            $nivFormHisto = new NivFormHisto(new \DateTime('now'),$niveauFormation);
            $nivFormHisto->setApprenant($this);
            return $nivFormHisto;
        }
        else
        {
            return null;
        }
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

    public function getSituationFamiliale(): ?string
    {
        return $this->situationFamiliale;
    }

    public function setSituationFamiliale(string $situationFamiliale): self
    {
        $this->situationFamiliale = $situationFamiliale;

        return $this;
    }

    public function getNbEnfant(): ?int
    {
        return $this->nbEnfant;
    }

    public function setNbEnfant(?int $nbEnfant): self
    {
        $this->nbEnfant = $nbEnfant;

        return $this;
    }
}
