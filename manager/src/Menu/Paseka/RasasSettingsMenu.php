<?php

declare(strict_types=1);

namespace App\Menu\Paseka;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class RasasSettingsMenu
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
                ->addChild('Общие--', [
                    'route' => 'paseka.rasas.rasa.settings',
                    'routeParameters' => ['rasa_id' => $options['rasa_id']]
                ])
                ->setExtra('routes', [
                    ['route' => 'paseka.rasas.rasa.settings'],
                    ['route' => 'paseka.rasas.rasa.settings.edit'],
                ])
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');

            $menu
                ->addChild('Линия - Номер', [
                    'route' => 'paseka.rasas.rasa.settings.linias',
                    'routeParameters' => ['rasa_id' => $options['rasa_id']]
                ])
                ->setExtra('routes', [
                    ['route' => 'paseka.rasas.rasa.settings.linias'],
                    ['pattern' => '/^paseka.rasas.rasa.settings.linias\..+/']
                ])
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');

            // $menu
            // ->addChild('Участники', [
            //     'route' => 'work.projects.project.settings.members',
            //     'routeParameters' => ['project_id' => $options['project_id']]
            // ])
            // ->setExtra('routes', [
            //     ['route' => 'work.projects.project.settings.members'],
            //     ['pattern' => '/^work.projects.project.settings.members\..+/']
            // ])
            // ->setAttribute('class', 'nav-item')
            // ->setLinkAttribute('class', 'nav-link');

        }

        return $menu;
    }
}
