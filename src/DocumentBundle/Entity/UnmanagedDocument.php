<?php

namespace DocumentBundle\Entity;

use DocumentBundle\Entity\Document as BaseDocument;
use Symfony\Component\Filesystem\Filesystem;

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
