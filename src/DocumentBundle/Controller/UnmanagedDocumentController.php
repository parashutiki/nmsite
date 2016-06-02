<?php

namespace DocumentBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DocumentBundle\Entity\UnmanagedDocument;

/**
 * Unmanaged document controller.
 *
 * @Route("/unmanagedDocument")
 */
class UnmanagedDocumentController extends Controller
{

    /**
     * Delete
     *
     * @Route("/delete/{uuid}", name="unmanagedDocument_delete")
     *
     * @Method("DELETE")
     */
    public function deleteAction($uuid = '')
    {
        $unmanagedDocument = new UnmanagedDocument();
        $unmanagedDocument->uuid = $uuid;
        $status = $unmanagedDocument->delete();

        return new JsonResponse($status);
    }

}
