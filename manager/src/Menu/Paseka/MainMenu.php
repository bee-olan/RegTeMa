<?php

declare(strict_types=1);

namespace App\Menu\Paseka;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class MainMenu
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
            ->addChild('Раса - tabs-p', ['route' => 'paseka.rasas'])
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');

    
        if ($this->auth->isGranted('ROLE_WORK_MANAGE_PROJECTS')) {
            $menu
                ->addChild('Категории tabs-p', ['route' => 'paseka.rasas.kategors'])
                ->setExtra('routes', [
                    ['route' => 'paseka.rasas.kategors'],
                    ['pattern' => '/^paseka.rasas.kategors\..+/']
                ])
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');
        }

        return $menu;
    }
}
