<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Site;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ParticipantController extends AbstractFOSRestController
{
    const IV = 'kfjd158ds45a8pl6';

    /**
     * Check if pseudo and password matched in the database
     * @param Request $request
     * @return View
     * @Rest\View()
     */
    public function postParticipantLoginAction(Request $request) {
        // Get the param
        $pseudo = $request->request->get('pseudo');
        $password = $request->request->get('password');        // Get the user
        $repository = $this->getDoctrine()->getRepository(Participant::class);
        $participant = $repository->findOneBy(array('pseudo' => $pseudo));
        // 404 if no pseudo
        if (empty($participant)) {
            throw new HttpException(Response::HTTP_NOT_FOUND, 'Pseudo inconnu');
        }
        // 403 if the pseudo is wrong
         if (!password_verify($password, $participant->getPassword())) {
             throw new HttpException(Response::HTTP_FORBIDDEN, 'Le mot de passe est incorrect');
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
            throw new HttpException(Response::HTTP_NOT_FOUND, 'Token inconnu ou invalide');
        } else {
            // Remove the password from the entity before serializing it
            $participant->setPassword('');
            return $participant;
        }
    }

    /**
     * Get a participant by his id
     *
     * @param $nbParticipant int The id of the participant to get
     * @return Participant
     *
     * @Rest\View()
     */
    public function getParticipantAction($nbParticipant) {
        $repository = $this->getDoctrine()->getRepository(Participant::class);
        $participant = $repository->find($nbParticipant);
        if (empty($participant)) {
            throw new HttpException(Response::HTTP_NOT_FOUND, 'Aucun utilisateur avec cet ID');
        }
        return $participant;
    }

    /**
     * Update a participant basic fields :
     * pseudo, last name, first name, phone, mail and password
     * @param $participant
     * @Rest\View()
     * @ParamConverter("participant", converter="fos_rest.request_body")
     * @return Participant|null
     */
    public function putParticipantUpdateAction(Participant $participant) {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Participant::class);
        $participantToUpdate = $repository->findOneBy(array('nbParticipant' => $participant->getNbParticipant()));
        // 404 if no pseudo
        if (empty($participantToUpdate)) {
            throw new HttpException(Response::HTTP_NOT_FOUND, 'Utilisateur inconnu');
        }
        // Participant must have unique pseudo
        if ($participant->getPseudo() != $participantToUpdate->getPseudo()) {
            if ($repository->findOneBy(array('pseudo' => $participant->getPseudo())) != null) {
                // 401 if not
                throw new HttpException(Response::HTTP_UNAUTHORIZED, 'Pseudo déjà pris');
            } else {
                $participantToUpdate->setPseudo($participant->getPseudo());
            }
        }
        $participantToUpdate->setLastName($participant->getLastName());
        $participantToUpdate->setFirstName($participant->getFirstName());
        $participantToUpdate->setPhone($participant->getPhone());
        $participantToUpdate->setMail($participant->getMail());
        if (!empty($participant->getPassword())) {
            $participantToUpdate->setPassword(password_hash($participant->getPassword(), PASSWORD_BCRYPT));
        }
        $site = $this->getDoctrine()->getRepository(Site::class)->find($participant->getSite()->getNbSite());
        $participantToUpdate->setSite($site);
        $em->flush();
        return $participantToUpdate;
    }

    /**
     * @Rest\View()
     * @Rest\Route("/participant/pseudo/{pseudo}")
     * @param $pseudo
     * @return Participant|object|null
     */
    public function getParticipantByPseudoAction($pseudo) {
        $repository = $this->getDoctrine()->getRepository(Participant::class);
        $participant = $repository->findOneBy(array('pseudo' => $pseudo));
        if (empty($participant)) {
            throw new HttpException(404, 'Aucun participant avec ce pseudo');
        } else {
            return $participant;
        }
    }
}
