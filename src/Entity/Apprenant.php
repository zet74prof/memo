<?php

namespace App\Entity;

use App\Repository\ApprenantRepository;
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

    public function getEnfantACharge(): ?int
    {
        return $this->enfantACharge;
    }

    public function setEnfantACharge(?int $enfantACharge): self
    {
        $this->enfantACharge = $enfantACharge;

        return $this;
    }
}
