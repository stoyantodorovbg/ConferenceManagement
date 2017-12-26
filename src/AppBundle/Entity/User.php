<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface
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
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = "Your password name must be at least {{ limit }} characters long",
     *      maxMessage = "Your password name cannot be longer than {{ limit }} characters"
     * )
     */
    private $plainPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\NotBlank
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="registeredOn", type="datetime")
     */
    private $registeredOn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="bornOn", type="date", nullable=true)
     */
    private $bornOn;

    /**
     * @var string
     *
     * @ORM\Column(name="company", type="string", length=255, nullable=true)
     */
    private $company;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", length=255, nullable=true)
     */
    private $position;

    /**
     * @ORM\OneToMany(targetEntity="Conference", mappedBy="owner")
     */
    private $ownerConferences;

    /**
     * @ORM\ManyToMany(targetEntity="Conference", inversedBy="admins")
     * @ORM\JoinTable(name="admins_conferences")
     */
    private $adminConferences;

    /**
     * @ORM\ManyToMany(targetEntity="Conference", inversedBy="speakers")
     * @ORM\JoinTable(name="speakers_conferences")
     */
    private $speakerConferences;

    /**
     * @ORM\ManyToMany(targetEntity="ProgramPoint", inversedBy="speakers")
     * @ORM\JoinTable(name="speakers_programPoints")
     */
    private $speakerProgramPoints;

    /**
     * @ORM\ManyToMany(targetEntity="Conference", inversedBy="audience")
     * @ORM\JoinTable(name="audience_conferences")
     */
    private $audienceConference;

    /**
     * @ORM\ManyToMany(targetEntity="ProgramPoint", inversedBy="audience")
     * @ORM\JoinTable(name="audience_programPoints")
     */
    private $audienceProgramPoint;

    /**
     * @ORM\OneToMany(targetEntity="Invitation", mappedBy="user")
     */
    private $invitations;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Image(
     *     maxSize="700k",
     *     mimeTypes={"image/png", "image/jpeg", "image/jpg"}
     * )
     */
    public $image;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Role", inversedBy="users")
     * @ORM\JoinTable(name="users_roles",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")})
     */
    private $roles;

    public function __construct()
    {
        $this->invitations = new ArrayCollection();
        $this->audienceProgramPoint = new ArrayCollection();
        $this->speakerProgramPoints = new ArrayCollection();
    }


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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword(string $plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set registeredOn
     *
     * @param \DateTime $registeredOn
     *
     * @return User
     */
    public function setRegisteredOn($registeredOn)
    {
        $this->registeredOn = $registeredOn;

        return $this;
    }

    /**
     * Get registeredOn
     *
     * @return \DateTime
     */
    public function getRegisteredOn()
    {
        return $this->registeredOn;
    }

    /**
     * Set bornOn
     *
     * @param \DateTime $bornOn
     *
     * @return User
     */
    public function setBornOn($bornOn)
    {
        $this->bornOn = $bornOn;

        return $this;
    }

    /**
     * Get bornOn
     *
     * @return \DateTime
     */
    public function getBornOn()
    {
        return $this->bornOn;
    }

    /**
     * Set company
     *
     * @param string $company
     *
     * @return User
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set position
     *
     * @param string $position
     *
     * @return User
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getAudienceConference()
    {
        return $this->audienceConference;
    }

    /**
     * @param mixed $audienceConference
     */
    public function setAudienceConference($audienceConference)
    {
        $this->audienceConference[] = $audienceConference;
    }

    /**
     * @return mixed
     */
    public function getAudienceProgramPoint()
    {
        return $this->audienceProgramPoint;
    }

    /**
     * @param mixed $audienceProgramPoint
     */
    public function setAudienceProgramPoint($audienceProgramPoint)
    {
        $this->audienceProgramPoint = $audienceProgramPoint;
    }

    /**
     * @return mixed
     */
    public function getOwnerConferences()
    {
        return $this->ownerConferences;
    }

    /**
     * @param mixed $ownerConferences
     */
    public function setOwnerConferences($ownerConferences)
    {
        $this->ownerConferences = $ownerConferences;
    }

    /**
     * @return mixed
     */
    public function getAdminConferences()
    {
        return $this->adminConferences;
    }

    /**
     * @param mixed $adminConferences
     */
    public function setAdminConferences($adminConferences)
    {
        $this->adminConferences = $adminConferences;
    }

    /**
     * @return mixed
     */
    public function getSpeakerConferences()
    {
        return $this->speakerConferences;
    }

    /**
     * @param mixed $speakerConferences
     */
    public function setSpeakerConferences($speakerConferences)
    {
        $this->speakerConferences[] = $speakerConferences;
    }

    /**
     * @return mixed
     */
    public function getSpeakerProgramPoints()
    {
        return $this->speakerProgramPoints;
    }

    /**
     * @param mixed $speakerProgramPoints
     */
    public function setSpeakerProgramPoints($speakerProgramPoints)
    {
        $this->speakerProgramPoints = $speakerProgramPoints;
    }

    /**
     * @return mixed
     */
    public function getInvitations()
    {
        return $this->invitations;
    }

    /**
     * @param mixed $invitations
     */
    public function setInvitations($invitations)
    {
        $this->invitations = $invitations;
    }

    /**
     * @return (Role|string)[]
     */
    public function getRoles()
    {
        $stringRoles = [];
        foreach ($this->roles as $role) {
            /** @var $role Role */
            $stringRoles[] = $role->getRole();
        }
        return $stringRoles;
    }

    /**
     * @param \AppBundle\Entity\Role $role
     *
     * @return User
     */
    public function addRole(Role $role)
    {
        $this->roles[] = $role;

        return $this;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function __toString()
    {
        return $this->username;
    }


}

