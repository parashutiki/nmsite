<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\AdvertDocument;
use AppBundle\Form\Handler\AdvertDocumentFormHandler;

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
     * @Security("(has_role('ROLE_ADVERT_EDIT_OWN') && advertDocument.isAuthor(user)) || has_role('ROLE_ADVERT_EDIT')")
     */
    public function deleteAction(AdvertDocument $advertDocument)
    {
        /* @var $formHandler AdvertDocumentFormHandler */
        $formHandler = $this->container->get('app.form.advertdocument.delete.handler');

        return new JsonResponse($formHandler->process());
    }

}
