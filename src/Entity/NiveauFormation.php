<?php

namespace App\Entity;

use App\Repository\NiveauFormationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NiveauFormationRepository::class)
 */
class NiveauFormation
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
    private $nivFormName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNivFormName(): ?string
    {
        return $this->nivFormName;
    }

    public function setNivFormName(string $nivFormName): self
    {
        $this->nivFormName = $nivFormName;

        return $this;
    }
}
