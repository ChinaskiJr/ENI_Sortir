<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Location;
use App\Entity\Participant;
use App\Entity\Pursuit;
use App\Entity\Registration;
use App\Entity\Site;
use App\Entity\State;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $stateEnCours = new State('En Cours');
        $stateEnCreation = new State('En création');
        $stateFerme = new State('Inscriptions clôturées');
        $stateOuvert = new State('Ouvert');
        $stateTermine = new State('Terminé');
        $manager->persist($stateTermine);
        $site = new Site('ENI_Nantes');
        $site1 = new Site('ENI_Rennes');
        $site2 = new Site('ENI_Niort');
        $manager->persist($site2);
        $city = new City('Nantes', '44000');
        $city1 = new City('Rennes', '35000');
        $city2 = new City('Niort', '78000');
        $city3 = new City('Quimper', '29000');
        $manager->persist($city1);
        $manager->persist($city2);
        $manager->persist($city3);
        $location = new Location(
            'Parc de Procé',
            'Rue de Procé',
            -1.641132,
            47.245842,
            $city
        );
        $organizer = new Participant(
            'organizer',
            'Bouchard',
            'Arthur',
            null,
            'arthur@gmail.com',
            password_hash('weakPassword', PASSWORD_BCRYPT),
            false,
            true,
            $site,
            new ArrayCollection());

        $participant = new Participant(
            'participant',
            'Sylvestre',
            'Guillaume',
            null,
            'guillaume@gmail.com',
            password_hash('weakPassword', PASSWORD_BCRYPT),
            false,
            true,
            $site,
            new ArrayCollection()
        );

        // One pursuit
        $pursuit = new Pursuit(
            'Hockey sur Gazon',
            new DateTime("+1 week"),
            180,
            new DateTime('tomorrow'),
            15,
            'L\'occasion de faire du sport en prenant l\'air',
            1,
            null,
            $stateOuvert,
            $location,
            $participant,
            $site);

            $registration = new Registration();
            $registration->setDateRegistration(new DateTime());
            $registration->setPursuit($pursuit);
            $registration->setParticipant($participant);
            $participant->addRegistration($registration);
            $manager->persist($participant);

            $pursuit2 = new Pursuit(
            'Hockey sur Glace',
            new DateTime(),
            180,
            new DateTime('-1 day'),
            15,
            'L\'occasion de faire du sport au frais',
            1,
            null,
            $stateEnCours,
            $location,
            $organizer,
            $site1);

            $pursuit4 = new Pursuit(
            'Hockey sur Glace',
            new DateTime(),
            180,
            new DateTime('-1 day'),
            15,
            'L\'occasion de faire du sport au frais',
            1,
            null,
            $stateEnCours,
            $location,
            $organizer,
            $site);

            $pursuit3 = new Pursuit(
            'Hockey sur bitume',
            new DateTime('-1 day'),
            180,
            new DateTime('-3 day'),
            15,
            'L\'occasion de faire du sport en ville',
            1,
            null,
            $stateFerme,
            $location,
            $organizer,
            $site2);

            $pursuit5 = new Pursuit(
            'Hockey sur bitume',
            new DateTime('-1 day'),
            180,
            new DateTime('-3 day'),
            15,
            'L\'occasion de faire du sport en ville',
            1,
            null,
            $stateFerme,
            $location,
            $organizer,
            $site);

            $pursuit6 = new Pursuit(
                'Hockey sur piscine',
                new DateTime('+1 week'),
                180,
                new DateTime('+4 day'),
                15,
                'L\'occasion de se laver en même temps qu\'on transpire',
                1,
                null,
                $stateEnCreation,
                $location,
                $participant,
                $site);

        $manager->persist($pursuit);
        $manager->persist($pursuit2);
        $manager->persist($pursuit3);
        $manager->persist($pursuit4);
        $manager->persist($pursuit5);
        $manager->persist($pursuit6);
        // To bind them all
        for ($i = 1 ; $i < 5 ; $i++) {
            $participant = new Participant(
                'participant' . $i,
                'Sylvestre' . $i,
                'Guillaume' . $i,
                null,
                'guillaume@gmail.com',
                password_hash('weakPassword', PASSWORD_BCRYPT),
                false,
                true,
                $site,
                new ArrayCollection()
            );
            $registration = new Registration();
            $registration->setDateRegistration(new DateTime());
            $registration->setPursuit($pursuit);
            $registration->setParticipant($participant);
            $participant->addRegistration($registration);
            $manager->persist($participant);
        }
        $manager->flush();
    }
}
