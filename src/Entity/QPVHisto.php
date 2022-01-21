<?php

namespace App\Entity;

use App\Repository\QPVHistoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QPVHistoRepository::class)
 */
class QPVHisto
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
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="qPVHistos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=QPV::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $qpv;

    /**
     * @param $date
     * @param $qpv
     */
    public function __construct($date, $qpv)
    {
        $this->date = $date;
        $this->qpv = $qpv;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
}
