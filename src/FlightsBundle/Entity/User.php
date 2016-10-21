<?php

namespace FlightsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Flights", mappedBy="user")
     */
    private $flights;

    public function __construct()
    {
        parent::__construct();
        $this->flights = new ArrayCollection();

    }

    /**
     * Add flights
     *
     * @param \FlightsBundle\Entity\Flights $flights
     * @return User
     */
    public function addFlight(\FlightsBundle\Entity\Flights $flights)
    {
        $this->flights[] = $flights;

        return $this;
    }

    /**
     * Remove flights
     *
     * @param \FlightsBundle\Entity\Flights $flights
     */
    public function removeFlight(\FlightsBundle\Entity\Flights $flights)
    {
        $this->flights->removeElement($flights);
    }

    /**
     * Get flights
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFlights()
    {
        return $this->flights;
    }
}
