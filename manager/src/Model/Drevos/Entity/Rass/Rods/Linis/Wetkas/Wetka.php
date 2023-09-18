<?php

declare(strict_types=1);

namespace App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas;

//use App\Model\Drevos\Entity\Rass\Rods\Linias\Nomers\Nomer;
//use App\Model\Drevos\Entity\Rass\Rods\Linias\Nomers\Id as NomerId;


use App\Model\Drevos\Entity\Rass\Rods\Linis\Lini;


use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\NomWet;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\Id as NomWetId;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="dre_ras_rod_lini_wets")
 */
class Wetka
{

    /**
     * @var Lini
     * @ORM\ManyToOne(targetEntity="App\Model\Drevos\Entity\Rass\Rods\Linis\Lini", inversedBy="wetkas")
     * @ORM\JoinColumn(name="linia_id", referencedColumnName="id", nullable=false)
     */
    private $linia;
	
    /**
     * @var Id
     * @ORM\Column(type="dre_ras_rod_lini_wet_id")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $nameW;


	
	 /**
     * @var ArrayCollection|NomWet[]
     * @ORM\OneToMany(
     *     targetEntity="App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\NomWet",
     *     mappedBy="wetka", orphanRemoval=true, cascade={"all"}
     * )
     * @ORM\OrderBy({"nomW" = "ASC"})
     */
    private $nomwets;
	
	 /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $sortWetka;

    public function __construct(Lini $linia, Id $id,
                                string $nameW,
								int $sortWetka

                                )
    {
        $this->linia = $linia;
        $this->id = $id;
        $this->nameW = $nameW;
		$this->sortWetka = $sortWetka;


		$this->nomwets = new ArrayCollection();
    }

	public function edit(string $nameW


    ): void
    {
        $this->nameW = $nameW;
    }


    public function addNomWet(NomWetId $id,
                              string $nomW,
                                string $godW,
                                string $titW,
                                int $sortNomWet
                                ): void
    {

        foreach ($this->nomwets as $nomwet) {
            if ($nomwet->isNomWEqual($nomW)) {
                throw new \DomainException('номер уже существует.');
            }

        }
        $this->nomwets->add(new NomWet($this, $id, $nomW, $godW, $titW, $sortNomWet));
    }

    public function editNomWet(NomWetId $id,
                               string $nomW,
                               string $godW ,
                               string $titW
                            ): void
    {
        foreach ($this->nomwets as $current) {
            if ($current->getId()->isEqual($id)) {
                $current->edit($nomW, $godW, $titW);
                return;
            }
        }
        throw new \DomainException('nomer is not found.');
    }

    public function removeNomWet(NomWetId $id): void
    {
        foreach ($this->nomwets as $nomwet) {
            if ($nomwet->getId()->isEqual($id)) {
                $this->nomwets->removeElement($nomwet);
                return;
            }
        }
        throw new \DomainException('NomWet is not found.');
    }
	
// равно Ли Имя
    public function isNameEqual(string $nameW): bool
    {
        return $this->nameW === $nameW;
    }


    public function getId(): Id
    {
        return $this->id;
    }



    public function getSortWetka(): int
    {
        return $this->sortWetka;
    }


    public function getLinia(): Lini
    {
        return $this->linia;
    }

    public function getNameW(): string
    {
        return $this->nameW;
    }

    public function getNomWets()
    {
        return $this->nomwets->toArray();
    }

    public function getNomWet(NomWetId $id): NomWet
    {
        foreach ($this->nomwets as $nomwet) {
            if ($nomwet->getId()->isEqual($id)) {
                return $nomwet;
            }
        }
        throw new \DomainException('NomWet is not found.');
    }




}
