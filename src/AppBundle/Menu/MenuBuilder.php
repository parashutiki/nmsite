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
        if ($this->securityContext->isGranted('ROLE_ADVERT_INDEX')) {
            $menu->addChild('menu.main.advert.list', array('route' => 'advert_index'))
                    ->setAttributes(array(
                        'dropdown' => true,
                        'icon' => 'glyphicon glyphicon-list-alt',
                    ))
                    ->setExtra('translation_domain', 'menu')
                    ->addChild('menu.main.advert.list', array('route' => 'advert_index'))
                    ->setExtra('translation_domain', 'menu')
                    ->getParent()
                    ->addChild('menu.main.advert.new', array('route' => 'advert_new'))
                    ->setExtra('translation_domain', 'menu');
        }
        if ($this->securityContext->isGranted('ROLE_USER_INDEX')) {
            $menu->addChild('menu.main.user.list', array('route' => 'user_index'))
                    ->setAttributes(array(
                        'dropdown' => true,
                        'icon' => 'glyphicon glyphicon-user',
                    ))
                    ->setExtra('translation_domain', 'menu')
                    ->addChild('menu.main.user.list', array('route' => 'user_index'))
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
                    ->setExtra('translation_domain', 'menu')
                    ->setAttributes(array(
                        'dropdown' => true,
                        'icon' => 'glyphicon glyphicon-user',
                    ))
                    ->addChild('menu.user.edit', array('route' => 'fos_user_profile_edit'))
                    ->setAttributes(array(
                        'icon' => 'glyphicon glyphicon-edit',
                    ))
                    ->setExtra('translation_domain', 'menu')
                    ->getParent()
                    ->addChild('menu.user.logout', array('route' => 'fos_user_security_logout'))
                    ->setAttributes(array(
                        'icon' => 'glyphicon glyphicon-log-out',
                    ))
                    ->setExtra('translation_domain', 'menu');
        } else {
            $menu->addChild('menu.user.login', array('route' => 'fos_user_security_login'))
                    ->setExtra('translation_domain', 'menu')
                    ->setAttribute('icon', 'glyphicon glyphicon-log-in');
        }

        return $menu;
    }

}
