<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * State
 *
 * @ORM\Table(name="states")
 * @ORM\Entity(repositoryClass="App\Repository\StateRepository")
 */
class State
{
    /**
     * @var int
     *
     * @ORM\Column(name="nb_state", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $nbState;

    /**
     * @var string
     *
     * @ORM\Column(name="word", type="string", length=30, nullable=false)
     */
    private $word;

    /**
     * State constructor.
     * @param string $word
     */
    public function __construct(string $word)
    {
        $this->word = $word;
    }


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
