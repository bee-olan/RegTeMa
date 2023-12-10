<?php

declare(strict_types=1);

namespace App\Menu\Adminka\DrevMatkas;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class DrevMatkaMenu
{
    private $factory;
    private $auth;

    public function __construct(FactoryInterface $factory, AuthorizationCheckerInterface $auth)
    {
        $this->factory = $factory;
        $this->auth = $auth;
    }

    public function build(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root')
            ->setChildrenAttributes(['class' => 'nav nav-tabs mb-4']);

//        if ($this->auth->isGranted('ROLE_ADMINKA_MANAGE_PLEMMATKAS')) {
            $menu
                ->addChild('Редактирование - Настройки', [
                    'route' => 'adminka.matkas.plemmatka.redaktors',
                    'routeParameters' => ['plemmatka_id' => $options['plemmatka_id']]
                ])
                ->setExtra('routes', [
                    ['route' => 'adminka.matkas.plemmatka.redaktors'],
                    ['pattern' => '/^adminka.matkas.plemmatka.redaktors\..+/']
                ])
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');
//        }

//        $menu
//            ->addChild('Добавить ДочьМатку', [
//                'route' => 'adminka.matkas.plemmatka.show',
//                'routeParameters' => ['id' => $options['plemmatka_id']]
//            ])
//            ->setExtra('routes', [
//                ['route' => 'adminka.matkas.plemmatka.show'],
//                ['pattern' => '/^adminka.matkas.plemmatka.show\..+/']
//            ])
//            ->setAttribute('class', 'nav-item')
//            ->setLinkAttribute('class', 'nav-link');

//        $menu
//            ->addChild('Раса-Линия_Номер', ['route' => 'adminka.matkas.rasas'])
//            ->setExtra('routes', [
//                ['route' => 'adminka.matkas.rasas'],
//                ['pattern' => '/^adminka.matkas.rasas\..+/']
//            ])
//            ->setAttribute('class', 'nav-item')
//            ->setLinkAttribute('class', 'nav-link');
//
//        $menu
//            ->addChild('Actions', [
//                'route' => 'adminka.matkas.plemmatka.actions',
//                'routeParameters' => ['plemmatka_id' => $options['plemmatka_id']]
//            ])
//            ->setAttribute('class', 'nav-item')
//            ->setLinkAttribute('class', 'nav-link');

//        $menu
//            ->addChild(' Список ДочьМаток этой племМ', [
//                'route' => 'adminka.matkas.plemmatka.childmatkas',
//                'routeParameters' => ['plemmatka_id' => $options['plemmatka_id']]
//            ])
//            ->setExtra('routes', [
//                ['route' => 'adminka.matkas.plemmatka.childmatkas'],
//                ['pattern' => '/^adminka.matkas.plemmatka.childmatkas\..+/']
//            ])
//            ->setAttribute('class', 'nav-item')
//            ->setLinkAttribute('class', 'nav-link');

//        $menu
//            ->addChild('Calendar', [
//                'route' => 'adminka.matkas.plemmatka.calendar',
//                'routeParameters' => ['plemmatka_id' => $options['plemmatka_id']]
//            ])
//            ->setAttribute('class', 'nav-item')
//            ->setLinkAttribute('class', 'nav-link');



        return $menu;
    }
}