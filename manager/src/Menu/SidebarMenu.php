<?php

declare(strict_types=1);

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class SidebarMenu
{
    private $factory;
    private $auth;

    public function __construct(FactoryInterface $factory, AuthorizationCheckerInterface $auth)
    {
        $this->factory = $factory;
        $this->auth = $auth;
    }

    public function build(): ItemInterface
    {
        $menu = $this->factory->createItem('root')
            ->setChildrenAttributes(['class' => 'nav']);
        $menu->addChild('М е н ю', ['route' => 'home'])
            ->setExtra('icon', 'nav-icon icon-speedometer')
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');

        $menu->addChild('Проект', ['route' => 'proekt'])
            ->setExtra('routes', [
                ['route' => 'proekt'],
                ['pattern' => '/^proekt\..+/']
            ])
            ->setExtra('icon', 'nav-icon icon-briefcase')
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');


        $menu->addChild('Место', ['route' => 'mesto.okrug'])
            ->setExtra('routes', [
                ['route' => 'mesto.okrug'],
                ['pattern' => '/^mesto\.okrug\..+/']
            ])
            ->setExtra('icon', 'nav-icon icon-briefcase')
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');
            
        $menu->addChild('П А С Е К А')->setAttribute('class', 'nav-title')
            ->setExtra('image', '../../assets/images/menu/mesto.png')
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link')
            ;
//        $menu->addChild('Добавить  уч-ка', ['route' => 'paseka.pchelowods'])
//            ->setExtra('routes', [
//                ['route' => 'paseka.pchelowods'],
//                ['pattern' => '/^paseka\.pchelowods\..+/']
//            ])
//            ->setExtra('icon', 'nav-icon icon-briefcase')
//            ->setAttribute('class', 'nav-item')
//            ->setLinkAttribute('class', 'nav-link');

//            $menu['Добавить  уч-ка']->addChild('Проба', ['route' => 'paseka.pchelowods']);

            // $menu->addChild('Добавить  расу', ['route' => 'paseka.rasas'])
            // ->setExtra('routes', [
            //     ['route' => 'paseka.rasas'],
            //     ['pattern' => '/^paseka\.rasas\..+/']
            // ])
            // ->setExtra('icon', 'nav-icon icon-briefcase')
            // ->setAttribute('class', 'nav-item')
            // ->setLinkAttribute('class', 'nav-link'); 

        // $menu->addChild('УЧАСТНИКИ')->setAttribute('class', 'nav-title')
        //     ->setExtra('image', '../../assets/images/menu/mesto.png')
        //     ->setAttribute('class', 'nav-item')
        //     ->setLinkAttribute('class', 'nav-link')
        //     ;
        // $menu->addChild('Добавить  уч-ка', ['route' => 'matkis.u4astniks'])
        //     ->setExtra('routes', [
        //         ['route' => 'matkis.u4astniks'],
        //         ['pattern' => '/^matkis\.u4astniks\..+/']
        //     ])
        //     ->setExtra('icon', 'nav-icon icon-briefcase')
        //     ->setAttribute('class', 'nav-item')
        //     ->setLinkAttribute('class', 'nav-link');        

        $menu->addChild('Р а б о т а')->setAttribute('class', 'nav-title');

			$menu->addChild('Projects', ['route' => 'work.projects'])
				->setExtra('routes', [
					['route' => 'work.projects'],
					['pattern' => '/^work\.projects\..+/']
				])
				->setExtra('icon', 'nav-icon icon-briefcase')
				->setAttribute('class', 'nav-item')
				->setLinkAttribute('class', 'nav-link');

//        if ($this->auth->isGranted('ROLE_WORK_MANAGE_MEMBERS')) {
            $menu->addChild('Участники', ['route' => 'work.members'])
                ->setExtra('routes', [
                    ['route' => 'work.members'],
                    ['pattern' => '/^work\.members\..+/']
                ])

				->setExtra('image',  'immmg')
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');

			$menu['Участники']->addChild('Contacts',  ['route' => 'work.members']);
//        }

        $menu->addChild('Control')->setAttribute('class', 'nav-title');

        if ($this->auth->isGranted('ROLE_MANAGE_USERS')) {
            $menu->addChild('Пользователи', ['route' => 'users'])
                ->setExtra('icon', 'nav-icon icon-people')
                ->setExtra('routes', [
                    ['route' => 'users'],
                    ['pattern' => '/^users\..+/']
                ])
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');
        }

        $menu->addChild('Профиль', ['route' => 'profile'])
            ->setExtra('icon', 'nav-icon icon-user')
            ->setExtra('routes', [
                ['route' => 'profile'],
                ['pattern' => '/^profile\..+/']
            ])
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');

        return $menu;
    }
}
