<?php

// src/AppBundle/Menu/MenuBuilders.php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

class MenuBuilder
{

    protected $securityContext;
    protected $factory;

    public function __construct(SecurityContextInterface $securityContext, FactoryInterface $factory)
    {
        $this->securityContext = $securityContext;
        $this->factory = $factory;
    }

    public function createMainMenu()
    {

        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');

        $menu->addChild('Home', array('route' => 'homepage'));

        if ($this->securityContext->isGranted('ROLE_ADMIN')) {
            $menu->addChild('Advert', array('route' => 'advert_index'));
        }

        if ($this->securityContext->isGranted('ROLE_PROFILE_VIEW')) {
            $menu->addChild('Profile', array('route' => 'fos_user_profile_show'));
        } else {
            $menu->addChild('Sign in', array('route' => 'fos_user_security_login'));
        }

        return $menu;
    }

}
