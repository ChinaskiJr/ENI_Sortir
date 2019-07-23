<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Participants
 *
 * @ORM\Table(name="participants", uniqueConstraints={@ORM\UniqueConstraint(name="participants_pseudo_uk", columns={"pseudo"})}, indexes={@ORM\Index(name="IDX_7169709251C3F4BB", columns={"sites_no_site"})})
 * @ORM\Entity
 */
class Participants
{
    /**
     * @var int
     *
     * @ORM\Column(name="nb_participant", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="participants_nb_participant_seq", allocationSize=1, initialValue=1)
     */
    private $nbParticipant;

    /**
     * @var string
     *
     * @ORM\Column(name="pseudo", type="string", length=30, nullable=false)
     */
    private $pseudo;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=30, nullable=false)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=30, nullable=false)
     */
    private $firstName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="phone", type="string", length=15, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=20, nullable=false)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=20, nullable=false)
     */
    private $password;

    /**
     * @var bool
     *
     * @ORM\Column(name="admin", type="boolean", nullable=false)
     */
    private $admin;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    /**
     * @var Sites
     *
     * @ORM\ManyToOne(targetEntity="Sites")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sites_no_site", referencedColumnName="nb_site")
     * })
     */
    private $sitesNoSite;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Pursuits", mappedBy="participantsNbParticipant")
     */
    private $pursuitsNbPursuit;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pursuitsNbPursuit = new ArrayCollection();
    }

    public function getNbParticipant(): ?int
    {
        return $this->nbParticipant;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getAdmin(): ?bool
    {
        return $this->admin;
    }

    public function setAdmin(bool $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getSitesNoSite(): ?Sites
    {
        return $this->sitesNoSite;
    }

    public function setSitesNoSite(?Sites $sitesNoSite): self
    {
        $this->sitesNoSite = $sitesNoSite;

        return $this;
    }

    /**
     * @return Collection|Pursuits[]
     */
    public function getPursuitsNbPursuit(): Collection
    {
        return $this->pursuitsNbPursuit;
    }

    public function addPursuitsNbPursuit(Pursuits $pursuitsNbPursuit): self
    {
        if (!$this->pursuitsNbPursuit->contains($pursuitsNbPursuit)) {
            $this->pursuitsNbPursuit[] = $pursuitsNbPursuit;
            $pursuitsNbPursuit->addParticipantsNbParticipant($this);
        }

        return $this;
    }

    public function removePursuitsNbPursuit(Pursuits $pursuitsNbPursuit): self
    {
        if ($this->pursuitsNbPursuit->contains($pursuitsNbPursuit)) {
            $this->pursuitsNbPursuit->removeElement($pursuitsNbPursuit);
            $pursuitsNbPursuit->removeParticipantsNbParticipant($this);
        }

        return $this;
    }

}
