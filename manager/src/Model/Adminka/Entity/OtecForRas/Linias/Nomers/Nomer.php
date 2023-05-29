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
     * @var string|null
     * @ORM\Column(type="string",  nullable=true)
     */
    private $name;

    /**
     * @var Matka
     * @ORM\Embedded(class="Matka")
     */
    private $matka;

    /**
     * @var Otec
     * @ORM\Embedded(class="Otec")
     */
    private $otec;

    /**
     * @var string|null
     * @ORM\Column(type="string",  nullable=true)
     */
    private $oblet;


    /**
     * @var string|null
     * @ORM\Column(type="string",  nullable=true)
     */
    private $title;


    public function __construct(Linia $linia, Id $id,
                                string $name,
                                ?Matka $matka,
                                ?Otec $otec,
                                ?string $oblet,
                                string $title
                                )
    {
        $this->linia = $linia;
        $this->id = $id;
        $this->name = $name;
        $this->matka = $matka;
        $this->otec = $otec;
        $this->oblet = $oblet;
        $this->title = $title = null;
    }

    public function edit(string $name,
                         ?Matka $matka,
                         ?Otec $otec,
                         ?string $oblet,
                         string $title
                    ): void
    {
        $this->name = $name;
        $this->matka = $matka;
        $this->otec = $otec;
        $this->oblet = $oblet;
        $this->title = $title;

    }

	
// равно Ли Имя
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


    public function getMatka(): Matka
    {
        return $this->matka;
    }


    public function getOtec(): Otec
    {
        return $this->otec;
    }

    public function getOblet(): string
    {
        return $this->oblet;
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
