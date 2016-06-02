<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use DocumentBundle\Form\Type\UnmanagedDocumentType;

class AdvertType extends AbstractType
{

    /**
     * Overrides method {@link AbstractType::buildForm()}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @var $advert Advert */
        $advert = $options['data'];
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
                    'choices' => $advert->choicesRentType(),
                    'placeholder' => 'form.select',
                    'required' => true,
                    'label' => 'advert.rentType.label',
                    'translation_domain' => 'form',
                    'data' => 'advert.rentType.option.hourly',
                ))
                ->add('rooms', ChoiceType::class, array(
                    'choices' => $advert->choicesRooms(),
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
                    'choices' => $advert->choicesFloor(),
                    'placeholder' => 'form.select',
                    'required' => true,
                    'label' => 'advert.floor.label',
                    'translation_domain' => 'form',
                    'data' => '1',
                ))
                ->add('totalFloor', ChoiceType::class, array(
                    'choices' => $advert->choicesTotalFloor(),
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
    }

    /**
     * Overrides method {@link AbstractType::configureOptions()}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Advert'
        ));
    }

}
