<?php

namespace App\Entity;

use App\Repository\NivFormHistoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NivFormHistoRepository::class)
 */
class NivFormHisto
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=NiveauFormation::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $niveauFormation;

    /**
     * @ORM\ManyToOne(targetEntity=Apprenant::class, inversedBy="niveauFormation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $apprenant;

    /**
     * @param $date
     * @param $niveauFormation
     */
    public function __construct($date, $niveauFormation)
    {
        $this->date = $date;
        $this->niveauFormation = $niveauFormation;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getNiveauFormation(): ?NiveauFormation
    {
        return $this->niveauFormation;
    }

    public function setNiveauFormation(?NiveauFormation $niveauFormation): self
    {
        $this->niveauFormation = $niveauFormation;

        return $this;
    }

    public function getApprenant(): ?Apprenant
    {
        return $this->apprenant;
    }

    public function setApprenant(?Apprenant $apprenant): self
    {
        $this->apprenant = $apprenant;

        return $this;
    }
}
