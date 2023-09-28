<?php

declare(strict_types=1);

namespace App\Menu\Proekts;

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
            ->addChild('Матка', ['route' => 'app.proekts.pasekas.matkas.plemmatkas.creates'])
            ->setExtra('routes', [
                ['route' => 'app.proekts.pasekas.matkas.plemmatkas'],
                ['pattern' => '/^app.proekts.pasekas.matkas.plemmatkas\..+/']
            ])
            ->setAttribute('class', 'nav_pro-item')
            ->setLinkAttribute('class', 'nav_pro-link');

        $menu
            ->addChild('Раса', ['route' => 'app.proekts.pasekas.rasas.plemmatka'])
            ->setExtra('routes', [
                ['route' => 'app.proekts.pasekas.rasas'],
                ['pattern' => '/^app.proekts.pasekas.rasas\..+/']
            ])
            ->setAttribute('class', 'nav_pro-item ')
            ->setLinkAttribute('class', 'nav_pro-link ');

        $menu
            ->addChild('Родословная', ['route' => 'app.proekts.drevo-rods.dre-rasa'])
            ->setExtra('routes', [
                ['route' => 'app.proekts.drevo-rods.dre-rasa'],
                ['pattern' => '/^app.proekts.drevo-rods.dre-rasa\..+/']
            ])
            ->setAttribute('class', 'nav_pro-item ')
            ->setLinkAttribute('class', 'nav_pro-link ');
//
//        $menu
//            ->addChild('Участие', ['route' => 'app.proekts.pasekas.uchasties.uchastiee'])
//            ->setExtra('routes', [
//                ['route' => 'app.proekts.pasekas.uchasties.uchastiee'],
//                ['pattern' => '/^app.proekts.pasekas.uchasties.uchastiee\..+/']
//            ])
//            ->setAttribute('class', 'nav_pro-item ')
//            ->setLinkAttribute('class', 'nav_pro-link ');
//
//        $menu
//            ->addChild('Список участников', ['route' => 'app.proekts.pasekas.uchasties.spisok'])
//            ->setExtra('routes', [
//                ['route' => 'app.proekts.pasekas.uchasties.spisok'],
//                ['pattern' => '/^app.proekts.pasekas.uchasties.spisok\..+/']
//            ])
//            ->setAttribute('class', 'nav_pro-item ')
//            ->setLinkAttribute('class', 'nav_pro-link ');
//
//        $menu
//            ->addChild('Группы', ['route' => 'app.proekts.pasekas.uchasties.groupas'])
//            ->setExtra('routes', [
//                ['route' => 'app.proekts.pasekas.uchasties.groupas'],
//                ['pattern' => '/^app.proekts.pasekas.uchasties.groupas\..+/']
//            ])
//            ->setAttribute('class', 'nav_pro-item ')
//            ->setLinkAttribute('class', 'nav_pro-link ');

        return $menu;
    }

}