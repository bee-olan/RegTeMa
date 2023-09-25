<?php

declare(strict_types=1);

namespace App\Menu\Proekts;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ProektMenu
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
            ->addChild('Место', ['route' => 'app.proekts.mestos.okrugs'])
            ->setExtra('routes', [
                ['route' => 'app.proekts.mestos'],
                ['pattern' => '/^app.proekts.mestos\..+/']
            ])
            ->setAttribute('class', 'nav_pro-item')
            ->setLinkAttribute('class', 'nav_pro-link');

        $menu
            ->addChild('Персональный  номер', ['route' => 'app.proekts.personaa.diapazon'])
            ->setExtra('routes', [
                ['route' => 'app.proekts.personaa'],
                ['pattern' => '/^app.proekts.personaa\..+/']
            ])
            ->setAttribute('class', 'nav_pro-item ')
            ->setLinkAttribute('class', 'nav_pro-link ');

        $menu
            ->addChild('Участие', ['route' => 'app.proekts.pasekas.uchasties.uchastiee'])
            ->setExtra('routes', [
                ['route' => 'app.proekts.pasekas.uchasties.uchastiee'],
                ['pattern' => '/^app.proekts.pasekas.uchasties.uchastiee\..+/']
            ])
            ->setAttribute('class', 'nav_pro-item ')
            ->setLinkAttribute('class', 'nav_pro-link ');

        $menu
            ->addChild('Список участников', ['route' => 'app.proekts.pasekas.uchasties.spisok'])
            ->setExtra('routes', [
                ['route' => 'app.proekts.pasekas.uchasties.spisok'],
                ['pattern' => '/^app.proekts.pasekas.uchasties.spisok\..+/']
            ])
            ->setAttribute('class', 'nav_pro-item ')
            ->setLinkAttribute('class', 'nav_pro-link ');

        $menu
            ->addChild('Группы', ['route' => 'app.proekts.pasekas.uchasties.groupas'])
            ->setExtra('routes', [
                ['route' => 'app.proekts.pasekas.uchasties.groupas'],
                ['pattern' => '/^app.proekts.pasekas.uchasties.groupas\..+/']
            ])
            ->setAttribute('class', 'nav_pro-item ')
            ->setLinkAttribute('class', 'nav_pro-link ');

        return $menu;
    }

}