<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class MenuBuilder
{

    /**
     * @var AuthorizationChecker
     */
    private $authorizationChecker;

    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * Constructor.
     * @param AuthorizationChecker $authorizationChecker
     * @param FactoryInterface $factory
     */
    public function __construct(AuthorizationChecker $authorizationChecker, FactoryInterface $factory)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->factory = $factory;
    }

    /**
     * Main menu builder.
     * @return ItemInterface
     */
    public function createMainMenu()
    {
        $menu = $this->factory->createItem('menu.main.home', array('route' => 'homepage'));
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        if ($this->authorizationChecker->isGranted('ROLE_ADVERT')) {
            if ($this->authorizationChecker->isGranted('ROLE_ADVERT_INDEX')) {
                $menuAdvert = $menu->addChild('menu.main.advert.list', array('route' => 'advert_index'))
                        ->setAttributes(array(
                            'dropdown' => true,
                            'icon' => 'glyphicon glyphicon-list-alt',
                        ))
                        ->setExtra('translation_domain', 'menu');
            } else {
                $menuAdvert = $menu->addChild('menu.main.advert.list_own', array('route' => 'advert_index_own'))
                        ->setAttributes(array(
                            'dropdown' => true,
                            'icon' => 'glyphicon glyphicon-list-alt',
                        ))
                        ->setExtra('translation_domain', 'menu');
            }

            if ($this->authorizationChecker->isGranted('ROLE_ADVERT_INDEX')) {
                $menuAdvert->addChild('menu.main.advert.list', array('route' => 'advert_index'))
                        ->setExtra('translation_domain', 'menu');
            } else {
                $menuAdvert->addChild('menu.main.advert.list_own', array('route' => 'advert_index_own'))
                        ->setExtra('translation_domain', 'menu');
            }

            if ($this->authorizationChecker->isGranted('ROLE_ADVERT_NEW')) {
                $menuAdvert->addChild('menu.main.advert.new', array('route' => 'advert_new'))
                        ->setExtra('translation_domain', 'menu');
            }
        }

        if ($this->authorizationChecker->isGranted('ROLE_USER_INDEX')) {
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

    /**
     * User menu builder.
     * @return ItemInterface
     */
    public function createUserMenu()
    {
        $menu = $this->factory->createItem('menu.user');
        $menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');
        if ($this->authorizationChecker->isGranted('ROLE_PROFILE_VIEW')) {
            $menu->addChild('menu.user.profile', array('route' => 'fos_user_profile_show'))
                    ->setExtra('translation_domain', 'menu')
                    ->setAttributes(array(
                        'dropdown' => true,
                        'icon' => 'glyphicon glyphicon-user',
                    ))
                    ->addChild('menu.user.profile', array('route' => 'fos_user_profile_show'))
                    ->setExtra('translation_domain', 'menu')
                    ->setAttributes(array(
                        'icon' => 'glyphicon glyphicon-user',
                    ))
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
