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
            ->setChildrenAttributes(['class' => 'nav nav-tabs mb-4']);

        $menu
            ->addChild('Место', ['route' => 'app.proekts.mestos.okrugs'])
            ->setExtra('routes', [
                ['route' => 'app.proekts.mestos'],
                ['pattern' => '/^app.proekts.mestos\..+/']
            ])
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');

        $menu
            ->addChild('Персональный  номер', ['route' => 'app.proekts.personaa.diapazon'])
            ->setExtra('routes', [
                ['route' => 'app.proekts.personaa'],
                ['pattern' => '/^app.proekts.personaa\..+/']
            ])
            ->setAttribute('class', 'nav-item ')
            ->setLinkAttribute('class', 'nav-link ');

//        $menu
//            ->addChild('Список ПлемМаток', ['route' => 'app.proekts'])
//            ->setExtra('routes', [
//                ['route' => 'drevos.rodos'],
//                ['pattern' => '/^drevos.rodos\..+/']
//            ])
//            ->setAttribute('class', 'nav-item ')
//            ->setLinkAttribute('class', 'nav-link ');


        return $menu;
    }

}