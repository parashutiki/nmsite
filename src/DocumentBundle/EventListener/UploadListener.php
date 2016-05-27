<?php

namespace DocumentBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;
use Oneup\UploaderBundle\Event\PostPersistEvent;
use Symfony\Component\Filesystem\Filesystem;
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

        $fs = new Filesystem();

        $unmanagedDocument = new UnmanagedDocument();
        $unmanagedDocument->path = $qquuid;
        $uploadDir = $unmanagedDocument->getAbsolutePath();

        try {
            if (!$fs->exists($uploadDir)) {
                $fs->mkdir($uploadDir);
            }
        } catch (IOExceptionInterface $e) {
            echo 'An error occurred while creating your directory at ' . $e->getPath();
        }

        /* @var $file Symfony\Component\HttpFoundation\File\File */
        $file = $event->getFile();

        $file->move($uploadDir);
    }

}
