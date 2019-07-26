<?php

namespace App\Controller;

use App\Entity\Participant;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ParticipantController extends AbstractFOSRestController
{
    /**
     * @param $pseudo
     * @param $password
     * @return View
     *
     * @Rest\View()
     */
    public function getParticipantLoginAction($pseudo, $password) {
        // Get the user
        $repository = $this->getDoctrine()->getRepository(Participant::class);
        $participant = $repository->findOneBy(array('pseudo' => $pseudo));
        // 404 if no pseudo
        if (empty($participant)) {
            throw new HttpException(404, 'Pseudo inconnu');
        }
        // 403 if the pseudo is wrong
         if (!password_verify($password, $participant->getPassword())) {
             throw new HttpException(403, 'Le mot de passe est incorrect');
         }
        // 200 and $participant serialized if all is good
        // Remove the password from the entity before serializing it
        $participant->setPassword('');
        return $participant;
    }
}
