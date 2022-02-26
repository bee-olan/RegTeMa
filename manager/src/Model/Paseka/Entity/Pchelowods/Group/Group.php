<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Pchelowods\Group;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="paseka_pchelowods_groups")
 */
class Group
{
	/**
	 * @var Id
	 * @ORM\Column(type="paseka_pchelowods_group_id")
	 * @ORM\Id
	 */
	private $id;
	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	private $name;

	public function __construct(Id $id, string $name)
	{
		$this->id = $id;
		$this->name = $name;
	}

	public function edit(string $name): void
	{
		$this->name = $name;
	}

	public function getId(): Id
	{
		return $this->id;
	}

	public function getName(): string
	{
		return $this->name;
	}
}
