<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Location
 *
 * @ORM\Table(name="locations", indexes={@ORM\Index(name="IDX_17E64ABAFEBBDC20", columns={"cities_nb_city"})})
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 */
class Location
{
    /**
     * @var int
     *
     * @ORM\Column(name="nb_location", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $nbLocation;

    /**
     * @var string
     *
     * @ORM\Column(name="name_location", type="string", length=30, nullable=false)
     */
    private $nameLocation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="street", type="string", length=30, nullable=true)
     */
    private $street;

    /**
     * @var float|null
     *
     * @ORM\Column(name="latitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $latitude;

    /**
     * @var float|null
     *
     * @ORM\Column(name="longitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $longitude;

    /**
     * @var City
     *
     * @ORM\ManyToOne(targetEntity="City", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cities_nb_city", referencedColumnName="nb_city", nullable=false)
     * })
     */
    private $city;

    /**
     * Location constructor.
     * @param string $nameLocation
     * @param string|null $street
     * @param float|null $latitude
     * @param float|null $longitude
     * @param City $city
     */
    public function __construct(string $nameLocation,
                                ?string $street,
                                ?float $latitude,
                                ?float $longitude,
                                City $city)
    {
        $this->nameLocation = $nameLocation;
        $this->street = $street;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->city = $city;
    }


    public function getNbLocation(): ?int
    {
        return $this->nbLocation;
    }

    public function getNameLocation(): ?string
    {
        return $this->nameLocation;
    }

    public function setNameLocation(string $nameLocation): self
    {
        $this->nameLocation = $nameLocation;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }
}
