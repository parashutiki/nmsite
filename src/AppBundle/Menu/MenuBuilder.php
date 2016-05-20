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
        $menu->addChild('menu.main.home', array('route' => 'homepage'))
                ->setExtra('translation_domain', 'menu');
        if ($this->securityContext->isGranted('ROLE_ADVERT_INDEX')) {
            $menu->addChild('menu.main.advert_list', array('route' => 'advert_index'))
                    ->setExtra('translation_domain', 'menu');
        }
        if ($this->securityContext->isGranted('ROLE_USER_INDEX')) {
            $menu->addChild('menu.main.user_list', array('route' => 'user_index'))
                    ->setExtra('translation_domain', 'menu');
        }

        return $menu;
    }

    public function createUserMenu()
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');
        if ($this->securityContext->isGranted('ROLE_PROFILE_VIEW')) {
            $menu->addChild('menu.user.profile', array('route' => 'fos_user_profile_show'))
                    ->setExtra('translation_domain', 'menu');
        } else {
            $menu->addChild('menu.user.login', array('route' => 'fos_user_security_login'))
                    ->setExtra('translation_domain', 'menu');
        }

        return $menu;
    }

}
