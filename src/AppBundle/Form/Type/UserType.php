<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\User;

class UserType extends AbstractType
{

    /**
     * Overrides method {@link AbstractType::buildForm()}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('username', TextType::class)
                ->add('email', EmailType::class)
                ->add('enabled', CheckboxType::class)
                ->add('roles', ChoiceType::class, array(
                    'choices' => User::choicesRoles(),
                    'multiple' => true,
        ));
    }

    /**
     * Overrides method {@link AbstractType::configureOptions()}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

}
