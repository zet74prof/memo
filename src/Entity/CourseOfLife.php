<?php

namespace App\Entity;

use App\Repository\CourseOfLifeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CourseOfLifeRepository::class)
 */
class CourseOfLife
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastFrequentedClass;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $foreignScholarship;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $foreignScholarshipDetails;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $spokenLanguages;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $alphabetLevel;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $diplomaCertif;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $diplomaCertifDetails;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastJob;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastJobArea;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $gotCV;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $alreadyLanguageCourse;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $hearingAssess;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $hearingAssessDetails;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $viewAssess;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $viewAssessDetails;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $healthAssess;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $healthAssesDetails;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $healthOtherDetails;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $centerOfInterestDetails;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $drivingLicense;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $vehicule;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vehiculeDetails;

    /**
     * @ORM\OneToOne(targetEntity=Apprenant::class, mappedBy="courseOfLife", cascade={"persist", "remove"})
     */
    private $apprenant;

    /**
     * @ORM\ManyToMany(targetEntity=CenterOfInterest::class)
     */
    private $centerOfInterest;

    /**
     * @ORM\OneToMany(targetEntity=SocialImpactHisto::class, mappedBy="courseOfLife")
     */
    private $socialImpactHistos;

    public function __construct()
    {
        $this->centerOfInterest = new ArrayCollection();
        $this->socialImpactHistos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastFrequentedClass(): ?string
    {
        return $this->lastFrequentedClass;
    }

    public function setLastFrequentedClass(?string $lastFrequentedClass): self
    {
        $this->lastFrequentedClass = $lastFrequentedClass;

        return $this;
    }

    public function getForeignScholarship(): ?bool
    {
        return $this->foreignScholarship;
    }

    public function setForeignScholarship(?bool $foreignScholarship): self
    {
        $this->foreignScholarship = $foreignScholarship;

        return $this;
    }

    public function getForeignScholarshipDetails(): ?string
    {
        return $this->foreignScholarshipDetails;
    }

    public function setForeignScholarshipDetails(?string $foreignScholarshipDetails): self
    {
        $this->foreignScholarshipDetails = $foreignScholarshipDetails;

        return $this;
    }

    public function getSpokenLanguages(): ?string
    {
        return $this->spokenLanguages;
    }

    public function setSpokenLanguages(?string $spokenLanguages): self
    {
        $this->spokenLanguages = $spokenLanguages;

        return $this;
    }

    public function getAlphabetLevel(): ?string
    {
        return $this->alphabetLevel;
    }

    public function setAlphabetLevel(?string $alphabetLevel): self
    {
        $this->alphabetLevel = $alphabetLevel;

        return $this;
    }

    public function getDiplomaCertif(): ?bool
    {
        return $this->diplomaCertif;
    }

    public function setDiplomaCertif(?bool $diplomaCertif): self
    {
        $this->diplomaCertif = $diplomaCertif;

        return $this;
    }

    public function getDiplomaCertifDetails(): ?string
    {
        return $this->diplomaCertifDetails;
    }

    public function setDiplomaCertifDetails(?string $diplomaCertifDetails): self
    {
        $this->diplomaCertifDetails = $diplomaCertifDetails;

        return $this;
    }

    public function getLastJob(): ?string
    {
        return $this->lastJob;
    }

    public function setLastJob(?string $lastJob): self
    {
        $this->lastJob = $lastJob;

        return $this;
    }

    public function getLastJobArea(): ?string
    {
        return $this->lastJobArea;
    }

    public function setLastJobArea(?string $lastJobArea): self
    {
        $this->lastJobArea = $lastJobArea;

        return $this;
    }

    public function getGotCV(): ?bool
    {
        return $this->gotCV;
    }

    public function setGotCV(?bool $gotCV): self
    {
        $this->gotCV = $gotCV;

        return $this;
    }

    public function getAlreadyLanguageCourse(): ?bool
    {
        return $this->alreadyLanguageCourse;
    }

    public function setAlreadyLanguageCourse(?bool $alreadyLanguageCourse): self
    {
        $this->alreadyLanguageCourse = $alreadyLanguageCourse;

        return $this;
    }

    public function getHearingAssess(): ?bool
    {
        return $this->hearingAssess;
    }

    public function setHearingAssess(?bool $hearingAssess): self
    {
        $this->hearingAssess = $hearingAssess;

        return $this;
    }

    public function getHearingAssessDetails(): ?string
    {
        return $this->hearingAssessDetails;
    }

    public function setHearingAssessDetails(?string $hearingAssessDetails): self
    {
        $this->hearingAssessDetails = $hearingAssessDetails;

        return $this;
    }

    public function getViewAssess(): ?bool
    {
        return $this->viewAssess;
    }

    public function setViewAssess(?bool $viewAssess): self
    {
        $this->viewAssess = $viewAssess;

        return $this;
    }

    public function getViewAssessDetails(): ?string
    {
        return $this->viewAssessDetails;
    }

    public function setViewAssessDetails(?string $viewAssessDetails): self
    {
        $this->viewAssessDetails = $viewAssessDetails;

        return $this;
    }

    public function getHealthAssess(): ?bool
    {
        return $this->healthAssess;
    }

    public function setHealthAssess(?bool $healthAssess): self
    {
        $this->healthAssess = $healthAssess;

        return $this;
    }

    public function getHealthAssesDetails(): ?string
    {
        return $this->healthAssesDetails;
    }

    public function setHealthAssesDetails(?string $healthAssesDetails): self
    {
        $this->healthAssesDetails = $healthAssesDetails;

        return $this;
    }

    public function getHealthOtherDetails(): ?string
    {
        return $this->healthOtherDetails;
    }

    public function setHealthOtherDetails(?string $healthOtherDetails): self
    {
        $this->healthOtherDetails = $healthOtherDetails;

        return $this;
    }

    public function getCenterOfInterestDetails(): ?string
    {
        return $this->centerOfInterestDetails;
    }

    public function setCenterOfInterestDetails(?string $centerOfInterestDetails): self
    {
        $this->centerOfInterestDetails = $centerOfInterestDetails;

        return $this;
    }

    public function getDrivingLicense(): ?bool
    {
        return $this->drivingLicense;
    }

    public function setDrivingLicense(?bool $drivingLicense): self
    {
        $this->drivingLicense = $drivingLicense;

        return $this;
    }

    public function getVehicule(): ?bool
    {
        return $this->vehicule;
    }

    public function setVehicule(?bool $vehicule): self
    {
        $this->vehicule = $vehicule;

        return $this;
    }

    public function getVehiculeDetails(): ?string
    {
        return $this->vehiculeDetails;
    }

    public function setVehiculeDetails(?string $vehiculeDetails): self
    {
        $this->vehiculeDetails = $vehiculeDetails;

        return $this;
    }

    public function getApprenant(): ?Apprenant
    {
        return $this->apprenant;
    }

    public function setApprenant(?Apprenant $apprenant): self
    {
        // unset the owning side of the relation if necessary
        if ($apprenant === null && $this->apprenant !== null) {
            $this->apprenant->setCourseOfLife(null);
        }

        // set the owning side of the relation if necessary
        if ($apprenant !== null && $apprenant->getCourseOfLife() !== $this) {
            $apprenant->setCourseOfLife($this);
        }

        $this->apprenant = $apprenant;

        return $this;
    }

    /**
     * @return Collection|CenterOfInterest[]
     */
    public function getCenterOfInterest(): Collection
    {
        return $this->centerOfInterest;
    }

    public function addCenterOfInterest(CenterOfInterest $centerOfInterest): self
    {
        if (!$this->centerOfInterest->contains($centerOfInterest)) {
            $this->centerOfInterest[] = $centerOfInterest;
        }

        return $this;
    }

    public function removeCenterOfInterest(CenterOfInterest $centerOfInterest): self
    {
        $this->centerOfInterest->removeElement($centerOfInterest);

        return $this;
    }

    /**
     * @return Collection|SocialImpactHisto[]
     */
    public function getSocialImpactHistos(): Collection
    {
        return $this->socialImpactHistos;
    }

    public function addSocialImpactHisto(SocialImpactHisto $socialImpactHisto): self
    {
        if (!$this->socialImpactHistos->contains($socialImpactHisto)) {
            $this->socialImpactHistos[] = $socialImpactHisto;
            $socialImpactHisto->setCourseOfLife($this);
        }

        return $this;
    }

    public function removeSocialImpactHisto(SocialImpactHisto $socialImpactHisto): self
    {
        if ($this->socialImpactHistos->removeElement($socialImpactHisto)) {
            // set the owning side to null (unless already changed)
            if ($socialImpactHisto->getCourseOfLife() === $this) {
                $socialImpactHisto->setCourseOfLife(null);
            }
        }

        return $this;
    }
}
