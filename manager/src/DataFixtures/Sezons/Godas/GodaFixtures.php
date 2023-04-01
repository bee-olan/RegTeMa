<?php

declare(strict_types=1);

namespace App\DataFixtures\Sezons\Godas;

use App\Model\Adminka\Entity\Sezons\Godas\Id;
use App\Model\Adminka\Entity\Sezons\Godas\Goda;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class GodaFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $sezon2020 = new Goda(
            Id::next(),
            2020,
            '2020-2021'
        );
        $manager->persist($sezon2020);

        $sezon2021 = new Goda(
            Id::next(),
            2021,
            '2021-2022'
        );
        $manager->persist($sezon2021);

        $sezon2022 = new Goda(
            Id::next(),
            2022,
            '2022-2023'
        );
        $manager->persist($sezon2022);

        $manager->flush();
    }

}