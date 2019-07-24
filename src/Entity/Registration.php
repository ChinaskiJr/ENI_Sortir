<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Registration
 * @ORM\Table(name="registrations")
 * @ORM\Entity(repositoryClass="App\Repository\RegistrationRepository")
 */
class Registration
{
    /**
     * @var Pursuit
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Pursuit", inversedBy="registrations", cascade={"persist"})
     * @ORM\JoinColumn(name="pursuits_nb_pursuit", referencedColumnName="nb_pursuit")
     */
    private $pursuit;

    /**
     * @var Participant
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Participant", inversedBy="registrations", cascade={"persist"})
     * @ORM\JoinColumn(name="participants_nb_participant", referencedColumnName="nb_participant")
     */
    private $participant;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date_registration", type="datetime")
     */
    private $dateRegistration;

    public function getPursuit(): ?Pursuit
    {
        return $this->pursuit;
    }

    public function setPursuit(Pursuit $pursuit): self
    {
        $this->pursuit = $pursuit;

        return $this;
    }

    public function getParticipant(): ?Participant
    {
        return $this->participant;
    }

    public function setParticipant(Participant $participant): self
    {
        $this->participant = $participant;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDateRegistration(): DateTime
    {
        return $this->dateRegistration;
    }

    /**
     * @param DateTime $dateRegistration
     */
    public function setDateRegistration(DateTime $dateRegistration): void
    {
        $this->dateRegistration = $dateRegistration;
    }


}
