<?php

declare(strict_types=1);

namespace App\Menu\Adminka\Matkas;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class CildMatkaPoiskMenu
{
    private $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function build(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root')
            ->setChildrenAttributes(['class' => 'nav nav-tabs mb-4']);

        if ($options['plemmatka_id']) {
            $params = array_replace_recursive($options['route_params'], ['plemmatka_id' => $options['plemmatka_id']]);
        } else {
            $params = $options['route_params'];
        }

        $route = $options['plemmatka_id'] ? 'adminka.matkas.plemmatka.childmatkas' : 'adminka.matkas.childmatkas';
        $menu
            ->addChild('Все дочернии', [
                'route' => $route,
                'routeParameters' => $params
            ])
            ->setExtra('routes', [['route' => $route]])
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');

        $route = $options['plemmatka_id'] ? 'adminka.matkas.plemmatka.childmatkas.me' : 'adminka.matkas.childmatkas.me';
        $menu
            ->addChild('Для меня For Me', [
                'route' => $route,
                'routeParameters' => array_replace_recursive($params, ['form' => ['executor' => null]]),
            ])
            ->setExtra('routes', [['route' => $route]])
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');

        $route = $options['plemmatka_id'] ? 'adminka.matkas.plemmatka.childmatkas.own' : 'adminka.matkas.childmatkas.own';
        $menu
            ->addChild('мой собственный  My Own', [
                'route' => $route,
                'routeParameters' => array_replace_recursive($params, ['form' => ['author' => null]]),
            ])
            ->setExtra('routes', [['route' => $route]])
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');

        return $menu;
    }
}