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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
     * Get all pursuits proposed by a Site except those archived
     *
     * @param $site
     * @return Pursuit[]
     *
     * @Rest\Route("/pursuits/unarchived/site/{site}")
     * @Rest\View()
     */
    public function getPursuitsExceptArchivedSiteAction($site) {
        $repository = $this->getDoctrine()->getRepository(Pursuit::class);
        // Get the archived state
        $archivedState = $this->getDoctrine()
            ->getRepository(State::class)
            ->findBy(array('word' => 'Archivé'));
        // Give the archived state entity to DQL, we don't want it !
        $pursuits = $repository->findAllPursuitsUnarchivedBysite($site, $archivedState);
        return $pursuits;
    }

    /**
     * Post new Pursuit
     * @param Pursuit $pursuit
     * @param $organizerId
     * @param $stateId
     * @param $locationId
     * @param $siteId
     * @return Pursuit
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

    /**
     * @Rest\View()
     * @param $nbPursuit
     * @return Pursuit|null
     */
    public function getPursuitAction($nbPursuit) {
        $repository = $this->getDoctrine()->getRepository(Pursuit::class);
        $pursuit = $repository->find($nbPursuit);
        if (empty($pursuit)) {
            throw new HttpException(Response::HTTP_NOT_FOUND, 'Sortie inconnu');
        } else {
            return $pursuit;
        }
    }

    /**
     * Update a pursuit
     *
     * @Rest\View()
     * @ParamConverter("pursuit", converter="fos_rest.request_body")
     * @param Pursuit $pursuit
     * @return Pursuit
     */
    public function putPursuitAction(Pursuit $pursuit) {
        $em = $this->getDoctrine()->getManager();
        $em->merge($pursuit);
        $em->flush();
        return $pursuit;
    }
}
