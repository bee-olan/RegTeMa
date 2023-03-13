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
//            ->setExtra('icon', 'nav-icon icon-briefcase')
            ->setExtra('image', '../assets/images/uchastie.jpg')
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

        $menu->addChild('Сезоны (добавить)', ['route' => 'adminka.sezons.godas'])
            ->setExtra('routes', [
                ['route' => 'adminka.sezons.godas'],
                ['pattern' => '/^adminka\.sezons.godas\..+/']
            ])
            ->setExtra('icon', 'nav-icon icon-briefcase')
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');
            
        $menu->addChild('Админка')->setAttribute('class', 'nav-title')
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link')
            ;
        if ($this->auth->isGranted('ROLE_ADMINKA_MANAGE_UCHASTIES')) {


            $menu->addChild('Участники!!!!', ['route' => 'adminka.uchasties'])
                ->setExtra('routes', [
                    ['route' => 'adminka.uchasties'],
                    ['pattern' => '/^adminka\.uchasties\..+/']
                ])
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');
        }

        $menu->addChild('Матки', ['route' => 'adminka.matkas'])
            ->setExtra('routes', [
                ['route' => 'adminka.matkas'],
                ['pattern' => '/^adminka\.matkas\..+/']
            ])
            ->setExtra('icon', 'nav-icon icon-briefcase')
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');


        $menu
            ->addChild('Раса-Линия_Номер', ['route' => 'adminka.rasas'])
            ->setExtra('routes', [
                ['route' => 'adminka.matkas.rasas'],
                ['pattern' => '/^adminka.matkas.rasas\..+/']
            ])
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');





        $menu->addChild('Р а б о т а')->setAttribute('class', 'nav-title');



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
