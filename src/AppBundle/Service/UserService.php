<?php


namespace AppBundle\Service;


use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\File\File;

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

    public function setImage(Form $editForm, User $user, $imageDirectory)
    {
        $imageName = null;
        if ($user->getImage() != null) {
            $imageName = $user->getImage();
            $user->setImage(new File($imageDirectory.'/'.$user->getImage()));
        }

        //dump($editForm->all()['image']->getNormData() == '');exit;

        if ($editForm->all()['image']->getNormData() == '') {
            $user->setImage($imageName);
        } else {
            $image = $editForm->all()['image']->getNormData();
            $imageName = md5(uniqid()) . '.' . $image->guessExtension();
            $image->move(
                $imageDirectory,
                $imageName
            );
            $user->setImage($imageName);
        }
        return $user;
    }

    public function save($user)
    {
        $em = $this->entityManager;
        $em->persist($user);
        $em->flush();
    }
}