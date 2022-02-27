<?php

declare(strict_types=1);

namespace App\DataFixtures\Paseka;

use App\Model\Paseka\Entity\Pchelowods\Group\Group;
use App\Model\Paseka\Entity\Pchelowods\Group\Id;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class GroupFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $group = new Group(
            Id::next(),
            'Матководы'
        );

        $manager->persist($group);

        $group = new Group(
            Id::next(),
            'Пчело-Матководы'
        );

        $manager->persist($group);

        $group = new Group(
            Id::next(),
            'Пчеловоды'
        );

        $manager->persist($group);

        $manager->flush();
    }
}
