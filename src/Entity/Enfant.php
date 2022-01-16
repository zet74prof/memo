<?php

namespace App\Entity;

use App\Repository\EnfantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnfantRepository::class)
 */
class Enfant extends User
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeReferent;

    /**
     * @ORM\ManyToOne(targetEntity=EtablissementScolaire::class, inversedBy="enfants")
     */
    private $etablissementScolaire;

    public function getTypeReferent(): ?string
    {
        return $this->typeReferent;
    }

    public function setTypeReferent(string $typeReferent): self
    {
        $this->typeReferent = $typeReferent;

        return $this;
    }

    public function getEtablissementScolaire(): ?EtablissementScolaire
    {
        return $this->etablissementScolaire;
    }

    public function setEtablissementScolaire(?EtablissementScolaire $etablissementScolaire): self
    {
        $this->etablissementScolaire = $etablissementScolaire;

        return $this;
    }
}
