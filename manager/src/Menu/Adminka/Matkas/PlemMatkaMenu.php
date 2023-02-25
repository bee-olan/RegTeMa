<?php

declare(strict_types=1);

namespace App\Menu\Adminka\Matkas;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class PlemMatkaMenu
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

        $menu
            ->addChild('Информация', [
                'route' => 'adminka.matkas.plemmatka.show',
                'routeParameters' => ['id' => $options['plemmatka_id']]
            ])
            ->setExtra('routes', [
                ['route' => 'adminka.matkas.plemmatka.show'],
                ['pattern' => '/^adminka.matkas.plemmatka.show\..+/']
            ])
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');
//
//        $menu
//            ->addChild('Actions', [
//                'route' => 'adminka.matkas.plemmatka.actions',
//                'routeParameters' => ['plemmatka_id' => $options['plemmatka_id']]
//            ])
//            ->setAttribute('class', 'nav-item')
//            ->setLinkAttribute('class', 'nav-link');

//        $menu
//            ->addChild('Задачи!!', [
//                'route' => 'adminka.matkas.plemmatka.tasks',
//                'routeParameters' => ['plemmatka_id' => $options['plemmatka_id']]
//            ])
//            ->setExtra('routes', [
//                ['route' => 'adminka.matkas.plemmatka.tasks'],
//                ['pattern' => '/^adminka.matkas.plemmatka.tasks\..+/']
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

//        if ($this->auth->isGranted('ROLE_WORK_MANAGE_PROJECTS')) {
//            $menu
//                ->addChild('Settings', [
//                    'route' => 'adminka.matkas.plemmatka.settings',
//                    'routeParameters' => ['plemmatka_id' => $options['plemmatka_id']]
//                ])
//                ->setExtra('routes', [
//                    ['route' => 'adminka.matkas.plemmatka.settings'],
//                    ['pattern' => '/^adminka.matkas.plemmatka.settings\..+/']
//                ])
//                ->setAttribute('class', 'nav-item')
//                ->setLinkAttribute('class', 'nav-link');
//        }

        return $menu;
    }
}