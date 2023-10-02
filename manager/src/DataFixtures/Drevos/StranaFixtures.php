<?php

declare(strict_types=1);

namespace App\DataFixtures\Drevos;

use App\Model\Drevos\Entity\Strans\Stran;
use App\Model\Drevos\Entity\Strans\Id;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class StranaFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $stran1 = new Stran(
            Id::next(),
            'Россия',
            7
        );
        $manager->persist($stran1);

        $stran1 = new Stran(
            Id::next(),
            'Германия',
            49
        );
        $manager->persist($stran1);

        $manager->flush();
    }

}