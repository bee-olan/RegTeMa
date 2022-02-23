<?php

declare(strict_types=1);

namespace App\Menu\Matkis;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class MatkaMenu
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
                'route' => 'matkis.matka.rasas.show',
                'routeParameters' => ['id' => $options['rasa_id']]
            ])
            ->setExtra('routes', [
                ['route' => 'matkis.matka.rasas.show'],
                ['pattern' => '/^matkis.matka.rasas.show\..+/']
            ])
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');

        if ($this->auth->isGranted('ROLE_WORK_MANAGE_PROJECTS')) {
            $menu
                ->addChild('Настройки', [
                    'route' => 'matkis.matka.rasas.settings',
                    'routeParameters' => ['rasa_id' => $options['rasa_id']]
                ])
                ->setExtra('routes', [
                    ['route' => 'matkis.matka.rasas.settings'],
                    ['pattern' => '/^wmatkis.matka.rasas.settings\..+/']
                ])
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');
        }

        return $menu;
    }
}
