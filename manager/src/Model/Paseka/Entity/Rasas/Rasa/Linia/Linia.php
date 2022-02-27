<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Rasas\Rasa\Linia;

use App\Model\Paseka\Entity\Rasas\Rasa\Rasa;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="paseka_rasas_rasa_linias")
 */
class Linia
{
    /**
     * @var Rasa
     * @ORM\ManyToOne(targetEntity="App\Model\Paseka\Entity\Rasas\Rasa\Rasa", inversedBy="linias")
     * @ORM\JoinColumn(name="rasa_id", referencedColumnName="id", nullable=false)
     */
    private $rasa;

    /**
     * @var Id
     * @ORM\Column(type="paseka_rasas_rasa_linia_id")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $nameStar;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $sortLinia;

    public function __construct(Rasa $rasa, 
                                Id $id, 
                                string $name,
                                string $nameStar,
								int $sortLinia
                                )
    {
        $this->rasa = $rasa;
        $this->id = $id;
        $this->name = $name;
        $this->nameStar = $nameStar;
		$this->sortLinia = $sortLinia;
    }

    public function isNameEqual(string $name): bool
    {
        return $this->name === $name;
    }

    public function isNameStarEqual(string $nameStar): bool
    {
        return $this->nameStar === $nameStar;
    }

    public function edit(string $name, 
                        string $nameStar): void
    {
        $this->name = $name;
        $this->nameStar = $nameStar;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNameStar(): string
    {
        return $this->nameStar;
    }
	
	public function getSortLinia(): int
    {
        return $this->sortLinia;
    }
	
}
