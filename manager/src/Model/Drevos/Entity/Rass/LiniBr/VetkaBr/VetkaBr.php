<?php

declare(strict_types=1);

namespace App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr;

use App\Model\Drevos\Entity\Rass\LiniBr\LiniBr;
use App\Model\Drevos\Entity\Rass\LiniBr\Id;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="dre_ras_linibr_vets")
 */
class VetkaBr
{

    /**
     * @var LiniBr
     * @ORM\ManyToOne(targetEntity="App\Model\Drevos\Entity\Rass\LiniBr\LiniBr", inversedBy="vetkas")
     * @ORM\JoinColumn(name="linia_id", referencedColumnName="id", nullable=false)
     */
    private $linia;
	
    /**
     * @var Id
     * @ORM\Column(type="dre_ras_linibr_vet_id")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $nomer;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $god;
	
//	 /**
//     * @var ArrayCollection|NomWet[]
//     * @ORM\OneToMany(
//     *     targetEntity="App\Model\Drevos\Entity\Rass\Rods\LiniBrs\Wetkas\NomWets\NomWet",
//     *     mappedBy="wetka", orphanRemoval=true, cascade={"all"}
//     * )
//     * @ORM\OrderBy({"nomW" = "ASC"})
//     */
//    private $nomwets;
	
	 /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $sortVet;

    public function __construct(LiniBr $linia, Id $id,
                                string $nomer,
                                string $god,
								int $sortVet

                                )
    {
        $this->linia = $linia;
        $this->id = $id;
        $this->nomer = $nomer;
        $this->god = $god;
		$this->sortVet = $sortVet;


//		$this->nomwets = new ArrayCollection();
    }

	public function edit(string $nomer, string $god): void
    {
        $this->nomer = $nomer;
        $this->god = $god;
    }


//    public function addNomWet(NomWetId $id,
//                              string $nomW,
//                                string $godW,
//                                string $titW,
//                                int $sortNomWet
//                                ): void
//    {
//
//        foreach ($this->nomwets as $nomwet) {
//            if ($nomwet->isNomWEqual($nomW)) {
//                throw new \DomainException('номер уже существует.');
//            }
//
//        }
//        $this->nomwets->add(new NomWet($this, $id, $nomW, $godW, $titW, $sortNomWet));
//    }
//
//    public function editNomWet(NomWetId $id,
//                               string $nomW,
//                               string $godW ,
//                               string $titW
//                            ): void
//    {
//        foreach ($this->nomwets as $current) {
//            if ($current->getId()->isEqual($id)) {
//                $current->edit($nomW, $godW, $titW);
//                return;
//            }
//        }
//        throw new \DomainException('nomer is not found.');
//    }
//
//    public function removeNomWet(NomWetId $id): void
//    {
//        foreach ($this->nomwets as $nomwet) {
//            if ($nomwet->getId()->isEqual($id)) {
//                $this->nomwets->removeElement($nomwet);
//                return;
//            }
//        }
//        throw new \DomainException('NomWet is not found.');
//    }
	
// равно Ли Имя
    public function isNomerEqual(string $nomer): bool
    {
        return $this->nomer === $nomer;
    }


    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return LiniBr
     */
    public function getLinia(): LiniBr
    {
        return $this->linia;
    }

    /**
     * @return string
     */
    public function getNomer(): string
    {
        return $this->nomer;
    }

    /**
     * @return string
     */
    public function getGod(): string
    {
        return $this->god;
    }

    /**
     * @return int
     */
    public function getSortVet(): int
    {
        return $this->sortVet;
    }


//
//    public function getNomWets()
//    {
//        return $this->nomwets->toArray();
//    }
//
//    public function getNomWet(NomWetId $id): NomWet
//    {
//        foreach ($this->nomwets as $nomwet) {
//            if ($nomwet->getId()->isEqual($id)) {
//                return $nomwet;
//            }
//        }
//        throw new \DomainException('NomWet is not found.');
//    }


}
