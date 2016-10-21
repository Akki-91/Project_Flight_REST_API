<?php

namespace FlightsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Flights
 *
 * @ORM\Table(name="flights")
 * @ORM\Entity(repositoryClass="FlightsBundle\Repository\FlightsRepository")
 */
class Flights
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
     * @ORM\Column(name="destination", type="string", length=255)
     */
    private $destination;

    /**
     * @var string
     *
     * @ORM\Column(name="fromLocation", type="string", length=255)
     */
    private $fromLocation;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=255)
     */
    private $currency;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="string", length=255)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="href", type="string", length=255)
     */
    private $href;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="flights")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set destination
     *
     * @param string $destination
     * @return Flights
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * Get destination
     *
     * @return string 
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * Set fromLocation
     *
     * @param string $fromLocation
     * @return Flights
     */
    public function setFromLocation($fromLocation)
    {
        $this->fromLocation = $fromLocation;

        return $this;
    }

    /**
     * Get fromLocation
     *
     * @return string 
     */
    public function getFromLocation()
    {
        return $this->fromLocation;
    }

    /**
     * Set currency
     *
     * @param string $currency
     * @return Flights
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string 
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Flights
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
     * Set href
     *
     * @param string $href
     * @return Flights
     */
    public function setHref($href)
    {
        $this->href = $href;

        return $this;
    }

    /**
     * Get href
     *
     * @return string 
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * Set user
     *
     * @param \FlightsBundle\Entity\User $user
     * @return Flights
     */
    public function setUser(\FlightsBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \FlightsBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
