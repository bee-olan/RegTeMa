<?php


namespace App\DataFixtures\Adminka\Matkas\Kategorias;

use App\Model\Adminka\Entity\Matkas\Kategoria\Kategoria;
use App\Model\Adminka\Entity\Matkas\Kategoria\Id;
use App\Model\Adminka\Entity\Matkas\Kategoria\Permission;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class KategoriaFixture extends Fixture
{


    public function load(ObjectManager $manager): void
    {
        $bre = $this->createKategoria('б', [
            Permission::KATEGORIA_NET_DOKUM,
            Permission::KATEGORIA_F_1,
        ]);

        $manager->persist($bre);

        $net = $this->createKategoria('-', [
//            Permission::KATEGORIA_DOKUM,
//            Permission::KATEGORIA_F_0,
        ]);
        $manager->persist($net);

        $eli = $this->createKategoria('э', [
            Permission::KATEGORIA_DOKUM,
            Permission::KATEGORIA_F_0,
        ]);
        $manager->persist($eli);

        $io = $this->createKategoria('ио', [
            Permission::KATEGORIA_I_O,
            Permission::KATEGORIA_F_0,
            Permission::KATEGORIA_TRUT_SELEK,
        ]);
        $manager->persist($io);

        $manager->flush();
    }

    private function createKategoria(string $name, array $permissions): Kategoria
    {
        return new Kategoria(
            Id::next(),
            $name,
            $permissions
        );
    }

}