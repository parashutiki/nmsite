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
     * @ORM\Column(type="string", length=9, nullable=false)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=127, nullable=false)
     */
    private $name;

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

    /**
     * Set phone
     *
     * @param string $phone Phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = (string) $phone;

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
     * Set name
     *
     * @param string $name Name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = (string) $name;

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
     * Options roles
     * @return array
     */
    public static function choicesRoles()
    {
        $options = [
            'ROLE_SUPER_ADMIN',
            'ROLE_CLIENT',
        ];

        return array_combine($options, $options);
    }

}
