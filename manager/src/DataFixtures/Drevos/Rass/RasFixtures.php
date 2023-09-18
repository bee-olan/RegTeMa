<?php


namespace App\DataFixtures\Drevos\Rass;

use App\Model\Drevos\Entity\Rass\Ras;
use App\Model\Drevos\Entity\Rass\Id;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class RasFixtures extends Fixture
{
    public const REFERENCE_SREDRUSS= 'rasas_rasa_sredruss';
    public const REFERENCE_KARNIK= 'rasas_rasa_karnik';
    public const REFERENCE_JAK_KARNIK= 'rasas_rasa_jak_karnik';
    public const REFERENCE_ITALL= 'rasas_rasa_itall';

    public function load(ObjectManager $manager): void
    {

        $nets = new Ras(
            Id::next(),
            ' -- нет нужной',
            '.....'
        );
        $manager->persist($nets);
//        $this->setReference(self::REFERENCE_SREDRUSS, $sredruss);


        $sredruss = new Ras(
            Id::next(),
            'Ср',
            'Среднерусская'
        );
        $manager->persist($sredruss);
        $this->setReference(self::REFERENCE_SREDRUSS, $sredruss);
//---------------
        $karnik = new Ras(
            Id::next(),
            'Кр',
            'Карника'
        );
        $manager->persist($karnik);
        $this->setReference(self::REFERENCE_KARNIK, $karnik);

//---------------
        $jak = new Ras(
            Id::next(),
            'Як',
            'Ярославская карника'
        );
        $manager->persist($jak);
        $this->setReference(self::REFERENCE_JAK_KARNIK, $jak);

//---------------
        $itall = new Ras(
            Id::next(),
            'Ит',
            'Итальянка'
        );
        $manager->persist($itall);
        $this->setReference(self::REFERENCE_ITALL, $itall);

    $manager->flush();
    }

}