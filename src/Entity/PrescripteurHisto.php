<?php

namespace App\Entity;

use App\Repository\PrescripteurHistoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PrescripteurHistoRepository::class)
 */
class PrescripteurHisto
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
     * @ORM\ManyToOne(targetEntity=Prescripteur::class, inversedBy="prescripteurHistos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $prescripteur;

    /**
     * @ORM\ManyToOne(targetEntity=Apprenant::class, inversedBy="prescripteurHistos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $apprenant;

    /**
     * @param $date
     * @param $prescripteur
     */
    public function __construct($date, $prescripteur)
    {
        $this->date = $date;
        $this->prescripteur = $prescripteur;
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

    public function getPrescripteur(): ?Prescripteur
    {
        return $this->prescripteur;
    }

    public function setPrescripteur(?Prescripteur $prescripteur): self
    {
        $this->prescripteur = $prescripteur;

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
