<?php

declare(strict_types=1);

namespace App\Menu\Paseka;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class PasekaMenu
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
            ->addChild('Dashboard', [
                'route' => 'paseka.pchelowods.pchelowod.show',
                'routeParameters' => ['id' => $options['pchelowod_id']]
            ])
            ->setExtra('routes', [
                ['route' => 'paseka.pchelowods.pchelowod.show'],
                ['pattern' => '/^paseka.pchelowods.pchelowod.show\..+/']
            ])
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');

        if ($this->auth->isGranted('ROLE_WORK_MANAGE_PROJECTS')) {
            $menu
                ->addChild('Настройки', [
                    'route' => 'paseka.pchelowods.pchelowod.settings',
                    'routeParameters' => ['pchelowod_id' => $options['pchelowod_id']]
                ])
                ->setExtra('routes', [
                    ['route' => 'paseka.pchelowods.pchelowod.settings'],
                    ['pattern' => '/^paseka.pchelowods.pchelowod.settings\..+/']
                ])
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');
        }

        return $menu;
    }
}
