<?php

namespace DocumentBundle\Entity;

use DocumentBundle\Entity\Document as BaseDocument;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

class UnmanagedDocument extends BaseDocument
{

    /**
     * Unique id.
     * @var string
     */
    public $uuid = null;

    /**
     * Implements method {@link Document::getUploadDir}
     *
     * @return string
     */
    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/unmanaged';
    }

    /**
     * Get path
     *
     * Specific, because we need to use filename without extension for get file path.
     *
     * @return string
     */
    public function getPath()
    {
        if (null === $this->uuid || null !== $this->path) {
            return $this->path;
        }

        $this->path = '.';
        $h = opendir($this->getAbsolutePath());
        while (false !== ($entry = readdir($h))) {
            if (preg_match('/^' . $this->uuid . '\./', $entry)) {
                $this->path = $entry;
            }
        }

        if ('.' == $this->path) {
            $this->path = null;
        }

        return $this->path;
    }

    /**
     * Get file
     *
     * @return File
     */
    public function getFile()
    {
        if (null === $this->uuid || null !== $this->file) {
            return $this->file;
        }

        $this->file = new File($this->getAbsolutePath());

        return $this->file;
    }

    /**
     * Get formated file for FineUploader initialFiles.
     * @return type
     */
    public function getFineUploaderInitialFileFormat()
    {
        $file = array(
            'uuid' => $this->uuid,
            'name' => $this->uuid,
            'size' => $this->getFile()->getSize(),
            'thumbnailUrl' => $this->getWebPath(),
        );

        return (object) $file;
    }

    /**
     * Delete
     *
     * @return boolean Status
     */
    public function delete()
    {
        if (null === $this->getPath()) {
            return FALSE;
        }
        $fs = new Filesystem();
        $fs->remove($this->getUploadDir() . '/' . $this->getPath());
        return TRUE;
    }

}
