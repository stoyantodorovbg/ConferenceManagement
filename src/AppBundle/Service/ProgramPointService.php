<?php


namespace AppBundle\Service;


use AppBundle\Entity\Conference;
use AppBundle\Entity\ProgramPoint;
use AppBundle\Repository\ConferenceRepository;
use Doctrine\ORM\EntityManager;

class ProgramPointService
{

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function new(ProgramPoint $programPoint, int $conferenceId)
    {
        $em = $this->entityManager;

        $conferenceRepo = $this->entityManager->getRepository(Conference::class);
        $conference = $conferenceRepo->find($conferenceId);

        $programPoint->setConference($conference);

        $em->persist($programPoint);
        $em->flush();
    }

    public function delete(ProgramPoint $programPoint)
    {
        $em = $this->entityManager;
        $em->remove($programPoint);
        $em->flush();
    }
}