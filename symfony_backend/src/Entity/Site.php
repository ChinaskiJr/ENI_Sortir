<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Site
 *
 * @ORM\Table(name="sites")
 * @ORM\Entity(repositoryClass="App\Repository\SiteRepository")
 */
class Site
{
    /**
     * @var int
     *
     * @ORM\Column(name="nb_site", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $nbSite;

    /**
     * @var string
     *
     * @ORM\Column(name="name_site", type="string", length=30, nullable=false)
     */
    private $nameSite;

    /**
     * Site constructor.
     * @param string $nameSite
     */
    public function __construct(string $nameSite)
    {
        $this->nameSite = $nameSite;
    }


    public function getNbSite(): ?int
    {
        return $this->nbSite;
    }

    public function getNameSite(): ?string
    {
        return $this->nameSite;
    }

    public function setNameSite(string $nameSite): self
    {
        $this->nameSite = $nameSite;

        return $this;
    }
}
