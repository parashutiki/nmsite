<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Security\Core\SecurityContext;
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
use DocumentBundle\Form\Type\UnmanagedDocumentType;
use FOS\UserBundle\Form\Type\RegistrationFormType;
use AppBundle\Entity\Advert;

/**
 * Advert type.
 */
class AdvertType extends AbstractType
{

    /**
     * Security Context
     *
     * @var SecurityContext
     */
    private $context;

    /**
     * Constructor.
     *
     * @param SecurityContext $context Context
     */
    public function __construct(SecurityContext $context)
    {
        $this->context = $context;
    }

    /**
     * Overrides method {@link AbstractType::buildForm()}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name', TextType::class, array(
                    'label' => 'advert.name.label',
                    'required' => true,
                    'translation_domain' => 'form',
                    'data' => 'TEST TITLE',
                ))
                ->add('price', MoneyType::class, array(
                    'label' => 'advert.price.label',
                    'currency' => 'UAH',
                    'scale' => 0,
                    'required' => true,
                    'translation_domain' => 'form',
                    'data' => '100',
                ))
                ->add('description', TextareaType::class, array(
                    'data' => 'TEST DESCRIPTION',
                ))
                ->add('rentType', ChoiceType::class, array(
                    'choices' => Advert::choicesRentType(),
                    'placeholder' => 'form.select',
                    'required' => true,
                    'label' => 'advert.rentType.label',
                    'translation_domain' => 'form',
                    'data' => 'advert.rentType.option.hourly',
                ))
                ->add('rooms', ChoiceType::class, array(
                    'choices' => Advert::choicesRooms(),
                    'placeholder' => 'form.select',
                    'required' => true,
                    'label' => 'advert.rooms.label',
                    'translation_domain' => 'form',
                    'data' => '2',
                ))
                ->add('square', NumberType::class, array(
                    'data' => '100',
                ))
                ->add('address', TextType::class, array(
                    'data' => 'TEST ADDRESS',
                ))
                ->add('coordsLat', HiddenType::class, array(
                    'data' => '100',
                ))
                ->add('coordsLong', HiddenType::class, array(
                    'data' => '100',
                ))
                ->add('floor', ChoiceType::class, array(
                    'choices' => Advert::choicesFloor(),
                    'placeholder' => 'form.select',
                    'required' => true,
                    'label' => 'advert.floor.label',
                    'translation_domain' => 'form',
                    'data' => '1',
                ))
                ->add('totalFloor', ChoiceType::class, array(
                    'choices' => Advert::choicesTotalFloor(),
                    'placeholder' => 'form.select',
                    'required' => true,
                    'label' => 'advert.totalFloor.label',
                    'translation_domain' => 'form',
                    'data' => '1',
                ))
                ->add('unmanagedDocuments', CollectionType::class, array(
                    'entry_type' => UnmanagedDocumentType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
        ));
        if (false === $this->context->isGranted('ROLE_USER')) {
            $builder->add('user', RegistrationFormType::class);
        }
    }

    /**
     * Overrides method {@link AbstractType::configureOptions()}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Advert',
            'cascade_validation' => true,
            'validation_groups' => array('registration'),
        ));
    }

    public function getName()
    {
        return 'advert_type';
    }

}
