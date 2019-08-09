<?php

namespace App\Tests\Controller;

use App\Entity\Pursuit;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PursuitControllerTest extends WebTestCase
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
            ->getRepository(Pursuit::class);
        $this->entityManager = $this->client
            ->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testGetPursuitsSiteAction()
    {
        // Get the ID
        $id = $this->entityManager->createQuery(
            'SELECT s.nbSite FROM App\Entity\Site s WHERE s.nameSite = :nameSite'
        )->setParameter('nameSite', 'ENI_Nantes')->execute();
        $id = $id[0]['nbSite'];
        $this->client->request('GET', '/pursuits/site/' . $id);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $result = $this->client->getResponse()->getContent();
        $result = json_decode($result, true);
        $this->assertEquals('Hockey sur Gazon', $result[0]['name']);
    }

}
