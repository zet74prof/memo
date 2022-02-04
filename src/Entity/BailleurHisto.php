<?php

namespace App\Entity;

use App\Repository\BailleurHistoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BailleurHistoRepository::class)
 */
class BailleurHisto
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
     * @ORM\ManyToOne(targetEntity=Bailleur::class, inversedBy="bailleurHistos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bailleur;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bailleurHistos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @param $date
     * @param $bailleur
     */
    public function __construct($date, $bailleur)
    {
        $this->date = $date;
        $this->bailleur = $bailleur;
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

    public function getBailleur(): ?Bailleur
    {
        return $this->bailleur;
    }

    public function setBailleur(?Bailleur $bailleur): self
    {
        $this->bailleur = $bailleur;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
