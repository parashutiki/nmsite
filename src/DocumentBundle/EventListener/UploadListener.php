<?php

namespace DocumentBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;
use Oneup\UploaderBundle\Event\PostPersistEvent;
use Symfony\Component\HttpFoundation\File\File;
use DocumentBundle\Entity\UnmanagedDocument;

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
        $request = $event->getRequest();
        $qquuid = $request->request->get('qquuid');

        /* @var $file File */
        $file = $event->getFile();

        $unmanagedDocument = new UnmanagedDocument();
        $unmanagedDocument
                ->setFile($file)
                ->setPath($qquuid . '.' . $file->getExtension())
                ->upload();
    }

}
