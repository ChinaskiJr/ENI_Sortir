<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * City
 *
 * @ORM\Table(name="cities")
 * @ORM\Entity(repositoryClass="App\Repository\CityRepository")
 */
class City
{
    /**
     * @var int
     *
     * @ORM\Column(name="nb_city", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $nbCity;

    /**
     * @var string
     *
     * @ORM\Column(name="name_city", type="string", length=30, nullable=false)
     */
    private $nameCity;

    /**
     * @var string
     *
     * @ORM\Column(name="postal_code", type="string", length=10, nullable=false)
     */
    private $postalCode;

    /**
     * City constructor.
     * @param string $nameCity
     * @param string $postalCode
     */
    public function __construct(string $nameCity, string $postalCode)
    {
        $this->nameCity = $nameCity;
        $this->postalCode = $postalCode;
    }


    public function getNbCity(): ?int
    {
        return $this->nbCity;
    }

    public function getNameCity(): ?string
    {
        return $this->nameCity;
    }

    public function setNameCity(string $nameCity): self
    {
        $this->nameCity = $nameCity;

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

}
