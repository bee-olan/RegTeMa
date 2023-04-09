<?php

declare(strict_types=1);
namespace App\DataFixtures\Adminka\Matkas\Roles;

use App\Model\Adminka\Entity\Matkas\Role\Permission;
use App\Model\Adminka\Entity\Matkas\Role\Role;
use App\Model\Adminka\Entity\Matkas\Role\Id;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class RoleFixture extends Fixture
{

    public const REFERENCE_MODERATOR = 'matka_role_moderator';
    public const REFERENCE_GUEST = 'matka_role_guest';
    public const REFERENCE_PCHELOV = 'matka_role_pchelov';
    public const REFERENCE_MATKOVOD = 'matka_role_matkovod';
    public const REFERENCE_PCHEL_MAT = 'matka_role_pchel_mat';

    public function load(ObjectManager $manager): void
    {
        $guest = $this->createRole('Гость', [
//            Permission::VIEW_CHILD,
        ]);
        $manager->persist($guest);
        $this->setReference(self::REFERENCE_GUEST, $guest);


        $moderator = $this->createRole('Модератор', [
            Permission::MANAGE_PLEMMATKA_UCHASTIES,
            Permission::VIEW_CHILD,
            Permission::MANAGE_CHILDMATKAS,
        ]);
        $manager->persist($moderator);
        $this->setReference(self::REFERENCE_MODERATOR, $moderator);

        $pchelMat = $this->createRole('Пчело-Матковод', [
            Permission::MANAGE_PLEMMATKA_UCHASTIES,
            Permission::VIEW_CHILD,
            Permission::MANAGE_CHILDMATKAS,
            Permission::MANAGE_PLEMMATKAS,
        ]);
        $manager->persist($pchelMat);
        $this->setReference(self::REFERENCE_PCHEL_MAT, $pchelMat);

        $matka = $this->createRole('Матковод', [
            Permission::MANAGE_PLEMMATKA_UCHASTIES,
            Permission::VIEW_CHILD,
            Permission::MANAGE_PLEMMATKAS,
            Permission::MANAGE_CHILDMATKAS,
        ]);
        $manager->persist($matka);
        $this->setReference(self::REFERENCE_MATKOVOD, $matka);

        $manager->flush();
    }

    private function createRole(string $name, array $permissions): Role
    {
        return new Role(
            Id::next(),
            $name,
            $permissions
        );
    }

}


