<?php

declare(strict_types=1);

namespace App\Model\Drevos\Entity\Strans;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="dre_strans")
 */
class Stran
{
    /**
     * @var Id
     * @ORM\Column(type="dre_stran_id")
     * @ORM\Id
     */
    private $id;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $nomer;

    public function __construct(Id $id, string $name, int $nomer)
    {
        $this->id = $id;
        $this->name = $name;
        $this->nomer = $nomer;
    }

    public function edit(string $name, int $nomer): void
    {
        $this->name = $name;
        $this->nomer = $nomer;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }


    public function getNomer(): int
    {
        return $this->nomer;
    }
	

}
