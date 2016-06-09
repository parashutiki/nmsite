<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;
use DocumentBundle\Form\Type\UnmanagedDocumentType;
use FOS\UserBundle\Form\Type\RegistrationFormType;
use AppBundle\Entity\Advert;
use AppBundle\Form\Type\AdvertDocumentType;

/**
 * Advert type.
 */
class AdvertType extends AbstractType
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

    /**
     * Overrides method {@link AbstractType::buildForm()}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ('DELETE' == $options['method']) {
            $builder
                    ->setMethod('DELETE');
            return;
        }
        $builder
                ->add('name', TextType::class, array(
                    'label' => 'advert.name.label',
                    'required' => true,
                    'translation_domain' => 'form',
//                    'data' => 'TEST TITLE',
                ))
                ->add('price', MoneyType::class, array(
                    'label' => 'advert.price.label',
                    'currency' => 'UAH',
                    'scale' => 0,
                    'required' => true,
                    'translation_domain' => 'form',
//                    'data' => '100',
                ))
                ->add('description', TextareaType::class, array(
                    'label' => 'advert.description.label',
                    'translation_domain' => 'form',
//                    'data' => 'TEST DESCRIPTION',
                ))
                ->add('rentType', ChoiceType::class, array(
                    'choices' => Advert::choicesRentType(),
                    'placeholder' => 'form.select',
                    'required' => true,
                    'label' => 'advert.rentType.label',
                    'translation_domain' => 'form',
//                    'data' => '1',
                ))
                ->add('rooms', ChoiceType::class, array(
                    'choices' => Advert::choicesRooms(),
                    'placeholder' => 'form.select',
                    'required' => true,
                    'label' => 'advert.rooms.label',
                    'translation_domain' => 'form',
//                    'data' => '2',
                ))
                ->add('square', NumberType::class, array(
                    'label' => 'advert.square.label',
                    'translation_domain' => 'form',
//                    'data' => '100',
                ))
                ->add('address', TextType::class, array(
                    'label' => 'advert.address.label',
                    'translation_domain' => 'form',
//                    'data' => 'TEST ADDRESS',
                ))
                ->add('coordsLat', HiddenType::class, array(
                    'label' => false,
//                    'data' => '100',
                ))
                ->add('coordsLong', HiddenType::class, array(
                    'label' => false,
//                    'data' => '100',
                ))
                ->add('floor', ChoiceType::class, array(
                    'choices' => Advert::choicesFloor(),
                    'placeholder' => 'form.select',
                    'required' => true,
                    'label' => 'advert.floor.label',
                    'translation_domain' => 'form',
//                    'data' => '1',
                ))
                ->add('totalFloor', ChoiceType::class, array(
                    'choices' => Advert::choicesTotalFloor(),
                    'placeholder' => 'form.select',
                    'required' => true,
                    'label' => 'advert.totalFloor.label',
                    'translation_domain' => 'form',
//                    'data' => '1',
                ))
                ->add('unmanagedDocuments', CollectionType::class, array(
                    'label' => 'advert.unmanagedDocuments.label',
                    'translation_domain' => 'form',
                    'entry_type' => UnmanagedDocumentType::class,
                    'prototype' => false,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
        ));
        if ('PUT' == $options['method']) {
            $builder->add('advertDocuments', CollectionType::class, array(
                'label' => false,
                'entry_type' => AdvertDocumentType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ));
        }
        if (false === $this->authorizationChecker->isGranted('ROLE_USER')) {
            $builder->add('user', RegistrationFormType::class, array(
                'constraints' => array(
                    new Valid(),
                ),
            ));
        }
    }

    /**
     * Overrides method {@link AbstractType::configureOptions()}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Advert',
            'validation_groups' => array('registration'),
        ));
    }

}
