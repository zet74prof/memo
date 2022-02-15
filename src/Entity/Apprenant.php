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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbEnfant;

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
     * @ORM\ManyToOne(targetEntity=SituationFamiliale::class, inversedBy="apprenants")
     * @ORM\JoinColumn(nullable=true)
     */
    private $situationFamiliale;

    /**
     * @ORM\OneToMany(targetEntity=RessourceHisto::class, mappedBy="apprenant", orphanRemoval=true, fetch="EAGER")
     */
    private $ressourceHistos;

    /**
     * @ORM\OneToMany(targetEntity=PrescripteurHisto::class, mappedBy="apprenant", orphanRemoval=true, fetch="EAGER")
     */
    private $prescripteurHistos;

    public function __construct()
    {
        parent::__construct();
        $this->niveauFormationHistos = new ArrayCollection();
        $this->ressourceHistos = new ArrayCollection();
        $this->prescripteurHistos = new ArrayCollection();
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

    public function getSituationFamiliale(): ?SituationFamiliale
    {
        return $this->situationFamiliale;
    }

    public function setSituationFamiliale(?SituationFamiliale $situationFamiliale): self
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
            $ressourceHisto->setApprenant($this);
        }

        return $this;
    }

    public function removeRessourceHisto(RessourceHisto $ressourceHisto): self
    {
        if ($this->ressourceHistos->removeElement($ressourceHisto)) {
            // set the owning side to null (unless already changed)
            if ($ressourceHisto->getApprenant() === $this) {
                $ressourceHisto->setApprenant(null);
            }
        }

        return $this;
    }

    /**
     * @return Ressource
     */
    public function getLastRessource(): Ressource
    {
        $lastRessourceHisto = $this->getRessourceHistos()->last();
        return $lastRessourceHisto->getRessource();
    }

    /**
     * @param Ressource $ressource
     * @return RessourceHisto|null
     * Get a Ressource, checks if the ressource has changed and returns a RessourceHisto object to persist
     */
    public function setRessourceWithHisto(Ressource $ressource): ?RessourceHisto
    {
        if ($this->getLastRessource() != $ressource)
        {
            $ressourceHisto = new RessourceHisto(new \DateTime('now'), $ressource);
            $ressourceHisto->setApprenant($this);
            return $ressourceHisto;
        }
        else
        {
            return null;
        }
    }

    /**
     * @return Collection|PrescripteurHisto[]
     */
    public function getPrescripteurHistos(): Collection
    {
        return $this->prescripteurHistos;
    }

    public function addPrescripteurHisto(PrescripteurHisto $prescripteurHisto): self
    {
        if (!$this->prescripteurHistos->contains($prescripteurHisto)) {
            $this->prescripteurHistos[] = $prescripteurHisto;
            $prescripteurHisto->setApprenant($this);
        }

        return $this;
    }

    public function removePrescripteurHisto(PrescripteurHisto $prescripteurHisto): self
    {
        if ($this->prescripteurHistos->removeElement($prescripteurHisto)) {
            // set the owning side to null (unless already changed)
            if ($prescripteurHisto->getApprenant() === $this) {
                $prescripteurHisto->setApprenant(null);
            }
        }

        return $this;
    }

    /**
     * @return Prescripteur
     */
    public function getLastPrescripteur(): Prescripteur
    {
        $lastPrescripteurHisto = $this->getPrescripteurHistos()->last();
        return $lastPrescripteurHisto->getPrescripteur();
    }

    /**
     * @param Prescripteur $prescripteur
     * @return PrescripteurHisto|null
     * Get a Prescripteur, checks if the prescripteur has changed and returns a PrescripteurHisto object to persist
     */
    public function setPrescripteurWithHisto(Prescripteur $prescripteur): ?PrescripteurHisto
    {
        if ($this->getLastPrescripteur() != $prescripteur)
        {
            $prescripteurHisto = new PrescripteurHisto(new \DateTime('now'), $prescripteur);
            $prescripteurHisto->setApprenant($this);
            return $prescripteurHisto;
        }
        else
        {
            return null;
        }
    }
}
