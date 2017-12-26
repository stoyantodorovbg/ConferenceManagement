<?php


namespace AppBundle\Service;


use AppBundle\Entity\Address;
use Doctrine\ORM\EntityManager;

class AddressService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function new(Address $address)
    {
        $em = $this->entityManager;
        $em->persist($address);
        $em->flush();
    }

    public function delete(Address $address)
    {
        $em = $this->entityManager;
        $em->remove($address);
        $em->flush();
    }

}