<?php

namespace App\Entity;

use App\Repository\SocialImpactHistoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SocialImpactHistoRepository::class)
 */
class SocialImpactHisto
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
    private $culture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cultureDetails;

    /**
     * @ORM\Column(type="boolean")
     */
    private $library;

    /**
     * @ORM\Column(type="boolean")
     */
    private $association;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $associationDetails;

    /**
     * @ORM\Column(type="boolean")
     */
    private $sport;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sportDetails;

    /**
     * @ORM\ManyToOne(targetEntity=CourseOfLife::class, inversedBy="socialImpactHistos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $courseOfLife;

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

    public function getCulture(): ?bool
    {
        return $this->culture;
    }

    public function setCulture(bool $culture): self
    {
        $this->culture = $culture;

        return $this;
    }

    public function getCultureDetails(): ?string
    {
        return $this->cultureDetails;
    }

    public function setCultureDetails(?string $cultureDetails): self
    {
        $this->cultureDetails = $cultureDetails;

        return $this;
    }

    public function getLibrary(): ?bool
    {
        return $this->library;
    }

    public function setLibrary(bool $library): self
    {
        $this->library = $library;

        return $this;
    }

    public function getAssociation(): ?bool
    {
        return $this->association;
    }

    public function setAssociation(bool $association): self
    {
        $this->association = $association;

        return $this;
    }

    public function getAssociationDetails(): ?string
    {
        return $this->associationDetails;
    }

    public function setAssociationDetails(?string $associationDetails): self
    {
        $this->associationDetails = $associationDetails;

        return $this;
    }

    public function getSport(): ?bool
    {
        return $this->sport;
    }

    public function setSport(bool $sport): self
    {
        $this->sport = $sport;

        return $this;
    }

    public function getSportDetails(): ?string
    {
        return $this->sportDetails;
    }

    public function setSportDetails(?string $sportDetails): self
    {
        $this->sportDetails = $sportDetails;

        return $this;
    }

    public function getCourseOfLife(): ?CourseOfLife
    {
        return $this->courseOfLife;
    }

    public function setCourseOfLife(?CourseOfLife $courseOfLife): self
    {
        $this->courseOfLife = $courseOfLife;

        return $this;
    }
}
