<?php

namespace AppBundle\Form\Handler;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Advert;
use AppBundle\Entity\AdvertDocument;

class AdvertFormHandler
{

    /**
     * Form
     * @var Form
     */
    private $form;

    /**
     * Request.
     * @var Request
     */
    private $request;

    /**
     * Entity Manager.
     * @var EntityManager
     */
    private $em;

    /**
     * Security Context
     *
     * @var SecurityContext
     */
    private $context;

    /**
     * Advert.
     * @var Advert
     */
    private $advert;

    /**
     * Constructor.
     *
     * @param Form $form Form
     * @param Request $request Request
     */
    public function __construct(Form $form, Request $request, EntityManager $em, SecurityContext $context, Advert $advert)
    {
        $this->form = $form;
        $this->request = $request;
        $this->em = $em;
        $this->context = $context;
        $this->advert = $advert;
    }

    /**
     * Process forms.
     *
     * @return boolean Status
     */
    public function process()
    {
        $this->form->handleRequest($this->request);

        if ($this->request->getMethod() == 'POST') {
            return $this->processNew();
        }

        return false;
    }

    /**
     * Process new.
     *
     * @return boolean Status
     */
    private function processNew()
    {
        if (!$this->form->isSubmitted() || !$this->form->isValid()) {
            return false;
        }

        $this->advert = $this->form->getData();

        if (!$this->context->isGranted('ROLE_USER')) {
            $this->em->persist($this->advert->getUser());
        } else {
            $this->advert->setUser($this->context->getToken()->getUser());
        }

        $this->em->persist($this->advert);

        foreach ($this->advert->getUnmanagedDocuments() as $unmanagedDocument) {
            /* @var $unmanagedDocument UnmanagedDocument */
            $advertDocument = new AdvertDocument();
            $advertDocument
                    ->setUnmanagedDocument($unmanagedDocument)
                    ->setAdvert($this->advert)
                    ->move();
            $unmanagedDocument = null;
            $this->em->persist($advertDocument);
        }
        $this->em->flush();

        return true;
    }

}
