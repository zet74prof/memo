<?php

namespace App\Entity;

use App\Repository\EnfantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnfantRepository::class)
 */
class Enfant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeReferent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeReferent(): ?string
    {
        return $this->typeReferent;
    }

    public function setTypeReferent(string $typeReferent): self
    {
        $this->typeReferent = $typeReferent;

        return $this;
    }
}
