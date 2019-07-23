<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * States
 *
 * @ORM\Table(name="states")
 * @ORM\Entity
 */
class States
{
    /**
     * @var int
     *
     * @ORM\Column(name="nb_state", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="states_nb_state_seq", allocationSize=1, initialValue=1)
     */
    private $nbState;

    /**
     * @var string
     *
     * @ORM\Column(name="word", type="string", length=30, nullable=false)
     */
    private $word;

    public function getNbState(): ?int
    {
        return $this->nbState;
    }

    public function getWord(): ?string
    {
        return $this->word;
    }

    public function setWord(string $word): self
    {
        $this->word = $word;

        return $this;
    }


}
