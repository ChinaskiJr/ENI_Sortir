<?php

namespace App\Controller;

use App\Entity\Location;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class LocationController extends AbstractFOSRestController
{
    /**
     * Get all locations of a City
     *
     * @param $city
     * @return Location[]
     *
     * @Rest\Route("/locations/city/{city}")
     * @Rest\View()
     */
    public function getLocationsByCitiesAction($city) {
        $repository = $this->getDoctrine()->getRepository(Location::class);
        $locations = $repository->findBy(array('city' => $city));

        return $locations;
    }

    /**
     * Post a new location
     *
     * @param Location $location
     * @return Location
     *
     * @Rest\View()
     * @ParamConverter("location", converter="fos_rest.request_body")
     */
    public function postLocationAction(Location $location) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($location);
        $em->flush();
        return $location;
    }
}
