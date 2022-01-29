<?php

declare(strict_types=1);

namespace App\Menu\Work;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ProjectSettingsMenu
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
                    'route' => 'work.projects.project.settings',
                    'routeParameters' => ['project_id' => $options['project_id']]
                ])
                ->setExtra('routes', [
                    ['route' => 'work.projects.project.settings'],
                    ['route' => 'work.projects.project.settings.edit'],
                ])
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');

            $menu
                ->addChild('Отделы', [
                    'route' => 'work.projects.project.settings.departments',
                    'routeParameters' => ['project_id' => $options['project_id']]
                ])
                ->setExtra('routes', [
                    ['route' => 'work.projects.project.settings.departments'],
                    ['pattern' => '/^work.projects.project.settings.departments\..+/']
                ])
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');

            $menu
            ->addChild('Участники', [
                'route' => 'work.projects.project.settings.members',
                'routeParameters' => ['project_id' => $options['project_id']]
            ])
            ->setExtra('routes', [
                ['route' => 'work.projects.project.settings.members'],
                ['pattern' => '/^work.projects.project.settings.members\..+/']
            ])
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');

        }

        return $menu;
    }
}