<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ParticipantControllerTest extends WebTestCase
{
    /**
     * @var KernelBrowser
     */
    private $client;

    protected function setUp() {
        $this->client = static::createClient([], ['HTTP_ACCEPT' => 'application/json']);
    }

    public function testParticipantLoginAction() {
        $this->client->request('GET', '/participants/organizer/logins/weakPassword');
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->client->request('GET', '/participants/marco/logins/weakPassword');
        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
        $this->client->request('GET', '/participants/organizer/logins/noPassword');
        $this->assertEquals(Response::HTTP_FORBIDDEN, $this->client->getResponse()->getStatusCode());
    }
}
