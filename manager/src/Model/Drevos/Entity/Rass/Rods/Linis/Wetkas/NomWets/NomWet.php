<?php

declare(strict_types=1);

namespace App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\MatTrut;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Id  as MatTrutId;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\Wetka;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="dre_ras_rod_lini_wet_nomws")
 */
class NomWet
{

    /**
     * @var Wetka
     * @ORM\ManyToOne(targetEntity="App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\Wetka", inversedBy="nomwets")
     * @ORM\JoinColumn(name="wetka_id", referencedColumnName="id", nullable=false)
     */
    private $wetka;
	
    /**
     * @var Id
     * @ORM\Column(type="dre_ras_rod_lini_wet_nomw_id")
     * @ORM\Id
     */
    private $id;


    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $nomW;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $godW;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $titW;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $sortNomWet;

	 /**
     * @var ArrayCollection|MatTrut[]
     * @ORM\OneToMany(
     *     targetEntity="App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\MatTrut",
     *     mappedBy="nomwet", orphanRemoval=true, cascade={"all"}
     * )
     * @ORM\OrderBy({"nameOt" = "ASC"})
     */
    private $mattruts;
	


    public function __construct(Wetka $wetka, Id $id,
								string $nomW,
                                string $godW,
                                string $titW,
								int $sortNomWet

                                )
    {
        $this->wetka = $wetka;
        $this->id = $id;
        $this->nomW = $nomW;
        $this->godW = $godW;
        $this->titW = $titW;
		$this->sortNomWet = $sortNomWet;


		$this->mattruts = new ArrayCollection();
    }

	public function edit( string $nomW,
                        string $godW,
                         string $titW
                            ): void
    {
        $this->nomW = $nomW;
        $this->godW = $godW;
        $this->titW = $titW;
    }


    public function addMatTrut(MatTrutId $id,
                                string $nameOt,
                                int $sortTrut
                                ): void
    {

        foreach ($this->mattruts as $mattrut) {
//            dd($mattrut);
            if ($mattrut->isTrutEqual($nameOt)) {
                throw new \DomainException('номер уже существует.');
            }

        }

        $this->mattruts->add(new MatTrut($this, $id,  $nameOt, $sortTrut));
    }

 

    public function editNom(MatTrutId $id,  string $nameOt): void
    {
        foreach ($this->mattruts as $current) {
            if ($current->getId()->isEqual($id)) {
                $current->edit( $nameOt);
                return;
            }
        }
        throw new \DomainException('nom is not found.');
    }

    public function removeNom(MatTrutId $id): void
    {
        foreach ($this->mattruts as $mattrut) {
            if ($mattrut->getId()->isEqual($id)) {
                $this->mattruts->removeElement($mattrut);
                return;
            }
        }
        throw new \DomainException('Wetkaa is not found.');
    }
	
// равно Ли Имя
    public function isNomWEqual(string $nomW): bool
    {
        return $this->nomW === $nomW;
    }


    public function getId(): Id
    {
        return $this->id;
    }


    public function getSortNomWet(): int
    {
        return $this->sortNomWet;
    }


    public function getWetka(): Wetka
    {
        return $this->wetka;
    }

    public function getNomW(): string
    {
        return $this->nomW;
    }


    public function getGodW(): string
    {
        return $this->godW;
    }


    public function getTitW(): string
    {
        return $this->titW;
    }


/////////////////////////


    public function getMatTruts()
    {
        return $this->mattruts->toArray();
    }

    public function getMatTrut(MatTrutId $id): MatTrut
    {
        foreach ($this->mattruts as $mattrut) {
            if ($mattrut->getId()->isEqual($id)) {
                return $mattrut;
            }
        }
        throw new \DomainException('MatTrut is not found.');
    }


}
