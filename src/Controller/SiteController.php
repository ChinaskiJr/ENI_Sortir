<?php

namespace App\Controller;

use App\Entity\Site;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;


class SiteController extends AbstractFOSRestController
{
    /**
     * Get all the sites in the database
     * @return Site[]
     *
     * @Rest\View()
     */
    public function getSitesAction() {
        $repository = $this->getDoctrine()->getRepository(Site::class);
        $sites = $repository->findAll();
        return $sites;
    }
}
