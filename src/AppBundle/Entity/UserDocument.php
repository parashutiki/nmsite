<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DocumentBundle\Entity\Document as BaseDocument;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_document")
 * @ORM\HasLifecycleCallbacks()
 */
class UserDocument extends BaseDocument
{

    /**
     * Unique id.
     * @ORM\Id
     * @ORM\Column(type="string", length=36, nullable=false)
     * @var string
     */
    public $uuid = null;

    /**
     * @ORM\Column(type="string", length=4, nullable=false)
     * @var string
     */
    public $ext;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User", inversedBy="user_document")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    public $user;

    /**
     * Implements method {@link Document::getUploadDir}
     *
     * @return string
     */
    protected function getUploadDir()
    {
        return 'uploads/document/user';
    }

}
