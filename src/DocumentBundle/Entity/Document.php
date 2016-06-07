<?php

namespace DocumentBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

abstract class Document
{

    /**
     * @var string
     */
    protected $path;

    /**
     * @Assert\File(maxSize="6000000")
     *
     * @var File
     */
    protected $file = null;

    /**
     * Get absolutePath
     *
     * @return string
     */
    public function getAbsolutePath()
    {
        return null === $this->getPath() ? null : $this->getUploadRootDir() . '/' . $this->getPath();
    }

    /**
     * Get webPath
     *
     * @return string
     */
    public function getWebPath()
    {
        return null === $this->getPath() ? null : '/' . $this->getUploadDir() . '/' . $this->getPath();
    }

    /**
     * Get uploadRootDir.
     *
     * The absolute directory path where uploaded
     * documents should be saved.
     *
     * @return string
     */
    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    /**
     * Get uploadDir
     *
     * @return string
     */
    abstract protected function getUploadDir();

    /**
     * Sets file
     *
     * @param File $file File
     *
     * @return Document
     */
    public function setFile(File $file = null)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set path
     *
     * @param string $path Path
     *
     * @return Document
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Upload file
     *
     * @return Document
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return $this;
        }

        $this->getFile()->move($this->getUploadRootDir(), $this->getPath());
        $this->setFile(null);

        return $this;
    }

}
