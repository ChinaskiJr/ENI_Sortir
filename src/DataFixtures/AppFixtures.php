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
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
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
            456,
            123,
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
            $site);
        // One pursuit
        $pursuit = new Pursuit(
            'Hockey sur Gazon',
            new DateTime(),
            180,
            new DateTime('tomorrow'),
            15,
            'L\'occasion de faire du sport en prenant l\'air',
            1,
            null,
            new State('EnCours'),
            $location,
            $organizer,
            $site);

            $pursuit2 = new Pursuit(
            'Hockey sur Glace',
            new DateTime(),
            180,
            new DateTime('tomorrow'),
            15,
            'L\'occasion de faire du sport au frais',
            1,
            null,
            new State('EnCours'),
            $location,
            $organizer,
            $site1);

            $pursuit3 = new Pursuit(
            'Hockey sur bitume',
            new DateTime(),
            180,
            new DateTime('tomorrow'),
            15,
            'L\'occasion de faire du sport en ville',
            1,
            null,
            new State('EnCours'),
            $location,
            $organizer,
            $site2);

        $manager->persist($pursuit);
        $manager->persist($pursuit2);
        $manager->persist($pursuit3);
        // To bind them all
        for ($i = 0 ; $i < 5 ; $i++) {
            $participant = new Participant(
                'participant' . $i,
                'Sylvestre' . $i,
                'Guillaume' . $i,
                null,
                'guillaume@gmail.com',
                password_hash('weakPassword', PASSWORD_BCRYPT),
                false,
                true,
                $site1
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
