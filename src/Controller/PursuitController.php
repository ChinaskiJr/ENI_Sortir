<?php

namespace App\Controller;

use App\Entity\Location;
use App\Entity\Participant;
use App\Entity\Pursuit;
use App\Entity\Site;
use App\Entity\State;
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
     * @Rest\Route("/organizer/{organizerId}/state/{stateId}/location/{locationId}/site/{siteId}/pursuits")
     * @Rest\View()
     * @ParamConverter("pursuit", converter="fos_rest.request_body")
     */
    public function postPursuitAction(Pursuit $pursuit, $organizerId, $stateId, $locationId, $siteId) {
        $em = $this->getDoctrine()->getManager();
        $organizer = $this->getDoctrine()->getRepository(Participant::class)->find($organizerId);
        $state = $this->getDoctrine()->getRepository(State::class)->find($stateId);
        $location = $this->getDoctrine()->getRepository(Location::class)->find($locationId);
        $site = $this->getDoctrine()->getRepository(Site::class)->find($siteId);
        $pursuit->setOrganizer($organizer);
        $pursuit->setState($state);
        $pursuit->setLocation($location);
        $pursuit->setSite($site);
        $em->persist($pursuit);
        $em->flush();
        return $pursuit;
    }
}
