<?php

namespace AppBundle\Twig;

class AppExtension extends \Twig_Extension
{

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('form_row_small', null, array('node_class' => 'Symfony\Bridge\Twig\Node\SearchAndRenderBlockNode', 'is_safe' => array('html'))),
        );
    }

    public function getName()
    {
        return 'app_extension';
    }

}
