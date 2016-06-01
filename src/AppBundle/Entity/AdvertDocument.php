<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DocumentBundle\Entity\Document as BaseDocument;
use AppBundle\Entity\Advert;

/**
 * @ORM\Entity
 * @ORM\Table(name="advert_document")
 * @ORM\HasLifecycleCallbacks()
 */
class AdvertDocument extends BaseDocument
{

    /**
     * Types.
     */
    const TYPE_UNMANAGED = 'unmanaged';
    const TYPE_DOCUMENT = 'document';

    /**
     * Type
     * @var string
     */
    public $type;

    /**
     * Unique id.
     * @var string
     */
    public $uuid;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Advert", inversedBy="advert_document")
     * @ORM\JoinColumn(name="advert_id", referencedColumnName="id")
     */
    protected $advert;

    /**
     * Set advert
     * @param Advert $advert
     */
    public function setAdvert(Advert $advert)
    {
        $this->advert = $advert;
    }

    /**
     * Get advert
     * @return Advert
     */
    public function getAdvert()
    {
        return $this->advert;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->setPath($this->uuid);
    }

    /**
     * Set path
     * @param string $uuid
     */
    public function setPath($uuid)
    {
        $this->path = $uuid;
    }

    /**
     * Implements method {@link Document::getUploadDir}
     *
     * @return string
     */
    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/document/advert';
    }

}
