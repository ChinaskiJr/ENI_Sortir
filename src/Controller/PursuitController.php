<?php

namespace App\Controller;

use App\Entity\Pursuit;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class PursuitController extends AbstractFOSRestController
{
    /**
     * @param $site
     * @return Pursuit[]
     *
     * @Rest\Route("/pursuits/site/{site}")
     * @Rest\View()
     */
    public function getPursuitsSiteAction($site) {
        $repository = $this->getDoctrine()->getRepository(Pursuit::class);
        $pursuits = $repository->findBy(array('site' => $site));

        return $pursuits;
    }
}
