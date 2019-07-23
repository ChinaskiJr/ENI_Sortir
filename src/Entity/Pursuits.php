<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Pursuits
 *
 * @ORM\Table(name="pursuits", indexes={@ORM\Index(name="IDX_1602BBD5172FCCFB", columns={"states_nb_state"}), @ORM\Index(name="IDX_1602BBD52CBE1004", columns={"locations_nb_location"}), @ORM\Index(name="IDX_1602BBD599D47173", columns={"organizer"}), @ORM\Index(name="IDX_1602BBD5ED5DE765", columns={"sites_nb_site"})})
 * @ORM\Entity
 */
class Pursuits
{
    /**
     * @var int
     *
     * @ORM\Column(name="nb_pursuit", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="pursuits_nb_pursuit_seq", allocationSize=1, initialValue=1)
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
    private $urlpicture;

    /**
     * @var States
     *
     * @ORM\ManyToOne(targetEntity="States")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="states_nb_state", referencedColumnName="nb_state")
     * })
     */
    private $statesNbState;

    /**
     * @var Locations
     *
     * @ORM\ManyToOne(targetEntity="Locations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="locations_nb_location", referencedColumnName="nb_location")
     * })
     */
    private $locationsNbLocation;

    /**
     * @var Participants
     *
     * @ORM\ManyToOne(targetEntity="Participants")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="organizer", referencedColumnName="nb_participant")
     * })
     */
    private $organizer;

    /**
     * @var Sites
     *
     * @ORM\ManyToOne(targetEntity="Sites")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sites_nb_site", referencedColumnName="nb_site")
     * })
     */
    private $sitesNbSite;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Participants", inversedBy="pursuitsNbPursuit")
     * @ORM\JoinTable(name="registrations",
     *   joinColumns={
     *     @ORM\JoinColumn(name="pursuits_nb_pursuit", referencedColumnName="nb_pursuit")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="participants_nb_participant", referencedColumnName="nb_participant")
     *   }
     * )
     */
    private $participantsNbParticipant;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->participantsNbParticipant = new ArrayCollection();
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
        return $this->urlpicture;
    }

    public function setUrlPicture(?string $urlPicture): self
    {
        $this->urlpicture = $urlPicture;

        return $this;
    }

    public function getStatesNbState(): ?States
    {
        return $this->statesNbState;
    }

    public function setStatesNbState(?States $statesNbState): self
    {
        $this->statesNbState = $statesNbState;

        return $this;
    }

    public function getLocationsNbLocation(): ?Locations
    {
        return $this->locationsNbLocation;
    }

    public function setLocationsNbLocation(?Locations $locationsNbLocation): self
    {
        $this->locationsNbLocation = $locationsNbLocation;

        return $this;
    }

    public function getOrganizer(): ?Participants
    {
        return $this->organizer;
    }

    public function setOrganizer(?Participants $organizer): self
    {
        $this->organizer = $organizer;

        return $this;
    }

    public function getSitesNbSite(): ?Sites
    {
        return $this->sitesNbSite;
    }

    public function setSitesNbSite(?Sites $sitesNbSite): self
    {
        $this->sitesNbSite = $sitesNbSite;

        return $this;
    }

    /**
     * @return Collection|Participants[]
     */
    public function getParticipantsNbParticipant(): Collection
    {
        return $this->participantsNbParticipant;
    }

    public function addParticipantsNbParticipant(Participants $participantsNbParticipant): self
    {
        if (!$this->participantsNbParticipant->contains($participantsNbParticipant)) {
            $this->participantsNbParticipant[] = $participantsNbParticipant;
        }

        return $this;
    }

    public function removeParticipantsNbParticipant(Participants $participantsNbParticipant): self
    {
        if ($this->participantsNbParticipant->contains($participantsNbParticipant)) {
            $this->participantsNbParticipant->removeElement($participantsNbParticipant);
        }

        return $this;
    }

}
