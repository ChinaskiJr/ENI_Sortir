<?php

namespace App\Controller;

use App\Entity\State;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class StateController extends AbstractFOSRestController
{
    /**
     * @Rest\Route()
     * @Rest\View()
     */
    public function getStatesAction() {
        $repository = $this->getDoctrine()->getRepository(State::class);
        $states = $repository->findAll();
        return $states;
    }
}
