<?php

namespace DocumentBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DocumentBundle\Entity\UnmanagedDocument;

/**
 * Document controller.
 *
 * @Route("/document")
 */
class DocumentController extends Controller
{

    /**
     * Delete unmanaged document.
     *
     * @Route("/delete/{uuid}", name="document_delete")
     *
     * @Method("DELETE")
     */
    public function deleteAction($uuid = '')
    {
        $unmanagedDocument = new UnmanagedDocument();
        $unmanagedDocument->path = $uuid;
        $unmanagedDocument->removeUploadDir();

        return new JsonResponse(true);
    }

}
