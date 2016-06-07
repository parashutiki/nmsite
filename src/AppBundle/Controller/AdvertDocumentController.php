<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\AdvertDocument;

/**
 * Unmanaged document controller.
 *
 * @Route("/advertDocument")
 */
class AdvertDocumentController extends Controller
{

    /**
     * Delete
     *
     * @Route("/delete/{id}", name="advertDocument_delete", defaults={"id": null} )
     * @Method("DELETE")
     * @Security("(has_role('ROLE_ADVERT_EDIT') && advertDocument.isAuthor(user)) || has_role('ROLE_ADVERT_ADMIN')")
     */
    public function deleteAction(AdvertDocument $advertDocument = null)
    {
        $em = $this->getDoctrine()->getManager();
        $status = $em->remove($advertDocument);
        $em->flush();

        return new JsonResponse($status);
    }

}
