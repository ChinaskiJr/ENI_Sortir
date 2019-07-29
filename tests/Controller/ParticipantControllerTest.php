<?php


namespace App\Tests\Controller;


use App\Entity\Participant;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ParticipantControllerTest extends WebTestCase
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
            ->getRepository(Participant::class);
        $this->entityManager = $this->client
            ->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testParticipantLoginAction() {
        $this->client->request('GET', '/participants/organizer/logins/weakPassword');
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->client->request('GET', '/participants/marco/logins/weakPassword');
        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
        $this->client->request('GET', '/participants/organizer/logins/noPassword');
        $this->assertEquals(Response::HTTP_FORBIDDEN, $this->client->getResponse()->getStatusCode());
    }

    public function testParticipantsTokenAction() {
        $options = array('pseudo' => 'organizer', 'token' => 'lolilol');
        $options = json_encode($options);
        $this->client->request('POST', '/participants/tokens', [], [], [], $options);
        $this->assertEquals(Response::HTTP_NO_CONTENT, $this->client->getResponse()->getStatusCode());
        $this->client->request('GET', '/participants/organizer/tokens/lolilol');
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

     public function testGetParticipantAction() {
         $this->client->request('GET', '/participants/0');
         $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
         $this->client->request('GET', '/participants/46');
         $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
         $this->assertJson($this->client->getResponse()->getContent());
     }

    public function testParticipantUpdateAction() {
        // Get to get
        $this->client->request('GET', '/participants/46');
        $jsonParticipant = $this->client->getResponse()->getContent();
        $jsonParticipant = json_decode($jsonParticipant);
        $jsonParticipant->first_name = 'ArthurUpdate';
        $jsonParticipant->password = 'weakPassword';
        $jsonParticipant = json_encode($jsonParticipant);
        $this->client->request('PUT', '/participant/update', [], [], [], $jsonParticipant);
        // Check after update
        $participantToUpdate = $this->repository->find(46);
        $this->assertEquals('ArthurUpdate', $participantToUpdate->getFirstName());
        // Check for exception if non-unique pseudo
        $this->client->request('GET', '/participants/46');
        $jsonParticipant = $this->client->getResponse()->getContent();
        $jsonParticipant = json_decode($jsonParticipant);
        $jsonParticipant->pseudo = 'participant0';
        $jsonParticipant = json_encode($jsonParticipant);
        $this->client->request('PUT', '/participant/update', [], [], [], $jsonParticipant);
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $this->client->getResponse()->getStatusCode());
    }
}
