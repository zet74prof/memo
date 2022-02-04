<?php

namespace App\Entity;

use App\Repository\RessourceHistoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RessourceHistoRepository::class)
 */
class RessourceHisto
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
     * @ORM\ManyToOne(targetEntity=Ressource::class, inversedBy="ressourceHistos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ressource;

    /**
     * @ORM\ManyToOne(targetEntity=Apprenant::class, inversedBy="ressourceHistos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $apprenant;

    /**
     * @param $date
     * @param $ressource
     */
    public function __construct($date, $ressource)
    {
        $this->date = $date;
        $this->ressource = $ressource;
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

    public function getRessource(): ?Ressource
    {
        return $this->ressource;
    }

    public function setRessource(?Ressource $ressource): self
    {
        $this->ressource = $ressource;

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
