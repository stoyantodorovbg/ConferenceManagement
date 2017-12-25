<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Address
 *
 * @ORM\Table(name="addresses")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AddressRepository")
 */
class Address
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
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=255)
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="town", type="string", length=255)
     */
    private $town;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255)
     */
    private $street;

    /**
     * @var int
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @ORM\OneToMany(targetEntity="Hall", mappedBy="address")
     */
    private $halls;

    /**
     * @ORM\ManyToMany(targetEntity="Conference", mappedBy="addresses")
     */
    private $conferences;

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
     * Set country
     *
     * @param string $country
     *
     * @return Address
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set region
     *
     * @param string $region
     *
     * @return Address
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set town
     *
     * @param string $town
     *
     * @return Address
     */
    public function setTown($town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * Get town
     *
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Set street
     *
     * @param string $street
     *
     * @return Address
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set number
     *
     * @param integer $number
     *
     * @return Address
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
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
    public function getConferences()
    {
        return $this->conferences;
    }

    /**
     * @param mixed $conferences
     */
    public function setConferences($conferences)
    {
        $this->conferences = $conferences;
    }

    public function __toString()
    {
        return $this->country.', '.$this->getTown().', '.$this->street.', '.$this->number;
    }
}

