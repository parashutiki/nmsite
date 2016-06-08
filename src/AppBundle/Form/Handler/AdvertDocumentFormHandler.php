<?php

namespace AppBundle\Form\Handler;

use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Filesystem\Filesystem;
use AppBundle\Entity\AdvertDocument;

class AdvertDocumentFormHandler
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
     * Advert.
     * @var AdvertDocument
     */
    private $advertDocument;

    /**
     * Constructor.
     * @param Form $form
     * @param RequestStack $requestStack
     * @param EntityManager $em
     * @param AuthorizationChecker $authorizationChecker
     * @param TokenStorage $tokenStorage
     */
    public function __construct(Form $form, RequestStack $requestStack, EntityManager $em, AuthorizationChecker $authorizationChecker)
    {
        $this->form = $form;
        $this->requestStack = $requestStack;
        $this->em = $em;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * Process forms.
     *
     * @return boolean Status
     */
    public function process()
    {
        $this->form->handleRequest($this->requestStack->getCurrentRequest());

        if ($this->requestStack->getCurrentRequest()->getMethod() == 'DELETE') {
            return $this->processRemove();
        }

        return false;
    }

    /**
     * Process remove.
     *
     * @return boolean Status
     */
    private function processRemove()
    {
        $id = $this->requestStack->getCurrentRequest()->get('id');
        if (empty($id)) {
            return false;
        }
        $this->advertDocument = $this->em->getRepository('AppBundle:AdvertDocument')->find($id);
        if (empty($this->advertDocument)) {
            return false;
        }

        $this->em->remove($this->advertDocument);
        $this->em->flush();

        return true;
    }

}
