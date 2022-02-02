<?php

namespace App\Entity;

use App\Repository\PrescripteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PrescripteurRepository::class)
 */
class Prescripteur
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
    private $prescripteurName;

    /**
     * @ORM\OneToMany(targetEntity=Apprenant::class, mappedBy="prescripteur")
     */
    private $apprenants;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $respName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $postalCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=320, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tel;

    /**
     * @ORM\ManyToOne(targetEntity=TypePrescripteur::class, inversedBy="prescripteurs")
     * @ORM\JoinColumn(nullable=true)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Territoire::class, inversedBy="prescripteurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $territoire;

    public function __construct()
    {
        $this->apprenants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrescripteurName(): ?string
    {
        return $this->prescripteurName;
    }

    public function setPrescripteurName(string $prescripteurName): self
    {
        $this->prescripteurName = $prescripteurName;

        return $this;
    }

    /**
     * @return Collection|Apprenant[]
     */
    public function getApprenants(): Collection
    {
        return $this->apprenants;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenants->contains($apprenant)) {
            $this->apprenants[] = $apprenant;
            $apprenant->setPrescripteur($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenants->removeElement($apprenant)) {
            // set the owning side to null (unless already changed)
            if ($apprenant->getPrescripteur() === $this) {
                $apprenant->setPrescripteur(null);
            }
        }

        return $this;
    }

    public function getRespName(): ?string
    {
        return $this->respName;
    }

    public function setRespName(?string $respName): self
    {
        $this->respName = $respName;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getType(): ?TypePrescripteur
    {
        return $this->type;
    }

    public function setType(?TypePrescripteur $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTerritoire(): ?Territoire
    {
        return $this->territoire;
    }

    public function setTerritoire(?Territoire $territoire): self
    {
        $this->territoire = $territoire;

        return $this;
    }
}
