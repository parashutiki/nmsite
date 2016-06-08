<?php

namespace AppBundle\Entity;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @UniqueEntity(fields={"email"}, groups={"registration", "profile", "advert_type"})
 * @UniqueEntity(fields={"username"}, groups={"registration", "profile", "advert_type"})
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
     * @ORM\OneToMany (targetEntity="Advert", mappedBy="user")
     */
    private $adverts;

    /**
     * Set adverts
     *
     * @param ArrayCollection $adverts Adverts
     *
     * @return User
     */
    public function setAdverts(ArrayCollection $adverts)
    {
        $this->adverts = $adverts;

        return $this;
    }

    /**
     * Get adverts
     *
     * @return ArrayCollection
     */
    public function getAdverts()
    {
        return $this->adverts;
    }

}
