<?php

namespace App\Tests\Controller;

use App\Entity\City;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SiteControllerTest extends WebTestCase
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
            ->getRepository(City::class);
        $this->entityManager = $this->client
            ->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testGetSitesAction()
    {
        $this->client->request('GET', '/sites');
        $this->assertJson($this->client->getResponse()->getContent());
        $this->assertEquals(3, count(json_decode($this->client->getResponse()->getContent(), true)));
    }
}
