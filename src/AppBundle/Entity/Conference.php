<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Conference
 *
 * @ORM\Table(name="conferences")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConferenceRepository")
 */
class Conference
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
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start", type="datetime")
     *
     * @Assert\GreaterThan("+0 hours")
     */
    private $start;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end", type="datetime")
     *
     * @Assert\GreaterThan("+0 hours")
     */
    private $end;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=10000)
     *
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=0)
     *
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(0)
     */
    private $price;

    /**
     * @ORM\ManyToMany(targetEntity="Address", inversedBy="conferences")
     * @ORM\JoinTable(name="conferences_addresses")
     */
    private $addresses;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="ownerConferences")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    private $owner;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="adminsConferences")
     */
    private $admins;

    /**
     * @ORM\ManyToMany(targetEntity="Hall", inversedBy="conferences")
     * @ORM\JoinTable(name="conferences_halls")
     */
    private $halls;

    /**
     * @ORM\OneToMany(targetEntity="ProgramPoint", mappedBy="conference")
     */
    private $programPoints;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="speakerConferences")
     */
    private $speakers;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="audienceConference")
     */
    private $audience;

    /**
     * @ORM\OneToMany(targetEntity="Invitation", mappedBy="conference")
     */
    private $invitations;

    public function __construct()
    {
        $this->programPoints = new ArrayCollection();
        $this->invitations = new ArrayCollection();
        $this->speakers = new ArrayCollection();
        $this->audience = new ArrayCollection();
        $this->halls = new ArrayCollection();
        $this->addresses = new ArrayCollection();
        $this->admins = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Conference
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set start
     *
     * @param \DateTime $start
     *
     * @return Conference
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     *
     * @return Conference
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Conference
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Conference
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @param mixed $addresses
     */
    public function setAddresses($addresses)
    {
        $this->addresses = $addresses;
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return mixed
     */
    public function getAdmins()
    {
        return $this->admins;
    }

    /**
     * @param mixed $admins
     */
    public function setAdmins($admins)
    {
        $this->admins = $admins;
    }

    /**
     * @return mixed
     */
    public function getHalls()
    {
        return $this->halls;
    }

    /**
     * @param mixed $halls
     */
    public function setHalls($halls)
    {
        $this->halls = $halls;
    }

    /**
     * @return mixed
     */
    public function getProgramPoints()
    {
        return $this->programPoints;
    }

    /**
     * @param mixed $programPoints
     */
    public function setProgramPoints($programPoints)
    {
        $this->programPoints[] = $programPoints;
    }

    /**
     * @return mixed
     */
    public function getSpeakers()
    {
        return $this->speakers;
    }

    /**
     * @param mixed $speakers
     */
    public function setSpeakers($speakers)
    {
        $this->speakers[] = $speakers;
    }

    /**
     * @return mixed
     */
    public function getAudience()
    {
        return $this->audience;
    }

    /**
     * @param mixed $audience
     */
    public function setAudience($audience)
    {
        $this->audience[] = $audience;
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

    public function __toString()
    {
        return $this->name;
    }
}

