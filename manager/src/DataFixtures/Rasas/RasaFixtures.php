<?php


namespace App\DataFixtures\Rasas;

use App\Model\Adminka\Entity\Rasas\Rasa;
use App\Model\Adminka\Entity\Rasas\Id;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class RasaFixtures extends Fixture
{
    public const REFERENCE_SREDRUSS= 'rasas_rasa_sredruss';
    public const REFERENCE_KARNIK= 'rasas_rasa_karnik';
    public const REFERENCE_JAK_KARNIK= 'rasas_rasa_jak_karnik';
    public const REFERENCE_ITALL= 'rasas_rasa_itall';

    public function load(ObjectManager $manager): void
    {

        $nets = new Rasa(
            Id::next(),
            ' -- нет нужной',
            '.....'
        );
        $manager->persist($nets);
//        $this->setReference(self::REFERENCE_SREDRUSS, $sredruss);


        $sredruss = new Rasa(
            Id::next(),
            'Ср',
            'Среднерусская'
        );
        $manager->persist($sredruss);
        $this->setReference(self::REFERENCE_SREDRUSS, $sredruss);
//---------------
        $karnik = new Rasa(
            Id::next(),
            'Кр',
            'Карника'
        );
        $manager->persist($karnik);
        $this->setReference(self::REFERENCE_KARNIK, $karnik);

//---------------
        $jak = new Rasa(
            Id::next(),
            'Як',
            'Ярославская карника'
        );
        $manager->persist($jak);
        $this->setReference(self::REFERENCE_JAK_KARNIK, $jak);

//---------------
        $itall = new Rasa(
            Id::next(),
            'Ит',
            'Итальянка'
        );
        $manager->persist($itall);
        $this->setReference(self::REFERENCE_ITALL, $itall);

    $manager->flush();
    }

}