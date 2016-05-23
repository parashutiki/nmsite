<?php

namespace AppBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;
use Oneup\UploaderBundle\Event\PostPersistEvent;

class UploadListener
{

    /**
     * @var ObjectManager
     */
    private $om;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function onUpload(PostPersistEvent $event)
    {
        $response = $event->getResponse();

        /** @var FileInterface $file */
        $file = $event->getFile();
        if ($file) {
            $response['file'] = $file->getBasename();
        } else {
            throw new UploadException('File is absent on server.');
        }
    }

}
