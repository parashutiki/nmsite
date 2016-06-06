<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Advert;
use AppBundle\Form\Type\AdvertType;
use AppBundle\Form\Handler\AdvertFormHandler;

/**
 * Advert controller.
 *
 * @Route("/advert")
 */
class AdvertController extends Controller
{

    /**
     * Lists all Advert entities.
     *
     * @Route("/", name="advert_index")
     *
     * @Method("GET")
     * @Security("has_role('ROLE_ADVERT_INDEX')")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $adverts = $em->getRepository('AppBundle:Advert')->findAllOrdered();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($adverts, $request->query->getInt('page', 1), 6);

        return $this->render('advert/index.html.twig', array('pagination' => $pagination));
    }

    /**
     * Creates a new Advert entity.
     *
     * @Route("/new", name="advert_new")
     * @Method({"GET", "POST"})
     */
    public function newAction()
    {
        /* @var $form Form */
        $form = $this->container->get('app.form.advert.new');
        /* @var $formHandler AdvertFormHandler */
        $formHandler = $this->container->get('app.form.advert.new.handler');

        if ($formHandler->process()) {
            $advert = $form->getData();
            return $this->redirectToRoute('advert_show', array(
                        'id' => $advert->getId(),
            ));
        }

        return $this->render('advert/new.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Advert entity.
     *
     * @Route("/{id}", name="advert_show")
     * @Method("GET")
     * @Security("has_role('ROLE_ADVERT_SHOW')")
     */
    public function showAction(Advert $advert)
    {
        $deleteForm = $this->createDeleteForm($advert);

        return $this->render('advert/show.html.twig', array(
                    'advert' => $advert,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Advert entity.
     *
     * @Route("/{id}/edit", name="advert_edit")
     * @Method({"GET", "PUT"})
     * @Security("(has_role('ROLE_ADVERT_EDIT') && advert.isAuthor(user)) || has_role('ROLE_ADVERT_ADMIN')")
     */
    public function editAction(Advert $advert)
    {
        /* @var $form Form */
        $form = $this->container->get('app.form.advert.edit');
        $form->setData($advert);
        /* @var $formHandler AdvertFormHandler */
        $formHandler = $this->container->get('app.form.advert.edit.handler');

        $deleteForm = $this->createDeleteForm($advert);

        if ($formHandler->process()) {
            $advert = $form->getData();
            return $this->redirectToRoute('advert_show', array(
                        'id' => $advert->getId(),
            ));
        }

        return $this->render('advert/edit.html.twig', array(
                    'form' => $form->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Advert entity.
     *
     * @Route("/{id}", name="advert_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADVERT_DELETE')")
     */
    public function deleteAction(Request $request, Advert $advert)
    {
        $form = $this->createDeleteForm($advert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($advert);
            $em->flush();
        }

        return $this->redirectToRoute('advert_index');
    }

    /**
     * Creates a form to delete a Advert entity.
     *
     * @param Advert $advert The Advert entity
     *
     * @return Form Form
     */
    private function createDeleteForm(Advert $advert)
    {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('advert_delete', array('id' => $advert->getId())))
                        ->setMethod('DELETE')
                        ->getForm();
    }

}
