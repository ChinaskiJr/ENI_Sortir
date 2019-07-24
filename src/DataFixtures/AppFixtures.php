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
        $site = new Site('Nantes');
        $city = new City('Nantes', '44000');
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
            'weakPassword',
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
        $manager->persist($pursuit);
        // To bind them all
        for ($i = 0 ; $i < 5 ; $i++) {
            $participant = new Participant(
                'participant' . $i,
                'Sylvestre' . $i,
                'Guillaume' . $i,
                null,
                'guillaume@gmail.com',
                'weakPassword',
                false,
                true,
                new Site('Nantes')
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
