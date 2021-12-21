<?php

namespace App\Entity;

use App\Repository\StateHistoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StateHistoRepository::class)
 */
class StateHisto
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
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reason;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="stateHisto")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @param $date
     * @param $active
     * @param $reason
     */
    public function __construct($date, $active, $reason)
    {
        $this->date = $date;
        $this->active = $active;
        $this->reason = $reason;
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

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(?string $reason): self
    {
        $this->reason = $reason;

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
