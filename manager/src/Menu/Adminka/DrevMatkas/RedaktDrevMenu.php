<?php

declare(strict_types=1);

namespace App\Menu\Adminka\DrevMatkas;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class RedaktDrevMenu
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
                    'route' => 'adminka.drevmatkas.drevmatka.redaktors',
                    'routeParameters' => ['plemmatka_id' => $options['plemmatka_id']]
                ])
                ->setExtra('routes', [
                    ['route' => 'adminka.drevmatkas.drevmatka.redaktors'],
                    ['route' => 'adminka.drevmatkas.drevmatka.redaktors.edit'],
                ])
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');

            $menu
                ->addChild('Сезоны', [
                    'route' => 'adminka.drevmatkas.drevmatka.redaktors.sezondrevs',
                    'routeParameters' => ['plemmatka_id' => $options['plemmatka_id']]
                ])
                ->setExtra('routes', [
                    ['route' => 'adminka.drevmatkas.drevmatka.redaktors.sezondrevs'],
                    ['pattern' => '/^adminka.drevmatkas.drevmatka.redaktors.sezondrevs\..+/']
                ])
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');

            $menu
                ->addChild('Участник!!!', [
                    'route' => 'adminka.drevmatkas.drevmatka.redaktors.uchasties',
                    'routeParameters' => ['plemmatka_id' => $options['plemmatka_id']]
                ])
                ->setExtra('routes', [
                    ['route' => 'adminka.drevmatkas.drevmatka.redaktors.uchasties'],
                    ['pattern' => '/^adminka.drevmatkas.drevmatka.redaktors.uchasties\..+/']
                ])
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');

        }

        return $menu;
    }
}
