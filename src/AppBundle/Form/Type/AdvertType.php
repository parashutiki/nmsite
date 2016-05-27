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
                ))
                ->add('price', MoneyType::class, array(
                    'label' => 'advert.price.label',
                    'currency' => 'UAH',
                    'scale' => 0,
                    'required' => true,
                    'translation_domain' => 'form',
                ))
                ->add('description', TextareaType::class)
                ->add('rentType', ChoiceType::class, array(
                    'choices' => $advert->choicesRentType(),
                    'placeholder' => 'form.select',
                    'required' => true,
                    'label' => 'advert.rentType.label',
                    'translation_domain' => 'form',
                ))
                ->add('rooms', ChoiceType::class, array(
                    'choices' => $advert->choicesRooms(),
                    'placeholder' => 'form.select',
                    'required' => true,
                    'label' => 'advert.rooms.label',
                    'translation_domain' => 'form',
                ))
                ->add('square', NumberType::class)
                ->add('address', TextType::class)
                ->add('coordsLat', HiddenType::class)
                ->add('coordsLong', HiddenType::class)
                ->add('floor', ChoiceType::class, array(
                    'choices' => $advert->choicesFloor(),
                    'placeholder' => 'form.select',
                    'required' => true,
                    'label' => 'advert.floor.label',
                    'translation_domain' => 'form',
                ))
                ->add('totalFloor', ChoiceType::class, array(
                    'choices' => $advert->choicesTotalFloor(),
                    'placeholder' => 'form.select',
                    'required' => true,
                    'label' => 'advert.totalFloor.label',
                    'translation_domain' => 'form',
                ))
                ->add('documents', CollectionType::class, array(
                    'entry_type' => AdvertDocumentType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
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
