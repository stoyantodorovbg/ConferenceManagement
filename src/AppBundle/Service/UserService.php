<?php


namespace AppBundle\Service;


use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;

class UserService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function setRegisterData(User $user, $password)
    {
        $roleRepo = $this->entityManager->getRepository(Role::class);
        $roleUser = $roleRepo->findOneBy(['name' => 'ROLE_USER']);

        $user->addRole($roleUser);
        $user->setPassword($password);
        $user->setRegisteredOn(new \DateTime('now'));

        return $user;
    }
}