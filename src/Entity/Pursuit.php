<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Pursuit
 *
 * @ORM\Table(name="pursuits", indexes={@ORM\Index(name="IDX_1602BBD5172FCCFB", columns={"states_nb_state"}), @ORM\Index(name="IDX_1602BBD52CBE1004", columns={"locations_nb_location"}), @ORM\Index(name="IDX_1602BBD599D47173", columns={"organizer"}), @ORM\Index(name="IDX_1602BBD5ED5DE765", columns={"sites_nb_site"})})
 * @ORM\Entity(repositoryClass="App\Repository\PursuitRepository")
 */
class Pursuit
{
    /**
     * @var int
     *
     * @ORM\Column(name="nb_pursuit", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $nbPursuit;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=30, nullable=false)
     */
    private $name;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date_start", type="datetime", nullable=false)
     */
    private $dateStart;

    /**
     * @var int|null
     *
     * @ORM\Column(name="duration", type="integer", nullable=true)
     */
    private $duration;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date_end", type="datetime", nullable=false)
     */
    private $dateEnd;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_max_registrations", type="integer", nullable=false)
     */
    private $nbMaxRegistrations;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=500, nullable=true)
     */
    private $description;

    /**
     * @var int|null
     *
     * @ORM\Column(name="state_pursuit", type="integer", nullable=true)
     */
    private $statePursuit;

    /**
     * @var string|null
     *
     * @ORM\Column(name="urlpicture", type="string", length=250, nullable=true)
     */
    private $urlPicture;

    /**
     * @var State
     *
     * @ORM\ManyToOne(targetEntity="State", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="states_nb_state", referencedColumnName="nb_state", nullable=false)
     * })
     */
    private $state;

    /**
     * @var Location
     *
     * @ORM\ManyToOne(targetEntity="Location", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="locations_nb_location", referencedColumnName="nb_location", nullable=false)
     * })
     */
    private $location;

    /**
     * @var Participant
     *
     * @ORM\ManyToOne(targetEntity="Participant", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="organizer", referencedColumnName="nb_participant", nullable=false)
     * })
     */
    private $organizer;

    /**
     * @var Site
     *
     * @ORM\ManyToOne(targetEntity="Site", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sites_nb_site", referencedColumnName="nb_site", nullable=false)
     * })
     */
    private $site;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Registration", mappedBy="pursuit")
     */
    private $registrations;

    /**
     * Pursuit constructor.
     * @param string $name
     * @param DateTime $dateStart
     * @param int|null $duration
     * @param DateTime $dateEnd
     * @param int $nbMaxRegistrations
     * @param string|null $description
     * @param int|null $statePursuit
     * @param string|null $urlPicture
     * @param State $state
     * @param Location $location
     * @param Participant $organizer
     * @param Site $site
     */
    public function __construct(string $name,
                                DateTime $dateStart,
                                ?int $duration,
                                DateTime $dateEnd,
                                int $nbMaxRegistrations,
                                ?string $description,
                                ?int $statePursuit,
                                ?string $urlPicture,
                                State $state,
                                Location $location,
                                Participant $organizer,
                                Site $site)
    {
        $this->name = $name;
        $this->dateStart = $dateStart;
        $this->duration = $duration;
        $this->dateEnd = $dateEnd;
        $this->nbMaxRegistrations = $nbMaxRegistrations;
        $this->description = $description;
        $this->statePursuit = $statePursuit;
        $this->urlPicture = $urlPicture;
        $this->state = $state;
        $this->location = $location;
        $this->organizer = $organizer;
        $this->site = $site;
        $this->registrations = new ArrayCollection();
    }


    public function getNbPursuit(): ?int
    {
        return $this->nbPursuit;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDateStart(): ?DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(DateTimeInterface $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDateEnd(): ?DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getNbMaxRegistrations(): ?int
    {
        return $this->nbMaxRegistrations;
    }

    public function setNbMaxRegistrations(int $nbMaxRegistrations): self
    {
        $this->nbMaxRegistrations = $nbMaxRegistrations;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStatePursuit(): ?int
    {
        return $this->statePursuit;
    }

    public function setStatePursuit(?int $statePursuit): self
    {
        $this->statePursuit = $statePursuit;

        return $this;
    }

    public function getUrlPicture(): ?string
    {
        return $this->urlPicture;
    }

    public function setUrlPicture(?string $urlPicture): self
    {
        $this->urlPicture = $urlPicture;

        return $this;
    }

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getOrganizer(): ?Participant
    {
        return $this->organizer;
    }

    public function setOrganizer(?Participant $organizer): self
    {
        $this->organizer = $organizer;

        return $this;
    }

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): self
    {
        $this->site = $site;

        return $this;
    }

    /**
     * @return Collection|Registration[]
     */
    public function getRegistrations(): Collection
    {
        return $this->registrations;
    }

    public function addRegistration(Registration $registration): self
    {
        if (!$this->registrations->contains($registration)) {
            $this->registrations[] = $registration;
            $registration->setPursuit($this);
        }

        return $this;
    }

    public function removeRegistration(Registration $registration): self
    {
        if ($this->registrations->contains($registration)) {
            $this->registrations->removeElement($registration);
            // set the owning side to null (unless already changed)
            if ($registration->getPursuit() === $this) {
                $registration->setPursuit(null);
            }
        }

        return $this;
    }
}
