<?php


namespace AppBundle\Service;


use AppBundle\Entity\Conference;
use AppBundle\Entity\Invitation;
use Doctrine\ORM\EntityManager;

class InvitationService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function new(Invitation $invitation, int $conferenceId)
    {
        $conferenceRepo = $this->entityManager->getRepository(Conference::class);
        $conference = $conferenceRepo->find($conferenceId);

        $invitation->setConference($conference);
        $invitation->setApproved(0);
        $invitation->setDateOfCreation(new \DateTime());
        
        $em = $this->entityManager;
        $em->persist($invitation);
        $em->flush();
    }

    public function delete(Invitation $invitation)
    {
        $em = $this->entityManager;
        $em->remove($invitation);
        $em->flush();
    }

    public function approve(Invitation $invitation)
    {
        $invitation->setApproved(1);
        $em = $this->entityManager;
        $em->persist($invitation);
        $em->flush();
    }

}