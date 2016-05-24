<?php

// src/AppBundle/Entity/Advert.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="advert")
 * @ORM\HasLifecycleCallbacks()
 */
class Advert
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=127, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $price;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private $description;

    /**
     * @ORM\Column(type="smallint", name="rent_type", nullable=false)
     */
    private $rentType;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $rooms;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2, nullable=false)
     */
    private $square;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $address;

    /**
     * @ORM\Column(type="decimal", name="coords_lat", precision=10, scale=6, nullable=false)
     */
    private $coordsLat;

    /**
     * @ORM\Column(type="decimal", name="coords_longs", precision=10, scale=6, nullable=false)
     */
    private $coordsLong;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $floor;

    /**
     * @ORM\Column(type="smallint", name="total_floor", nullable=false)
     */
    private $totalFloor;

    /**
     * @ORM\Column(type="datetime", name="created_at", nullable=false)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", name="updated_at", nullable=false)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", nullable=false, referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\Column(type="array", nullable=false)
     */
    private $photos;

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
     * Set name
     *
     * @param string $name
     *
     * @return Advert
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
     * Set price
     *
     * @param integer $price
     *
     * @return Advert
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Advert
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
     * Set rentType
     *
     * @param integer $rentType
     *
     * @return Advert
     */
    public function setRentType($rentType)
    {
        $this->rentType = $rentType;

        return $this;
    }

    /**
     * Get rentType
     *
     * @return integer
     */
    public function getRentType()
    {
        return $this->rentType;
    }

    /**
     * Options rentType
     *
     * @return array
     */
    public function choicesRentType()
    {
        $options = [
            'advert.rentType.option.hourly',
            'advert.rentType.option.daily',
            'advert.rentType.option.long-term',
        ];
        return array_combine($options, $options);
    }

    /**
     * Set rooms
     *
     * @param integer $rooms
     *
     * @return Advert
     */
    public function setRooms($rooms)
    {
        $this->rooms = $rooms;

        return $this;
    }

    /**
     * Get rooms
     *
     * @return integer
     */
    public function getRooms()
    {
        return $this->rooms;
    }

    /**
     * Set square
     *
     * @param string $square
     *
     * @return Advert
     */
    public function setSquare($square)
    {
        $this->square = $square;

        return $this;
    }

    /**
     * Get square
     *
     * @return string
     */
    public function getSquare()
    {
        return $this->square;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Advert
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
     * Set coordsLat
     *
     * @param string $coordsLat
     *
     * @return Advert
     */
    public function setCoordsLat($coordsLat)
    {
        $this->coordsLat = $coordsLat;

        return $this;
    }

    /**
     * Get coordsLat
     *
     * @return string
     */
    public function getCoordsLat()
    {
        return $this->coordsLat;
    }

    /**
     * Set coordsLong
     *
     * @param string $coordsLong
     *
     * @return Advert
     */
    public function setCoordsLong($coordsLong)
    {
        $this->coordsLong = $coordsLong;

        return $this;
    }

    /**
     * Get coordsLong
     *
     * @return string
     */
    public function getCoordsLong()
    {
        return $this->coordsLong;
    }

    /**
     * Set floor
     *
     * @param integer $floor
     *
     * @return Advert
     */
    public function setFloor($floor)
    {
        $this->floor = $floor;

        return $this;
    }

    /**
     * Get floor
     *
     * @return integer
     */
    public function getFloor()
    {
        return $this->floor;
    }

    /**
     * Set totalFloor
     *
     * @param integer $totalFloor
     *
     * @return Advert
     */
    public function setTotalFloor($totalFloor)
    {
        $this->totalFloor = $totalFloor;

        return $this;
    }

    /**
     * Get totalFloor
     *
     * @return integer
     */
    public function getTotalFloor()
    {
        return $this->totalFloor;
    }

    /**
     * Set createdAt
     *
     * @ORM\PrePersist
     */
    public function setCreatedAt()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @ORM\PreUpdate
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set photos
     *
     * @param array $photos
     *
     * @return Advert
     */
    public function setPhotos($photos)
    {
        $this->photos = $photos;

        return $this;
    }

    /**
     * Get photos
     *
     * @return array
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Advert
     */
    public function setUser(\AppBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

}
