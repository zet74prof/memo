<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\InheritanceType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"user" = "User", "apprenant" = "Apprenant", "benevole" = "Benevole", "enfant" = "Enfant"})
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    protected $username;

    /**
     * @ORM\Column(type="json")
     */
    protected $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $surname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $postalCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $city;

    /**
     * @ORM\Column(type="date")
     */
    protected $birthDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $tel1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $tel2;

    /**
     * @ORM\Column(type="string", length=3000, nullable=true)
     */
    protected $comment;

    /**
     * @ORM\Column(type="string", length=360, nullable=true)
     */
    protected $email;

    /**
     * @ORM\OneToMany(targetEntity=StateHisto::class, mappedBy="user", orphanRemoval=true)
     */
    protected $stateHisto;

    /**
     * @ORM\OneToMany(targetEntity=SiteHisto::class, mappedBy="user", orphanRemoval=true, fetch="EAGER")
     */
    protected $siteHisto;

    public function __construct()
    {
        $this->stateHisto = new ArrayCollection();
        $this->siteHisto = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getTel1(): ?string
    {
        return $this->tel1;
    }

    public function setTel1(string $tel1): self
    {
        $this->tel1 = $tel1;

        return $this;
    }

    public function getTel2(): ?string
    {
        return $this->tel2;
    }

    public function setTel2(?string $tel2): self
    {
        $this->tel2 = $tel2;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

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

    /**
     * @return Collection|StateHisto[]
     */
    public function getStateHisto(): Collection
    {
        return $this->stateHisto;
    }

    public function addStateHisto(StateHisto $stateHisto): self
    {
        if (!$this->stateHisto->contains($stateHisto)) {
            $this->stateHisto[] = $stateHisto;
            $stateHisto->setUser($this);
        }

        return $this;
    }

    public function removeStateHisto(StateHisto $stateHisto): self
    {
        if ($this->stateHisto->removeElement($stateHisto)) {
            // set the owning side to null (unless already changed)
            if ($stateHisto->getUser() === $this) {
                $stateHisto->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SiteHisto[]
     */
    public function getSiteHisto(): Collection
    {
        return $this->siteHisto;
    }

    public function addSite(SiteHisto $site): self
    {
        if (!$this->siteHisto->contains($site)) {
            $this->siteHisto[] = $site;
            $site->setUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Site[]
     */
    public function getLastSites(): Collection
    {
        $lastSiteHisto = $this->getSiteHisto()->last();
        return $lastSiteHisto->getSites();
    }

    public function removeSite(SiteHisto $site): self
    {
        if ($this->siteHisto->removeElement($site)) {
            // set the owning side to null (unless already changed)
            if ($site->getUser() === $this) {
                $site->setUser(null);
            }
        }

        return $this;
    }

    public function setSitesWithHisto(Collection $sitesList): ?SiteHisto
    {
        $modify = false;
        if ($this->getSiteHisto()->last())
        {
            //here we need to check if the list of site has changed or not.
            //for array_udiff to work, the largest list must be put first.
            // So we need to count nb of entries per array to decide which list goes first.
            $nbSitesInNewList = $sitesList->count();
            $nbSitesInCurrentList = $this->getLastSites()->count();
            if ($nbSitesInNewList < $nbSitesInCurrentList)
            {
                $list1 = $this->getLastSites()->toArray();
                $list2 = $sitesList->toArray();
            }
            else
            {
                $list1 = $sitesList->toArray();
                $list2 = $this->getLastSites()->toArray();
            }
            $diff = array_udiff($list1, $list2,
                function ($site_a, $site_b) {
                    return $site_a->getId() - $site_b->getId();
                }
            );
            if($diff != [])
            {
                $modify = true;
            }
        }
        else //it's a new user with no sites yet
        {
            $modify = true;
        }

        if ($modify == true)
        {
            $siteHisto = new SiteHisto();
            $siteHisto->setUser($this);
            //on récupère la liste des sites (un tableau d'objets de la classe Site) pour l'ajouter à l'objet SiteHisto
            //et on vient persister cet objet SiteHisto ce qui permet de conserver l'historique des modifs
            foreach ($sitesList as $site)
            {
                $siteHisto->addSite($site);
            }
            $siteHisto->setDate(new \DateTime('now'));
            return $siteHisto;
        }
        else
        {
            return null;
        }
    }
}
