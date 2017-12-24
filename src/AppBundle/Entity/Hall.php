<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hall
 *
 * @ORM\Table(name="halls")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HallRepository")
 */
class Hall
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
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Address", inversedBy="halls")
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id")
     */
    private $address;

    /**
     * @var int
     *
     * @ORM\Column(name="seatsCount", type="integer")
     */
    private $seatsCount;

    /**
     * @var int
     *
     * @ORM\Column(name="pricePerDay", type="decimal")
     */
    private $pricePerDay;

    /**
     * @ORM\ManyToOne(targetEntity="Conference", inversedBy="halls")
     * @ORM\JoinColumn(name="conference_id", referencedColumnName="id")
     */
    private $conference;

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
     * @return Hall
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
     * Set address
     *
     * @param string $address
     *
     * @return Hall
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set seatsCount
     *
     * @param integer $seatsCount
     *
     * @return Hall
     */
    public function setSeatsCount($seatsCount)
    {
        $this->seatsCount = $seatsCount;

        return $this;
    }

    /**
     * Get seatsCount
     *
     * @return int
     */
    public function getSeatsCount()
    {
        return $this->seatsCount;
    }

    /**
     * @return int
     */
    public function getPricePerDay(): int
    {
        return $this->pricePerDay;
    }

    /**
     * @param int $pricePerDay
     */
    public function setPricePerDay(int $pricePerDay)
    {
        $this->pricePerDay = $pricePerDay;
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
}

