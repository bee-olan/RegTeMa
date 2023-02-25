<?php

declare(strict_types=1);

namespace App\Menu\Adminka\Matkas;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class RedaktorsMenu
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

        if ($this->auth->isGranted('ROLE_ADMINKA_MANAGE_PLEMMATKAS')) {
            $menu
                ->addChild('Общие', [
                    'route' => 'adminka.matkas.plemmatka.redaktors',
                    'routeParameters' => ['plemmatka_id' => $options['plemmatka_id']]
                ])
                ->setExtra('routes', [
                    ['route' => 'adminka.matkas.plemmatka.redaktors'],
                    ['route' => 'adminka.matkas.plemmatka.redaktors.edit'],
                ])
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');

//            $menu
//                ->addChild('Отделы', [
//                    'route' => 'adminka.matkas.plemmatka.redaktors.departments',
//                    'routeParameters' => ['plemmatka_id' => $options['plemmatka_id']]
//                ])
//                ->setExtra('routes', [
//                    ['route' => 'adminka.matkas.plemmatka.redaktors.departments'],
//                    ['pattern' => '/^adminka.matkas.plemmatka.redaktors.departments\..+/']
//                ])
//                ->setAttribute('class', 'nav-item')
//                ->setLinkAttribute('class', 'nav-link');

//            $menu
//            ->addChild('Участники', [
//                'route' => 'adminka.matkas.plemmatka.redaktors.members',
//                'routeParameters' => ['plemmatka_id' => $options['plemmatka_id']]
//            ])
//            ->setExtra('routes', [
//                ['route' => 'adminka.matkas.plemmatka.redaktors.members'],
//                ['pattern' => '/^adminka.matkas.plemmatka.redaktors.members\..+/']
//            ])
//            ->setAttribute('class', 'nav-item')
//            ->setLinkAttribute('class', 'nav-link');
//
        }

        return $menu;
    }
}
