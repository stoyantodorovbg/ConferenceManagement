<?php


namespace AppBundle\Service;


use AppBundle\Entity\Conference;
use AppBundle\Entity\Invitation;
use AppBundle\Entity\User;
use AppBundle\Repository\ConferenceRepository;
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

    public function approve(Invitation $invitation, User $user)
    {
        $invitation->setApproved(1);

        $conference = $invitation->getConference();

        if ($invitation->getType() == 'speaker') {
            $user = $this->setSpeaker($conference, $user);
            $this->confirmProgramPoint($conference, $user);
        } else {
            $user = $this->setAudience($conference, $user);
        }

        $em = $this->entityManager;

        $connection = $this->entityManager->getConnection();
        $connection->beginTransaction();


        $em->persist($user);
        $em->flush();

        $em->persist($invitation);
        $em->flush();

        $connection->commit();
    }

    public function refuse(Invitation $invitation, User $user)
    {
        $invitation->setRefused(1);

        $conference = $invitation->getConference();

        $em = $this->entityManager;

        $em->persist($invitation);
        $em->flush();
    }

    private function setSpeaker(Conference $conference, User $user)
    {
        $user->setSpeakerConferences($conference);

        return $user;
    }

    private function setAudience(Conference $conference, User $user)
    {
        $user->setAudienceConference($conference);

        return $user;
    }

    private function confirmProgramPoint(Conference $conference, User $user) {
        $em = $this->entityManager;

        $programPoints = $conference->getProgramPoints();
        foreach ($programPoints as $programPoint) {
            if ($programPoint->isConfirmed() == 0) {
                foreach($programPoint->getSpeakers() as $speaker) {
                    if ($speaker == $user) {
                        $programPoint->setConfirmed(1);
                        $em->persist($programPoint);
                        $em->flush();
                        break;
                    }
                }
            }
        }
    }
}
