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

        $menu->addChild('Проект-сайт', ['route' => 'app.proekts.basepro'])
//        $menu->addChild('Проект-сайт', ['route' => 'proekt'])
            ->setExtra('routes', [
                ['route' => 'proekts'],
                ['pattern' => '/^proekts\..+/']
            ])
//            ->setExtra('icon', 'nav-icon icon-briefcase')
//            ->setExtra('image', '../assets/images/uchastie.jpg')
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

        $menu->addChild('Список заявок', ['route' => 'mesto.actions'])
            ->setExtra('routes', [
                ['route' => 'mesto.okrug'],
                ['pattern' => '/^mesto\.okrug\..+/']
            ])
            ->setExtra('icon', 'nav-icon icon-briefcase')
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');

        $menu->addChild('Сезоны (+)', ['route' => 'adminka.sezons.godas'])
            ->setExtra('routes', [
                ['route' => 'adminka.sezons.godas'],
                ['pattern' => '/^adminka\.sezons.godas\..+/']
            ])
            ->setExtra('icon', 'nav-icon icon-briefcase')
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');

        $menu->addChild('ДревМатки', ['route' => 'adminka.drevmatkas'])
            ->setExtra('routes', [
                ['route' => 'adminka.drevmatkas'],
                ['pattern' => '/^adminka\.drevmatkas\..+/']
            ])
            ->setExtra('icon', 'nav-icon icon-briefcase')
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');

        $menu
            ->addChild('Родословная', ['route' => 'drevos.rass'])
            ->setExtra('routes', [
                ['route' => 'drevos'],
                ['pattern' => '/^drevos\..+/']
            ])
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');
            
        $menu->addChild('Админка')->setAttribute('class', 'nav-title')
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link')
            ;
        if ($this->auth->isGranted('ROLE_ADMINKA_MANAGE_UCHASTIES')) {


            $menu->addChild('Участники!', ['route' => 'adminka.uchasties'])
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
            ->addChild('Раса-Лин-Вет-Ном-Now', ['route' => 'drevos.rass.indbr'])
            ->setExtra('routes', [
                ['route' => 'drevos.rass.linibrs'],
                ['pattern' => '/^drevos.rass.linibrs\..+/']
            ])
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');

        $menu
            ->addChild('Отцовская-Линия-Номер', ['route' => 'adminka.otec-for-ras'])
            ->setExtra('routes', [
                ['route' => 'adminka.matkas.otec-for-ras'],
                ['pattern' => '/^adminka.matkas.otec-for-ras\..+/']
            ])
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');

        $menu
            ->addChild('Схема Р-Л-В-Н', ['route' => 'adminka.rasas.info_rasa'])
            ->setExtra('routes', [
                ['route' => 'adminka.matkas.rasas.info_rasa'],
                ['pattern' => '/^adminka.matkas.rasas.info_rasa\..+/']
            ])
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');

        $menu->addChild('Зарегистрированы')
            ->setAttribute('class', 'nav-title')
            ->setLinkAttribute('class', 'nav-link')
        ;



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
