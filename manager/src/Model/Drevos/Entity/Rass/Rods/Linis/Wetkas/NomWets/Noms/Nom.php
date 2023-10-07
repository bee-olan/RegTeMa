<?php

declare(strict_types=1);

namespace App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\Noms;

use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchastieId;

use App\Model\Adminka\Entity\Uchasties\Uchastie\Uchastie;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\NomWet;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="dre_ras_rod_lini_wet_nomw_noms")
 */
class Nom
{

    /**
     * @var NomWet
     * @ORM\ManyToOne(targetEntity="App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\NomWet", inversedBy="nomers")
     * @ORM\JoinColumn(name="nomwet_id", referencedColumnName="id", nullable=false)
     */
    private $nomwet;
	
    /**
     * @var Id
     * @ORM\Column(type="dre_ras_rod_lini_wet_nomw_nom_id")
     * @ORM\Id
     */
    private $id;

     /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $nameOt;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $nom;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $god;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $tit;

	
	 /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $sortNom;

    /**
     * @var Statu
     * @ORM\Column(type="dre_ras_rod_lini_wet_nomw_nom_stat", length=16)
     */
    private $status;

    /**
     * @var Uchastie
     * @ORM\ManyToOne(targetEntity="App\Model\Adminka\Entity\Uchasties\Uchastie\Uchastie")
     * @ORM\JoinColumn(name="zakazal_id", referencedColumnName="id", nullable=false)
     */
//    private $uchastie;

    private $zakazal;

    public function __construct(NomWet $nomwet, Id $id,
								string $nom,
                                string $god,
                                string $tit,
								string $nameOt,
								int $sortNom,
                                Uchastie $zakazal
                                )
    {
        $this->nomwet = $nomwet;
        $this->id = $id;
        $this->nom = $nom;
        $this->god = $god;
        $this->tit = $tit;
        $this->nameOt = $nameOt;
		$this->sortNom = $sortNom;
		$this->zakazal = $zakazal;

        $this->status = Statu::ojidaet();
//        $this->zakazals = new ArrayCollection();
    }

	public function edit(   string $nom,
                            string $god,
                            string $tit,
                            string $nameOt
                            ): void
    {
        $this->nom = $nom;
        $this->god = $god;
        $this->tit = $tit;
        $this->nameOt = $nameOt;
    }

    //-------------------------------------

//    public function hasUchastie(UchastieId $id): bool
//    {
//        foreach ($this->zakazals as $zakazal) {
//            if ($zakazal->isForUchastie($id)) {
//                return true;
//            }
//        }
//        return false;
//    }
//
//
//    /**
//     * @param Uchastie $uchastie
//     * @throws \Exception
//     */
//    public function addUchastie(Uchastie $uchastie): void
//    {
//        foreach ($this->zakazals as $zakazal) {
//            if ($zakazal->isForUchastie($uchastie->getId())) {
//                throw new \DomainException('Такой участник уже добавлен.');
//            }
//        }
////        $departments = array_map([$this, 'getDepartment'], $departmentIds);
//        $this->zakazals->add(new Zakazal($this, $uchastie));
//    }
//
//    /**
//     * @param UchastieId $uchastie
//     */
//    public function editUchastie(UchastieId $uchastie): void
//    {
//        foreach ($this->zakazals as $zakazal) {
//            if ($zakazal->isForUchastie($uchastie)) {
//                return;
//            }
//        }
//        throw new \DomainException('Участие не найдено.');
//    }
//
//    public function removeUchastie(UchastieId $uchastie): void
//    {
//        foreach ($this->zakazals as $zakazal) {
//            if ($zakazal->isForUchastie($uchastie)) {
//                $this->zakazal->removeElement($zakazal);
//                return;
//            }
//        }
//        throw new \DomainException('Участие не найдено.');
//    }

//------------------------------------------------------
    public function archive(): void
    {
        if ($this->isArchived()) {
            throw new \DomainException('Номер уже заархивирован.');
        }
        $this->status = Statu::archived();
    }

    public function reinstate(): void
    {
        if ($this->isActive()) {
            throw new \DomainException('Номер уже активен.?');
        }
        $this->status = Statu::active();
    }

    public function ojidaetActive(): void
    {
        if ($this->isActive()) {
            throw new \DomainException('Номер уже активен.?');
        }
        $this->status = Statu::active();

    }

    public function activeOjidaet(): void
    {
        if ($this->isOjidaet()) {
            throw new \DomainException('Номер уже ожидает');
        }
        $this->status = Statu::ojidaet();

    }

    public function isArchived(): bool
    {
        return $this->status->isArchived();
    }

    public function isActive(): bool
    {
        return $this->status->isActive();
    }

    public function isOjidaet(): bool
    {
        return $this->status->isOjidaet();
    }
// -----------------------------------------------------------

    public function isTitEqual(string $tit): bool
    {
        return $this->tit === $tit;
    }

    public function getId(): Id
    {
        return $this->id;
    }


    public function getSortNom(): int
    {
        return $this->sortNom;
    }



    public function getStatus(): Statu
    {
        return $this->status;
    }


    public function getNomwet(): NomWet
    {
        return $this->nomwet;
    }


    public function getNameOt(): string
    {
        return $this->nameOt;
    }

    public function getNom(): string
    {
        return $this->nom;
    }


    public function getGod(): string
    {
        return $this->god;
    }


    public function getTit(): string
    {
        return $this->tit;
    }


    public function getZakazal(): Uchastie
    {
        return $this->zakazal;
    }


}
