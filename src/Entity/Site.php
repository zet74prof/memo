<?php

namespace App\Entity;

use App\Repository\SiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SiteRepository::class)
 */
class Site
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
    private $siteName;

    /**
     * @ORM\ManyToOne(targetEntity=Territoire::class, inversedBy="site")
     */
    private $territoire;

    /**
     * @ORM\ManyToMany(targetEntity=SiteHisto::class, mappedBy="sites")
     */
    private $siteHistos;

    public function __construct()
    {
        $this->siteHistos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSiteName(): ?string
    {
        return $this->siteName;
    }

    public function setSiteName(string $siteName): self
    {
        $this->siteName = $siteName;

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

    /**
     * @return Collection|SiteHisto[]
     */
    public function getSiteHistos(): Collection
    {
        return $this->siteHistos;
    }

    public function addSiteHisto(SiteHisto $siteHisto): self
    {
        if (!$this->siteHistos->contains($siteHisto)) {
            $this->siteHistos[] = $siteHisto;
            $siteHisto->addSite($this);
        }

        return $this;
    }

    public function removeSiteHisto(SiteHisto $siteHisto): self
    {
        if ($this->siteHistos->removeElement($siteHisto)) {
            $siteHisto->removeSite($this);
        }

        return $this;
    }
}
