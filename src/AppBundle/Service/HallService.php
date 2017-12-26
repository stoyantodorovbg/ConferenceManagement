<?php


namespace AppBundle\Service;


use AppBundle\Entity\Hall;
use Doctrine\ORM\EntityManager;

class HallService
{

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function new(Hall $hall)
    {
        $em = $this->entityManager;
        $em->persist($hall);
        $em->flush();
    }

    public function delete(Hall $hall)
    {
        $em = $this->entityManager;
        $em->remove($hall);
        $em->flush();
    }
}