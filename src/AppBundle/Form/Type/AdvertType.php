<?php

// src/AppBundle/Form/Type/AdvertType.php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvertType extends AbstractType
{

    /**
     * Overrides method {@link AbstractType::buildForm()}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name', TextType::class)
                ->add('price', MoneyType::class)
                ->add('description', TextareaType::class)
                ->add('rentType')
                ->add('rooms')
                ->add('square')
                ->add('address')
                ->add('coordsLat', HiddenType::class)
                ->add('coordsLong', HiddenType::class)
                ->add('floor')
                ->add('totalFloor')
                ->add('photos');
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
