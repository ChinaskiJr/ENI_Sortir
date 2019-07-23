<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sites
 *
 * @ORM\Table(name="sites")
 * @ORM\Entity
 */
class Sites
{
    /**
     * @var int
     *
     * @ORM\Column(name="nb_site", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="sites_nb_site_seq", allocationSize=1, initialValue=1)
     */
    private $nbSite;

    /**
     * @var string
     *
     * @ORM\Column(name="name_site", type="string", length=30, nullable=false)
     */
    private $nameSite;

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
