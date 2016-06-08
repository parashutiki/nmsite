<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DocumentBundle\Entity\Document as BaseDocument;
use AppBundle\Entity\Advert;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use DocumentBundle\Entity\UnmanagedDocument;
use AppBundle\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="advert_document")
 * @ORM\HasLifecycleCallbacks()
 */
class AdvertDocument extends BaseDocument
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
     * @ORM\ManyToOne(targetEntity="Advert", inversedBy="advertDocuments")
     * @ORM\JoinColumn(name="advert_id", referencedColumnName="id")
     */
    private $advert;

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
            return false;
        }

        $fs = new Filesystem();
        $this->setPath($this->unmanagedDocument->getPath());
        $fs->rename($this->unmanagedDocument->getAbsolutePath(), $this->getAbsolutePath());
        $this->unmanagedDocument->setPath(null);

        return true;
    }

    /**
     * Remove file.
     * @ORM\PreRemove
     */
    public function remove(){
        $fs = new Filesystem();
        $fs->remove($this->getFile());
    }

    /**
     * Implements method {@link Document::getUploadDir}
     *
     * @return string
     */
    protected function getUploadDir()
    {
        return 'uploads/document/advert';
    }

    /**
     * Gets path
     *
     * @return string
     */
    public function getPath()
    {
        if (null == $this->uuid || null == $this->ext) {
            return null;
        }
        return $this->uuid . '.' . $this->ext;
    }

    /**
     * Sets path
     * @param string $path
     */
    public function setPath($path)
    {
        $arrPath = explode('.', $path);
        $this->uuid = (string) $arrPath[0];
        $this->ext = (string) $arrPath[1];
    }

    /**
     * Get file
     *
     * @return File
     */
    public function getFile()
    {
        if (null !== $this->file) {
            return $this->file;
        }

        $this->file = new File($this->getAbsolutePath());

        return $this->file;
    }

    /**
     * Validate if user is owner.
     *
     * @param User $user
     * @return boolean
     */
    public function isAuthor(User $user)
    {
        return $user && $user->getId() == $this->getAdvert()->getUser()->getId();
    }

}
