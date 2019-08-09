<?php

namespace App\Tests\Controller;

use App\Entity\City;
use App\Entity\Location;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LocationControllerTest extends WebTestCase
{
    /**
     * @var KernelBrowser
     */
    private $client;
    /**
     * @var ParticipantRepository
     */
    private $repository;
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var City
     */
    private $cityRennes;

    protected function setUp() {
        $this->client = static::createClient([], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_ACCEPT' => 'application/json',
            'PHP_AUTH_USER' => 'eni_user',
            'PHP_AUTH_PW' => 'P4$$w0rd!'
        ]);
        $this->repository = $this->client
            ->getContainer()
            ->get('doctrine')
            ->getRepository(Location::class);
        $this->entityManager = $this->client
            ->getContainer()
            ->get('doctrine')
            ->getManager();
        // We also need to get a city ID
        $rennes = $this->entityManager->createQuery(
            'SELECT c FROM App\Entity\City c WHERE c.nameCity = :nameCity'
        )->setParameter('nameCity', 'Rennes')->execute();
        $rennes = $rennes[0];
        $this->cityRennes = $rennes;
    }

    public function testGetLocationsByCitiesAction()
    {
        $this->client->request('GET', '/locations/city/' . $this->cityRennes->getNbCity());
        $this->assertJson($this->client->getResponse()->getContent());
    }
}
