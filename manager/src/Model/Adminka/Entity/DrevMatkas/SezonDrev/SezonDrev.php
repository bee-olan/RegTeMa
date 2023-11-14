<?php

declare(strict_types=1);

namespace App\Model\Adminka\Entity\DrevMatkas\SezonDrev;

//use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;
use App\Model\Adminka\Entity\DrevMatkas\DrevMatka;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="adm_drev_sezondrevs")
 */
class SezonDrev
{
    /**
     * @var DrevMatka
     * @ORM\ManyToOne(targetEntity="App\Model\Adminka\Entity\DrevMatkas\DrevMatka", inversedBy="sezondrevs")
     * @ORM\JoinColumn(name="plemmatka_id", referencedColumnName="id", nullable=false)
     */
    private $plemmatka;

    /**
     * @var Id
     * @ORM\Column(type="adm_drev_sezondrev_id")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    public function __construct(DrevMatka $plemmatka, Id $id, string $name)
    {
        $this->plemmatka = $plemmatka;
        $this->id = $id;
        $this->name = $name;
    }

    public function edit(string $name): void
    {
        $this->name = $name;

    }

    public function isNameEqual(string $name): bool
    {
        return $this->name === $name;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }


    public function getPlemmatka(): DrevMatka
    {
        return $this->plemmatka;
    }

}
