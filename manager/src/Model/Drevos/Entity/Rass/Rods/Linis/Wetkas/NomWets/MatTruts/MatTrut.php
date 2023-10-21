<?php

declare(strict_types=1);

namespace App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts;


use App\Model\Adminka\Entity\Uchasties\Uchastie\Uchastie;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\Nom;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\Id  as NomId;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\NomWet;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="dre_ras_rod_lini_wet_nomw_truts")
 */
class MatTrut
{

    /**
     * @var NomWet
     * @ORM\ManyToOne(targetEntity="App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\NomWet", inversedBy="mattruts")
     * @ORM\JoinColumn(name="nomwet_id", referencedColumnName="id", nullable=false)
     */
    private $nomwet;
	
    /**
     * @var Id
     * @ORM\Column(type="dre_ras_rod_lini_wet_nomw_trut_id")
     * @ORM\Id
     */
    private $id;


    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $nameOt;


	
	 /**
     * @var ArrayCollection|Nom[]
     * @ORM\OneToMany(
     *     targetEntity="App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\Nom",
     *     mappedBy="mattrut", orphanRemoval=true, cascade={"all"}
     * )
     * @ORM\OrderBy({"tit" = "ASC"})
     */
    private $nomers;
	
	 /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $sortTrut;

    public function __construct(NomWet $nomwet, Id $id,
                                string $nameOt,
								int $sortTrut

                                )
    {
        $this->nomwet = $nomwet;
        $this->id = $id;
        $this->nameOt =$nameOt;
		$this->sortTrut = $sortTrut;

		$this->nomers = new ArrayCollection();
    }

	public function edit( string $nameOt  ): void
    {
        $this->nameOt = $nameOt;
    }


    public function addNom(NomId $id,
                                string $nom,
                                string $god,
                                string $tit,
                                int $sortNom,
                                Uchastie $zakazal
                                ): void
    {
//        dd($this->nomers);
        foreach ($this->nomers as $nomer) {

            if ($nomer->isTitEqual($tit)) {
                throw new \DomainException('номер уже существует.');
            }

        }
        $this->nomers->add(new Nom($this, $id, $nom, $god, $tit,  $sortNom, $zakazal));
    }

 

    public function editNom(NomId $id, string $nom, string $god, string  $tit): void
    {
        foreach ($this->nomers as $current) {
            if ($current->getId()->isEqual($id)) {
                $current->edit($nom, $god, $tit);
                return;
            }
        }
        throw new \DomainException('nom is not found.');
    }

    public function removeNom(NomId $id): void
    {
        foreach ($this->nomers as $nomer) {
            if ($nomer->getId()->isEqual($id)) {
                $this->nomers->removeElement($nomer);
                return;
            }
        }
        throw new \DomainException('Wetkaa is not found.');
    }
	
// равно Ли Имя
    public function isTrutEqual(string $nameOt): bool
    {
        return $this->nameOt === $nameOt;
    }


    public function getId(): Id
    {
        return $this->id;
    }


    public function getNameOt(): string
    {
        return $this->nameOt;
    }


    public function getSortTrut(): int
    {
        return $this->sortTrut;
    }


    public function getNomwet(): NomWet
    {
        return $this->nomwet;
    }


    public function getNomers()
    {
        return $this->nomers;
    }



/////////////////////////


    public function getNoms()
    {
        return $this->nomers->toArray();
    }

    public function getNom(NomId $id): Nom
    {
        foreach ($this->nomers as $nomer) {
            if ($nomer->getId()->isEqual($id)) {
                return $nomer;
            }
        }
        throw new \DomainException('Nomer is not found.');
    }


}
