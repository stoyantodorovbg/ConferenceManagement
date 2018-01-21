<?php


namespace AppBundle\Service;

use AppBundle\Entity\Message;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;


class MessageService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

    }

    public function newMessage(Message $message, User $user)
    {
        $message->setSender($user);
        $message->setDateCreated(new \DateTime());
        $em = $this->entityManager;
        $em->persist($message);
        $em->flush();
    }

    public function deleteMessage(Message $message)
    {
        $em = $this->entityManager;
        $em->remove($message);
        $em->flush();
    }
}