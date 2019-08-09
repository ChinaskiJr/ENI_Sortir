<?php

namespace App\Controller;

use App\Entity\City;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class CityController extends AbstractFOSRestController
{
    /**
     * Get all the cities in the database
     * @return City[]
     *
     * @Rest\View()
     */
    public function getCitiesAction() {
        $repository = $this->getDoctrine()->getRepository(City::class);
        $cities = $repository->findAll();
        return $cities;
    }
}
