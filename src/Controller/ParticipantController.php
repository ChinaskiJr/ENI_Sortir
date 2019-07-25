<?php

namespace App\Controller;

use App\Entity\Participant;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ParticipantController extends AbstractFOSRestController
{
    /**
     * @param $pseudo
     * @param $password
     * @return Response
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
        if ($participant->getPassword() != $password) {
            throw new HttpException(403, 'Le mot de passe est incorrect');
        }
        // 200 and $participant serialized if all is good
        return $participant;
    }
}
