<?php

namespace App\Controller;

use App\Entity\Pursuit;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class PursuitController extends AbstractFOSRestController
{
    /**
     * Get all pursuits proposed by a Site
     *
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

    /**
     * Post new Pursuit
     *
     * @param Pursuit $pursuit
     * @return Pursuit
     *
     * @Rest\View()
     * @ParamConverter("pursuit", converter="fos_rest.request_body")
     */
    public function postPursuitAction(Pursuit $pursuit) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($pursuit);
        $em->flush();
        return $pursuit;
    }
}
