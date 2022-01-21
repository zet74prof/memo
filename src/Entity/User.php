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
     * @ORM\OneToMany(targetEntity=StateHisto::class, mappedBy="user", orphanRemoval=true, fetch="EAGER")
     */
    protected $stateHisto;

    /**
     * @ORM\OneToMany(targetEntity=SiteHisto::class, mappedBy="user", orphanRemoval=true, fetch="EAGER")
     */
    protected $siteHisto;

    /**
     * @ORM\OneToMany(targetEntity=StatusHisto::class, mappedBy="user", orphanRemoval=true, fetch="EAGER")
     */
    private $statusHistos;

    /**
     * @ORM\OneToMany(targetEntity=QPVHisto::class, mappedBy="user", orphanRemoval=true, fetch="EAGER")
     */
    private $qPVHistos;

    public function __construct()
    {
        $this->stateHisto = new ArrayCollection();
        $this->siteHisto = new ArrayCollection();
        $this->statusHistos = new ArrayCollection();
        $this->qPVHistos = new ArrayCollection();
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
     * To build username automatically from firstname.surname given in the creation form
     * Pre-requiste: username set to firstname.lastname from a form
     * Objective of this function: replace spaces by dashes, accented characters by non-accented, and set to lower case
     */
    public function CleanUserName()
    {
        $unwanted_charaters = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );

        $userName = str_replace(' ','-',$this->getUserIdentifier());
        $userName = strtr( $userName, $unwanted_charaters );
        $userName = strtolower($userName);
        $this->setUsername($userName);
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
     * @return int
     */
    public function getLastState(): int
    {
        $lastSateHisto = $this->getStateHisto()->last();
        return $lastSateHisto->getState();
    }

    /**
     * @param int $state
     * @param string $reason
     * @return StateHisto|null
     * Get a state and a reason, checks ifthe state has changed and returns a stateHisto object to persist
     */
    public function setStateWithHisto(int $state, ?string $reason): ?StateHisto
    {
        if ($reason == null)
        {
            $reason = '';
        }
        if ($this->getLastState() != $state)
        {
            $stateHisto = new StateHisto(new \DateTime('now'),$state,$reason);
            $stateHisto->setUser($this);
            return $stateHisto;
        }
        else
        {
            return null;
        }
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

    /**
     * @param Collection $sitesList
     * @return SiteHisto|null
     * Get a site list, check if the site list has changed, and if so, returns a new SiteHisto object to persist
     */
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

    /**
     * @return Collection|StatusHisto[]
     */
    public function getStatusHistos(): Collection
    {
        return $this->statusHistos;
    }

    public function addStatusHisto(StatusHisto $statusHisto): self
    {
        if (!$this->statusHistos->contains($statusHisto)) {
            $this->statusHistos[] = $statusHisto;
            $statusHisto->setUser($this);
        }

        return $this;
    }

    public function removeStatusHisto(StatusHisto $statusHisto): self
    {
        if ($this->statusHistos->removeElement($statusHisto)) {
            // set the owning side to null (unless already changed)
            if ($statusHisto->getUser() === $this) {
                $statusHisto->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Status
     */
    public function getLastStatus(): Status
    {
        $lastSatusHisto = $this->getStatusHistos()->last();
        return $lastSatusHisto->getStatus();
    }

    /**
     * @param Status $status
     * @return StatusHisto|null
     * Get a status, checks if the status has changed and returns a statusHisto object to persist
     */
    public function setStatusWithHisto(Status $status): ?StatusHisto
    {
        if ($this->getLastStatus() != $status)
        {
            $statusHisto = new StatusHisto(new \DateTime('now'),$status);
            $statusHisto->setUser($this);
            return $statusHisto;
        }
        else
        {
            return null;
        }
    }

    /**
     * @return Collection|QPVHisto[]
     */
    public function getQPVHistos(): Collection
    {
        return $this->qPVHistos;
    }

    public function addQPVHisto(QPVHisto $qPVHisto): self
    {
        if (!$this->qPVHistos->contains($qPVHisto)) {
            $this->qPVHistos[] = $qPVHisto;
            $qPVHisto->setUser($this);
        }

        return $this;
    }

    public function removeQPVHisto(QPVHisto $qPVHisto): self
    {
        if ($this->qPVHistos->removeElement($qPVHisto)) {
            // set the owning side to null (unless already changed)
            if ($qPVHisto->getUser() === $this) {
                $qPVHisto->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return QPV
     */
    public function getLastQPV(): QPV
    {
        $lastQPVHisto = $this->getQPVHistos()->last();
        return $lastQPVHisto->getQpv();
    }

    /**
     * @param QPV $qpv
     * @return QPVHisto|null
     * Get a QPV, checks if the QPV has changed and returns a QPVHisto object to persist
     */
    public function setQPVWithHisto(QPV $qpv): ?QPVHisto
    {
        if ($this->getLastQPV() != $qpv)
        {
            $qpvHisto = new QPVHisto(new \DateTime('now'),$qpv);
            $qpvHisto->setUser($this);
            return $qpvHisto;
        }
        else
        {
            return null;
        }
    }
}
