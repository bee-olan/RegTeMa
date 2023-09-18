<?php

declare(strict_types=1);

namespace App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\Noms\Id  as NomId;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\Noms\Nom;
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
     * @var ArrayCollection|Nom[]
     * @ORM\OneToMany(
     *     targetEntity="App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\Noms\Nom",
     *     mappedBy="nomwet", orphanRemoval=true, cascade={"all"}
     * )
     * @ORM\OrderBy({"tit" = "ASC"})
     */
    private $nomers;
	
	 /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $sortNomWet;

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


		$this->nomers = new ArrayCollection();
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


    public function addNom(NomId $id,
                                string $nom,
                                string $god,
                                string $tit,
                                string $nameOt,
                                int $sortNom
                                ): void
    {

        foreach ($this->nomers as $nomer) {
            if ($nomer->isTitEqual($tit)) {
                throw new \DomainException('номер уже существует.');
            }

        }
        $this->nomers->add(new Nom($this, $id, $nom, $god, $tit, $nameOt, $sortNom));
    }

 

    public function editNom(NomId $id, string $nom, string $god, string  $tit, string $nameOt): void
    {
        foreach ($this->nomers as $current) {
            if ($current->getId()->isEqual($id)) {
                $current->edit($nom, $god, $tit, $nameOt);
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
