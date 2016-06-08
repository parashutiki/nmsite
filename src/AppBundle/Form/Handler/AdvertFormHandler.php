<?php

namespace AppBundle\Form\Handler;

use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RequestStack;
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
     * Request stack.
     * @var RequestStack
     */
    private $requestStack;

    /**
     * Entity Manager.
     * @var EntityManager
     */
    private $em;

    /**
     * @var AuthorizationChecker
     */
    private $authorizationChecker;

    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * Advert.
     * @var Advert
     */
    private $advert;

    /**
     * Constructor.
     * @param Form $form
     * @param RequestStack $requestStack
     * @param EntityManager $em
     * @param AuthorizationChecker $authorizationChecker
     * @param TokenStorage $tokenStorage
     */
    public function __construct(Form $form, RequestStack $requestStack, EntityManager $em, AuthorizationChecker $authorizationChecker, TokenStorage $tokenStorage)
    {
        $this->form = $form;
        $this->requestStack = $requestStack;
        $this->em = $em;
        $this->authorizationChecker = $authorizationChecker;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Process forms.
     *
     * @return boolean Status
     */
    public function process()
    {
        $this->form->handleRequest($this->requestStack->getCurrentRequest());

        if ($this->requestStack->getCurrentRequest()->getMethod() == 'POST') {
            return $this->processNew();
        } elseif ($this->requestStack->getCurrentRequest()->getMethod() == 'PUT') {
            return $this->processEdit();
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

        if (!$this->authorizationChecker->isGranted('ROLE_USER')) {
            $this->em->persist($this->advert->getUser());
        } else {
            $this->advert->setUser($this->tokenStorage->getToken()->getUser());
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

    /**
     * Process edit.
     *
     * @return boolean Status
     */
    private function processEdit()
    {
        if (!$this->form->isSubmitted() || !$this->form->isValid()) {
            return false;
        }
    }

}
