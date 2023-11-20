<?php

declare(strict_types=1);

namespace App\Menu\Proekts;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


class DreRodoMenu
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
            ->setChildrenAttributes(['class' => 'nav_pro nav_pro-tabs mb-4']);

        $menu
            ->addChild('Главная', ['route' => 'app.proekts.basepro'])
            ->setExtra('routes', [
                ['route' => 'app.proekts.basepro'],
                ['pattern' => '/^app.proekts.basepro\..+/']
            ])
            ->setAttribute('class', 'nav_pro-item')
            ->setLinkAttribute('class', 'nav_pro-link');

        $menu
            ->addChild('Родословная', ['route' => 'app.proekts.drevorods.rodras'])
            ->setExtra('routes', [
                ['route' => 'app.proekts.drevorods'],
                ['pattern' => '/^app.proekts.drevorods\..+/']
            ])
            ->setAttribute('class', 'nav_pro-item')
            ->setLinkAttribute('class', 'nav_pro-link');

        $menu
            ->addChild('ЭлитМатки', ['route' => 'app.proekts.pasekas.drevmatkas.drevcreates'])
            ->setExtra('routes', [
                ['route' => 'app.proekts.pasekas.drevmatkas.drevcreates'],
                ['pattern' => '/^app.proekts.pasekas.drevmatkas.drevcreates\..+/']
            ])
            ->setAttribute('class', 'nav_pro-item')
            ->setLinkAttribute('class', 'nav_pro-link');

        return $menu;

    }

}