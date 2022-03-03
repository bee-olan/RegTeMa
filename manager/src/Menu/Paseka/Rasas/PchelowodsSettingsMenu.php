<?php

declare(strict_types=1);

namespace App\Menu\Paseka\Rasas;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class PasekaSettingsMenu
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

        if ($this->auth->isGranted('ROLE_WORK_MANAGE_PROJECTS')) {
            $menu
                ->addChild('Общие', [
                    'route' => 'paseka.pchelowods.pchelowod.settings',
                    'routeParameters' => ['pchelowod_id' => $options['pchelowod_id']]
                ])
                ->setExtra('routes', [
                    ['route' => 'paseka.pchelowods.pchelowod.settings'],
                    ['route' => 'paseka.pchelowods.pchelowod.settings.edit'],
                ])
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');

            $menu
                ->addChild('Линия - Номер', [
                    'route' => 'paseka.pchelowods.pchelowod.settings.linias',
                    'routeParameters' => ['pchelowod_id' => $options['pchelowod_id']]
                ])
                ->setExtra('routes', [
                    ['route' => 'paseka.pchelowods.pchelowod.settings.linias'],
                    ['pattern' => '/^paseka.pchelowods.pchelowod.settings.linias\..+/']
                ])
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');

            $menu
                ->addChild('Участники', [
                    'route' => 'paseka.rasas.rasa.settings.pchelowods',
                    'routeParameters' => ['rasa_id' => $options['rasa_id']]
                ])
                ->setExtra('routes', [
                    ['route' => 'paseka.rasas.rasa.settings.pchelowods'],
                    ['pattern' => '/^paseka.rasas.rasa.settings.pchelowods\..+/']
                ])
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');

        }

        return $menu;
    }
}
