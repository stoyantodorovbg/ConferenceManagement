<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Invitation
 *
 * @ORM\Table(name="invitations")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InvitationRepository")
 */
class Invitation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateOfCreation", type="datetime")
     */
    private $dateOfCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateApproval", type="datetime", nullable=true)
     */
    private $dateApproval;

    /**
     * @var bool
     *
     * @ORM\Column(name="approved", type="boolean")
     */
    private $approved;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateRefusal", type="datetime", nullable=true)
     */
    private $dateRefusal;

    /**
     * @var bool
     *
     * @ORM\Column(name="refused", type="boolean", nullable=true)
     */
    private $refused;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=256)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=256)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=10000)
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity="Conference", inversedBy="invitations")
     * @ORM\JoinColumn(name="conference_id", referencedColumnName="id")
     */
    private $conference;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", inversedBy="invitations")
     * @ORM\JoinTable(
     *     name="users_invitations",
     *     joinColumns={
     *          @ORM\JoinColumn(name="invitation_id",
     *          referencedColumnName="id")
     * },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="user_id",
     *          referencedColumnName="id")
     * })
     */
    private $users;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateOfCreation
     *
     * @param \DateTime $dateOfCreation
     *
     * @return Invitation
     */
    public function setDateOfCreation($dateOfCreation)
    {
        $this->dateOfCreation = $dateOfCreation;

        return $this;
    }

    /**
     * Get dateOfCreation
     *
     * @return \DateTime
     */
    public function getDateOfCreation()
    {
        return $this->dateOfCreation;
    }

    /**
     * Set dateApproval
     *
     * @param \DateTime $dateApproval
     *
     * @return Invitation
     */
    public function setDateApproval($dateApproval)
    {
        $this->dateApproval = $dateApproval;

        return $this;
    }

    /**
     * Get dateApproval
     *
     * @return \DateTime
     */
    public function getDateApproval()
    {
        return $this->dateApproval;
    }

    /**
     * @return \DateTime
     */
    public function getDateRefusal(): \DateTime
    {
        return $this->dateRefusal;
    }

    /**
     * @param \DateTime $dateRefusal
     */
    public function setDateRefusal(\DateTime $dateRefusal)
    {
        $this->dateRefusal = $dateRefusal;
    }

    /**
     * @return bool
     */
    public function isRefused()
    {
        return $this->refused;
    }

    /**
     * @param bool $refused
     */
    public function setRefused(bool $refused)
    {
        $this->refused = $refused;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Invitation
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return bool
     */
    public function isApproved()
    {
        return $this->approved;
    }

    /**
     * @param bool $approved
     */
    public function setApproved(bool $approved)
    {
        $this->approved = $approved;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getConference()
    {
        return $this->conference;
    }

    /**
     * @param mixed $conference
     */
    public function setConference($conference)
    {
        $this->conference = $conference;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }
}

