<?php

declare(strict_types=1);

namespace App\DataFixtures\Paseka;

use App\Model\Paseka\Entity\Rasas\Rasa\Rasa;
use App\Model\Paseka\Entity\Rasas\Rasa\Id;
//use App\Model\Paseka\Entity\Matka\Rasas\Linia\Id as LiniaId;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class RasaFixture extends Fixture
{
	// public const REFERENCE_STAFF = 'work_member_group_staff';
	// public const REFERENCE_CUSTOMERS = 'work_member_group_customers';

	public function load(ObjectManager $manager): void
	{

		$active = $this->createRasa('СреднеРусская', 'СрР',1);
		// $active->addLinia($linia = LiniaId::next(), 'С-Р-Линия 1');
		// $active->addLinia(LiniaId::next(), 'С-Р-Линия 2');
		// $active->addMember($admin, [$development], [$manage]);
		$manager->persist($active);

		$active = $this->createRasa('Итальянка','Ит', 2);
		// $active->addLinia($linia = LiniaId::next(), 'Итал-Линия 1');
		// $active->addLinia(LiniaId::next(), 'Итал-Линия 2');
		$manager->persist($active);

		$archived = $this->createRasa('Карника', 'Кар',3);
		$manager->persist($archived);

		$manager->flush();
	}

	private function createRasa(string $name, string $psewdo, int $sort): Rasa
    {
        return new Rasa(
            Id::next(),
            $name,
			$psewdo,
            $sort
        );
    }

}
