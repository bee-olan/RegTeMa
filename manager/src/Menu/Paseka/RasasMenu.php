<?php

declare(strict_types=1);

namespace App\Menu\Paseka;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class RasasMenu
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
            ->addChild('Dashboard---------', [
                'route' => 'paseka.rasas.rasa.show',
                'routeParameters' => ['id' => $options['rasa_id']]
            ])
            ->setExtra('routes', [
                ['route' => 'paseka.rasas.rasa.show'],
                ['pattern' => '/^paseka.rasas.rasa.show\..+/']
            ])
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');

        if ($this->auth->isGranted('ROLE_WORK_MANAGE_PROJECTS')) {
            $menu
                ->addChild('Настройки=======', [
                    'route' => 'paseka.rasas.rasa.settings',
                    'routeParameters' => ['rasa_id' => $options['rasa_id']]
                ])
                ->setExtra('routes', [
                    ['route' => 'paseka.rasas.rasa.settings'],
                    ['pattern' => '/^paseka.rasas.rasa.settings\..+/']
                ])
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');
        }

        return $menu;
    }
}
