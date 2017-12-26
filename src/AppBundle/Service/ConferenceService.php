<?php


namespace AppBundle\Service;


use AppBundle\Entity\Conference;
use Doctrine\ORM\EntityManager;

class ConferenceService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function new(Conference $conference)
    {
        $em = $this->entityManager;
        $em->persist($conference);
        $em->flush();
    }

    public function delete(Conference $conference)
    {
        $em = $this->entityManager;
        $em->remove($conference);
        $em->flush();
    }

}