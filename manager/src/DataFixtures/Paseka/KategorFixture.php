<?php

declare(strict_types=1);

namespace App\DataFixtures\Paseka\Rasas;

use App\Model\Paseka\Entity\Rasas\Kategor\Permission;
use App\Model\Paseka\Entity\Rasas\Kategor\Kategor;
use App\Model\Paseka\Entity\Rasas\Kategor\Id;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class KategorFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $guest = $this->createKategor('Guest', []);
        $manager->persist($guest);

        $manage = $this->createKategor('Manager', [
            Permission::MANAGE_PROJECT_MEMBERS,
        ]);
        $manager->persist($manage);

        $elitMat = $this->createKategor('El', [
            Permission::EL_MATKI,
        ]);
        $manager->persist($elitMat);

        $manager->flush();
    }

    private function createKategor(string $name, array $permissions): Kategor
    {
        return new Kategor(
            Id::next(),
            $name,
            $permissions
        );
    }
}
