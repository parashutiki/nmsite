<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileType extends AbstractType
{

    /**
     * Authorization Checker
     *
     * @var AuthorizationChecker
     */
    private $authorizationChecker;

    /**
     * Constructor.
     *
     * @param AuthorizationChecker $authorizationChecker Authorization Checker
     */
    public function __construct(AuthorizationChecker $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (false === $this->authorizationChecker->isGranted('ROLE_USER_ADMIN')) {
            $builder->get('username')->setDisabled(true);
            $builder->get('email')->setDisabled(true);
        }
        $builder
                ->add('name')
                ->add('phone');
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_profile';
    }

}
