<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DocumentBundle\Entity\Document as BaseDocument;
use AppBundle\Entity\Advert;
use Symfony\Component\Filesystem\Filesystem;
use DocumentBundle\Entity\UnmanagedDocument;

/**
 * @ORM\Entity
 * @ORM\Table(name="advert_document")
 * @ORM\HasLifecycleCallbacks()
 */
class AdvertDocument extends BaseDocument
{

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Advert", inversedBy="advert_document")
     * @ORM\JoinColumn(name="advert_id", referencedColumnName="id")
     */
    protected $advert;

    /**
     * Unmanaged document
     * @var UnmanagedDocument
     */
    private $unmanagedDocument;

    /**
     * Set advert
     *
     * @param Advert $advert Advert
     *
     * @return AdvertDocument
     */
    public function setAdvert(Advert $advert)
    {
        $this->advert = $advert;

        return $this;
    }

    /**
     * Get advert
     *
     * @return Advert
     */
    public function getAdvert()
    {
        return $this->advert;
    }

    /**
     * Set unmanagedDocument
     *
     * @param UnmanagedDocument $unmanagedDocument Unmanaged document
     *
     * @return AdvertDocument
     */
    public function setUnmanagedDocument(UnmanagedDocument $unmanagedDocument)
    {
        $this->unmanagedDocument = $unmanagedDocument;

        return $this;
    }

    /**
     * Get unmanagedDocument
     *
     * @return UnmanagedDocument
     */
    public function getUnmanagedDocument()
    {
        return $this->unmanagedDocument;
    }

    /**
     * Move unmanagedDocument
     *
     * @param UnmanagedDocument $unmanagedDocument Unmanaged document
     *
     * @return boolean Status
     */
    public function move()
    {
        if (null === $this->getUnmanagedDocument()) {
            return FALSE;
        }

        $fs = new Filesystem();
        $this->path = $this->unmanagedDocument->getPath();
        $fs->rename($this->unmanagedDocument->getAbsolutePath(), $this->getAbsolutePath());
        $this->unmanagedDocument->setPath(null);

        return TRUE;
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
