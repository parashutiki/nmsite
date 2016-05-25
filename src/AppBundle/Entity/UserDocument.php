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
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/documents/user';
    }

}
