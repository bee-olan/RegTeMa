<?php

declare(strict_types=1);

namespace App\Model\Adminka\Entity\Rasas\Linias\Nomers;

use App\Model\Adminka\Entity\Rasas\Linias\Linia;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="adminka_rasa_linia_nomers")
 */
class Nomer
{
    /**
     * @var Linia
     * @ORM\ManyToOne(targetEntity="App\Model\Adminka\Entity\Rasas\Linias\Linia", inversedBy="nomers")
     * @ORM\JoinColumn(name="linia_id", referencedColumnName="id", nullable=false)
     */
    private $linia;
	
    /**
     * @var Id
     * @ORM\Column(type="adminka_rasa_linia_nomer_id")
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
     * @var string
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $sortNomer;

    public function __construct(Linia $linia, Id $id,
                                string $name,
                                string $nameStar,
                                string $title, 
                                int $sortNomer
                                )
    {
        $this->linia = $linia;
        $this->id = $id;
        $this->name = $name;
        $this->nameStar = $nameStar;
        $this->title = $title;
        $this->sortNomer = $sortNomer;
    }
	
		public function edit(string $name, 
                        string $nameStar): void
    {
        $this->name = $name;
		$this->nameStar = $nameStar;
		//$this->title = $title;

    }

	
// равно Ли Имя
    public function isNameEqual(string $name): bool
    {
        return $this->name === $name;
    }

    public function isNameStarEqual(string $nameStar): bool
    {
        return $this->nameStar === $nameStar;
    }

    public function isTitleEqual(string $title): bool
    {
        return $this->title === $title;
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSortNomer(): int
    {
        return $this->sortNomer;
    }


    public function getLinia(): Linia
    {
        return $this->linia;
    }
}
