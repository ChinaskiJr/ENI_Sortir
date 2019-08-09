<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Pursuit;
use App\Entity\Registration;
use DateTime;
use Exception;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RegistrationController extends AbstractFOSRestController
{
    /**
     * Register a participant to a pursuit
     *
     * @Rest\Route("/registration/pursuit/{nbPursuit}/participant/{nbParticipant}")
     * @Rest\View()
     * @param $nbPursuit
     * @param $nbParticipant
     * @return Registration
     * @throws Exception
     */
    public function postRegistrationAction($nbPursuit, $nbParticipant) {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Registration::class);
        $registration = new Registration();
        $registration->setDateRegistration(new DateTime());
        // Get pursuit
        $pursuit = $this
            ->getDoctrine()
            ->getRepository(Pursuit::class)
            ->find($nbPursuit);
        // Check pursuit
        if (empty($pursuit)) {
            throw new HttpException(404, 'Aucune sortie correspondante');
        }
        if ($pursuit->getState()->getWord() !== 'Ouvert') {
            throw new HttpException(403, 'Cette sortie n\'accepte pas d\'inscriptions');
        }
        // Set pursuit
        $registration->setPursuit($pursuit);
        // Get Participant
        $participant = $this
            ->getDoctrine()
            ->getRepository(Participant::class)
            ->find($nbParticipant);
        // Get participant
        if (empty($participant)) {
            throw new HttpException(404, 'Aucun participant correspondant');
        }
        // set participant
        $registration->setParticipant($participant);
        // Is our user already registered ?
        $qb = $repository->createQueryBuilder('r')
            ->where('r.participant = :participant')
            ->setParameter('participant', $participant)
            ->andWhere('r.pursuit = :pursuit')
            ->setParameter('pursuit', $pursuit)
            ->getQuery();
        if (!empty($qb->execute())) {
            throw new HttpException(403, 'Participant déjà inscrit pour cette sortie');
        }
        // All is cool, persist !
        $em->persist($registration);
        $em->flush();
        return $registration;
    }
    /**
     * Remove a participant from a pursuit
     *
     * @Rest\Route("/registration/pursuit/{nbPursuit}/participant/{nbParticipant}")
     * @Rest\View()
     * @param $nbPursuit
     * @param $nbParticipant
     * @throws Exception
     */
    public function deleteRegistrationAction($nbPursuit, $nbParticipant) {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Registration::class);
        // Get pursuit
        $pursuit = $this
            ->getDoctrine()
            ->getRepository(Pursuit::class)
            ->find($nbPursuit);
        // Check pursuit
        if (empty($pursuit)) {
            throw new HttpException(404, 'Aucune sortie correspondante');
        }
        if ($pursuit->getState()->getWord() !== 'Ouvert') {
            throw new HttpException(403, 'Cette sortie n\'accepte pas de désistement');
        }
        // Get Participant
        $participant = $this
            ->getDoctrine()
            ->getRepository(Participant::class)
            ->find($nbParticipant);
        // Get participant
        if (empty($participant)) {
            throw new HttpException(404, 'Aucun participant correspondant');
        }
        // Get our registration
        $qb = $repository->createQueryBuilder('r')
            ->where('r.participant = :participant')
            ->setParameter('participant', $participant)
            ->andWhere('r.pursuit = :pursuit')
            ->setParameter('pursuit', $pursuit)
            ->getQuery();
        $registration = $qb->getSingleResult();
        $em->remove($registration);
        $em->flush();
    }
}
