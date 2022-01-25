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
        $menu->addChild('Меню', ['route' => 'home'])
            ->setExtra('icon', 'nav-icon icon-speedometer')
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');

        $menu->addChild('Работа')->setAttribute('class', 'nav-title');

			$menu->addChild('Projects', ['route' => 'work.projects'])
				->setExtra('routes', [
					['route' => 'work.projects'],
					['pattern' => '/^work\.projects\..+/']
				])
				->setExtra('icon', 'nav-icon icon-briefcase')
				->setAttribute('class', 'nav-item')
				->setLinkAttribute('class', 'nav-link');

        if ($this->auth->isGranted('ROLE_WORK_MANAGE_MEMBERS')) {
            $menu->addChild('Участники', ['route' => 'work.members'])
                ->setExtra('routes', [
                    ['route' => 'work.members'],
                    ['pattern' => '/^work\.members\..+/']
                ])

							->setExtra('image',  'immmg')
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');

			$menu['Участники']->addChild('Contacts',  ['route' => 'work.members']);
        }

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
