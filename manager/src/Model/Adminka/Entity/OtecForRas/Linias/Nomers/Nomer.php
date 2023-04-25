<?php

declare(strict_types=1);

namespace App\Model\Adminka\Entity\OtecForRas\Linias\Nomers;

use App\Model\Adminka\Entity\OtecForRas\Linias\Linia;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="adminka_otec_ras_linia_nomers")
 */
class Nomer
{
    /**
     * @var Linia
     * @ORM\ManyToOne(targetEntity="App\Model\Adminka\Entity\OtecForRas\Linias\Linia", inversedBy="nomers")
     * @ORM\JoinColumn(name="linia_id", referencedColumnName="id", nullable=false)
     */
    private $linia;
	
    /**
     * @var Id
     * @ORM\Column(type="adminka_otec_ras_linia_nomer_id")
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
    private $title;



    public function __construct(Linia $linia, Id $id,
                                string $name,
                                string $title

                                )
    {
        $this->linia = $linia;
        $this->id = $id;
        $this->name = $name;
        $this->title = $title;
    }
	
		public function edit(string $name, 
                        string $title): void
    {
        $this->name = $name;
		$this->title = $title;


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


    public function getId(): Id
    {
        return $this->id;
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function getTitle(): string
    {
        return $this->title;
    }

    public function getLinia(): Linia
    {
        return $this->linia;
    }
}
