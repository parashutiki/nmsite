<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Advert;
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

        $adverts = $em->getRepository('AppBundle:Advert')->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($adverts, $request->query->getInt('page', 1), 6);

        return $this->render('advert/index.html.twig', array('pagination' => $pagination));
    }

    /**
     * Lists all Advert entities for owner.
     *
     * @Route("/own", name="advert_index_own")
     *
     * @Method("GET")
     * @Security("has_role('ROLE_ADVERT_INDEX_OWN')")
     */
    public function indexOwnAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $adverts = $em->getRepository('AppBundle:Advert')->findAllOwn($user);

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
     * @Route("/{id}", name="advert_show", requirements={"id": "\d+"})
     * @Method("GET")
     * @Security("has_role('ROLE_ADVERT_SHOW')")
     */
    public function showAction(Advert $advert)
    {
        $deleteForm = $this->container->get('app.form.advert.delete');

        return $this->render('advert/show.html.twig', array(
                    'advert' => $advert,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Advert entity.
     *
     * @Route("/{id}/edit", name="advert_edit", requirements={"id": "\d+"})
     * @Method({"GET", "PUT"})
     * @Security("(has_role('ROLE_ADVERT_EDIT_OWN') && advert.isAuthor(user)) || has_role('ROLE_ADVERT_EDIT')")
     */
    public function editAction(Advert $advert)
    {
        /* @var $form Form */
        $form = $this->container->get('app.form.advert.edit');
        $form->setData($advert);
        /* @var $formHandler AdvertFormHandler */
        $formHandler = $this->container->get('app.form.advert.edit.handler');

        $deleteForm = $this->container->get('app.form.advert.delete');

        if ($formHandler->process()) {
            $advert = $form->getData();
            return $this->redirectToRoute('advert_show', array(
                        'id' => $advert->getId(),
            ));
        }

        return $this->render('advert/edit.html.twig', array(
                    'advert' => $advert,
                    'form' => $form->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Advert entity.
     *
     * @Route("/{id}", name="advert_delete", requirements={"id": "\d+"})
     * @Method("DELETE")
     * @Security("(has_role('ROLE_ADVERT_DELETE_OWN') && advert.isAuthor(user)) || has_role('ROLE_ADVERT_DELETE')")
     */
    public function deleteAction(Request $request, Advert $advert)
    {
        /* @var $form Form */
        $form = $this->container->get('app.form.advert.delete');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($advert);
            $em->flush();
        }

        return $this->redirectToRoute('advert_index');
    }

}
