<?php

namespace DocumentBundle\Entity;

use DocumentBundle\Entity\Document as BaseDocument;

class UnmanagedDocument extends BaseDocument
{

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

}
