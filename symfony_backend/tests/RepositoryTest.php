<?php


namespace App\Tests;


use App\Entity\Pursuit;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class PursuitRepositoryTest
 * @package App\Tests
 *
 * Data for theses tests came from DataFixtures
 */
class PursuitRepositoryTest extends KernelTestCase
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    protected function setUp() {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel
            ->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * Test from a pursuit instance if every other entities are rightfully instantiated
     */
    public function testRelationsBetweenEntities() {
        $pursuits = $this->entityManager
            ->getRepository(Pursuit::class)
            ->findAll();
        foreach ($pursuits as $pursuit) {
            $this->assertInstanceOf('App\Entity\Pursuit', $pursuit);
            foreach ($pursuit->getRegistrations() as $registration) {
                $this->assertInstanceOf('App\Entity\Participant', $registration->getParticipant());
                $this->assertInstanceOf('App\Entity\Pursuit', $registration->getPursuit());
            }
            $this->assertInstanceOf('App\Entity\State', $pursuit->getState());
            $this->assertInstanceOf('App\Entity\Site', $pursuit->getSite());
            $this->assertInstanceOf('App\Entity\Location', $pursuit->getLocation());
            $this->assertInstanceOf('App\Entity\City', $pursuit->getLocation()->getCity());
            $this->assertInstanceOf('App\Entity\Participant', $pursuit->getOrganizer());
        }
    }
}
