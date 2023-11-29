<?php

declare(strict_types=1);

namespace App\Model\Drevos\Entity\Rass\LiniBr;

use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\VetkaBr;
use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\Id as VetkaBrId;

use App\Model\Drevos\Entity\Rass\Ras;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="dre_ras_linibrs")
 */
class LiniBr
{
    /**
     * @var Ras
     * @ORM\ManyToOne(targetEntity="App\Model\Drevos\Entity\Rass\Ras", inversedBy="linias")
     * @ORM\JoinColumn(name="rasa_id", referencedColumnName="id", nullable=false)
     */
    private $rasa;
	
    /**
     * @var Id
     * @ORM\Column(type="dre_ras_linibr_id")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

//     /**
//     * @var string
//     * @ORM\Column(type="string")
//     */
//    private $nameStar;

//     /**
//     * @var string
//     * @ORM\Column(type="string")
//     */
//    private $title;

//    /**
//     * @var string|null
//     * @ORM\Column(type="string",  nullable=true)
//     */
//    private $idVetka;
	
	 /**
     * @var ArrayCollection|VetkaBr[]
     * @ORM\OneToMany(
     *     targetEntity="App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\VetkaBr",
     *     mappedBy="linia", orphanRemoval=true, cascade={"all"}
     * )
     * @ORM\OrderBy({"nomer" = "ASC"})
     */
    private $vetkas;
	
	 /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $sortLiniBr;



    /**
     * @var LiniBr|null
     * @ORM\ManyToOne(targetEntity="LiniBr")
     * @ORM\JoinColumn(name="rodit_br_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $roditBr;  // родитель

    public function __construct(Ras $rasa, Id $id,
                                string $name,
								int $sortLiniBr,
                                ?LiniBr $roditBr
                                )
    {
        $this->rasa = $rasa;
        $this->id = $id;
        $this->name = $name;
		$this->sortLiniBr = $sortLiniBr;
		$this->roditBr = $roditBr;

		$this->vetkas = new ArrayCollection();
    }

	public function edit(string $name ): void
    {
        $this->name = $name;

    }

//    public function setVetkaChildOf(?LiniBr $vetka): void
//    {
//        if ($vetka) {
//            $current = $vetka;
//            do {
//                if ($current === $this) {
//                    throw new \DomainException('Cyclomatic children.');
//                }
//            }
//            while ($current && $current = $current->getVetka());
//        }
//
//        $this->vetka = $vetka;
//    }

    public function addVetkaBr(VetkaBrId $id,
                                string $nomer,
                                 string $god,
                                 int $sortVet
                                ): void
    {
        foreach ($this->vetkas as $vetka) {
            if ($vetka->isNomerEqual($nomer)) {
                throw new \DomainException('номер уже существует.');
            }

        }
        $this->vetkas->add(new VetkaBr($this, $id, $nomer, $god, $sortVet ));
    }

    public function editVetkaBr(VetkaBrId $id, string $nomer, string $god): void
    {
        foreach ($this->vetkas as $current) {
            if ($current->getId()->isEqual($id)) {
                $current->edit($nomer, $god);
                return;
            }
        }
        throw new \DomainException('vetka is not found.');
    }

    public function removeVetkaBr(VetkaBrId $id): void
    {
        foreach ($this->vetkas as $vetka) {
            if ($vetka->getId()->isEqual($id)) {
                $this->vetkas->removeElement($vetka);
                return;
            }
        }
        throw new \DomainException('LiniBr is not found.');
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

	
	public function getSortLiniBr(): int
    {
        return $this->sortLiniBr;
    }


    public function getVetkas()
    {
        return $this->vetkas->toArray();
    }
	


    public function getVetka(VetkaBrId $id): VetkaBr
    {
        foreach ($this->vetkas as $vetka) {
            if ($vetka->getId()->isEqual($id)) {
                return $vetka;
            }
        }
        throw new \DomainException('Nomer is not found.');
    }


    public function getRasa(): Ras
    {
        return $this->rasa;
    }

    /**
     * @return LiniBr|null
     */
    public function getRoditBr(): ?LiniBr
    {
        return $this->roditBr;
    }


}
