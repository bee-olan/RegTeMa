<?php

declare(strict_types=1);

namespace App\Menu\Adminka;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class MainMenu
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
            ->setChildrenAttributes(['class' => 'nav nav-tabs mb-4']);

        $menu
            ->addChild('Матки main', ['route' => 'adminka.matkas'])
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');
        
//        $menu
//            ->addChild('Actions', ['route' => 'adminka.matkas.actions'])
//            ->setAttribute('class', 'nav-item')
//            ->setLinkAttribute('class', 'nav-link');
//
//        $menu
//            ->addChild('Tasks', ['route' => 'adminka.matkas.tasks'])
//            ->setExtra('routes', [
//                ['route' => 'adminka.matkas.tasks'],
//                ['pattern' => '/^adminka.matkas.tasks\..+/']
//            ])
//            ->setAttribute('class', 'nav-item')
//            ->setLinkAttribute('class', 'nav-link');
//
//        $menu
//            ->addChild('Calendar', ['route' => 'adminka.matkas.calendar'])
//            ->setAttribute('class', 'nav-item')
//            ->setLinkAttribute('class', 'nav-link');
    
//        if ($this->auth->isGranted('ROLE_WORK_MANAGE_PROJECTS')) {
//            $menu
//                ->addChild('Roles', ['route' => 'adminka.matkas.roles'])
//                ->setExtra('routes', [
//                    ['route' => 'adminka.matkas.roles'],
//                    ['pattern' => '/^adminka.matkas.roles\..+/']
//                ])
//                ->setAttribute('class', 'nav-item')
//                ->setLinkAttribute('class', 'nav-link');
//        }

        return $menu;
    }
}
