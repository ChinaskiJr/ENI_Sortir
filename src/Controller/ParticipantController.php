<?php

namespace App\Controller;

use App\Entity\Participant;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ParticipantController extends AbstractFOSRestController
{
    const IV = 'kfjd158ds45a8pl6';

    /**
     * Check if pseudo and password matched in the database
     *
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

    /**
     * Encrypt and store the token into the database
     *
     * @param Participant $participantBuffer
     *
     * @Rest\View()
     * @ParamConverter("participantBuffer", converter="fos_rest.request_body")
     */
    public function postParticipantsTokenAction(Participant $participantBuffer) {
        $em = $this->getDoctrine()->getManager();
        $pseudo = $participantBuffer->getPseudo();
        $token = $participantBuffer->getToken();
        // Get the user
        $repository = $this->getDoctrine()->getRepository(Participant::class);
        $participant = $repository->findOneBy(array('pseudo' => $pseudo));
        // Encrypt the token
        $encryptedToken = openssl_encrypt($pseudo, 'aes-256-ctr', $token, 0, self::IV);
        // Store it
        $participant->setToken($encryptedToken);
        $em->persist($participant);
        $em->flush();
    }

    /**
     * Check if the token stored in Angular's cookie match the one in the db
     *
     * @param $pseudo
     * @param $token
     * @return Participant|null
     *
     * @Rest\View()
     */
    public function getParticipantsTokenAction($pseudo, $token) {
        // Get the user
        $repository = $this->getDoctrine()->getRepository(Participant::class);
        $participant = $repository->findOneBy(array('pseudo' => $pseudo));
        $encryptedToken = openssl_encrypt($pseudo, 'aes-256-ctr', $token, 0, self::IV);
        // Check the token
        if ($participant->getToken() !== $encryptedToken) {
            throw new HttpException(404, 'Token inconnu ou invalide');
        } else {
            // Remove the password from the entity before serializing it
            $participant->setPassword('');
            return $participant;
        }
    }
}
