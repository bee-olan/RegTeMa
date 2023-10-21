<?php

declare(strict_types=1);

namespace App\Model\Drevos\Entity\Rass\Rods;

use App\Model\Drevos\Entity\Rass\Ras;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Id as LiniId;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Lini;
use App\Model\Drevos\Entity\Strans\Stran;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="dre_ras_rods")
 */
class Rod
{
    /**
     * @var Ras
     * @ORM\ManyToOne(targetEntity="App\Model\Drevos\Entity\Rass\Ras", inversedBy="rodos")
     * @ORM\JoinColumn(name="rasa_id", referencedColumnName="id", nullable=false)
     */
    private $rasa;
	
    /**
     * @var Id
     * @ORM\Column(type="dre_ras_rod_id")
     * @ORM\Id
     */
    private $id;


    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $nameMatkov;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $kodMatkov;

    /**
     * @var Stran
     * @ORM\ManyToOne(targetEntity="App\Model\Drevos\Entity\Strans\Stran")
     * @ORM\JoinColumn(name="strana_id", referencedColumnName="id", nullable=false)
     */
    private $strana;

    /**
     * @var ArrayCollection|Lini[]
     * @ORM\OneToMany(
     *     targetEntity="App\Model\Drevos\Entity\Rass\Rods\Linis\Lini",
     *     mappedBy="rodo", orphanRemoval=true, cascade={"all"}
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $linias;
	
	 /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $sortRodo;


    public function __construct(Ras $rasa, Id $id,
								int $sortRodo,
                                string $nameMatkov,
                                string $kodMatkov,
                                Stran $strana

                                )
    {
        $this->rasa = $rasa;
        $this->id = $id;
		$this->sortRodo = $sortRodo;
		$this->nameMatkov = $nameMatkov;
		$this->kodMatkov = $kodMatkov;
		$this->strana = $strana;


		$this->linias = new ArrayCollection();
    }

	public function edit(string $nameMatkov,
                        string $kodMatkov
                    ): void
    {
        $this->nameMatkov = $nameMatkov;
		$this->kodMatkov = $kodMatkov;
    }


    public function addLini(LiniId $id,
                             string $name,
                             int $sortLini

    ): void
    {
        foreach ($this->linias as $linia) {
            if ($linia->isNameEqual($name)) {
                throw new \DomainException('Линия уже существует. Попробуйте для
                этой линии добавить свой номер');
            }
        }

        $this->linias->add(new Lini($this,
            $id,
            $name,
            $sortLini
        ));
    }

    public function editLinia(LiniId $id,
                              string $name
    ): void
    {
        foreach ($this->linias as $current) {
            if ($current->getId()->isEqual($id)) {
                $current->edit($name );
                return;
            }
        }
        throw new \DomainException('Linia is not found.');
    }

    public function removeLinia(LiniId $id): void
    {
        foreach ($this->linias as $linia) {
            if ($linia->getId()->isEqual($id)) {
                $this->linias->removeElement($linia);
                return;
            }
        }
        throw new \DomainException('Linia is not found.');
    }


    public function getLinias()
    {
        return $this->linias;
    }

    public function getLinia(LiniId $id): Lini
    {
        foreach ($this->linias as $linia) {
            if ($linia->getId()->isEqual($id)) {
                return $linia;
            }
        }
        throw new \DomainException('Linia is not found.');
    }

	
// равно Ли Имя
    public function isNameMatEqual(string $nameMatkov): bool
    {

        return $this->nameMatkov === $nameMatkov;
    }

    public function isKodMatkovEqual(string $kodMatkov): bool
    {
        return $this->kodMatkov === $kodMatkov;
    }


    public function getId(): Id
    {
        return $this->id;
    }



//    public function getNameMat(): string
//    {
//        return $this->nameMat;
//    }
//
//
//    public function getNameOt(): string
//    {
//        return $this->nameOt;
//    }


    public function getSortRodo(): int
    {
        return $this->sortRodo;
    }


//    public function getNameLin(): string
//    {
//        return $this->nameLin;
//    }
//
//    public function getNameNom(): string
//    {
//        return $this->nameNom;
//    }
//
//    public function getNameGod(): string
//    {
//        return $this->nameGod;
//    }



    public function getNameMatkov(): string
    {
        return $this->nameMatkov;
    }


    public function getKodMatkov(): string
    {
        return $this->kodMatkov;
    }


    public function getRasa(): Ras
    {
        return $this->rasa;
    }


    public function getStrana(): Stran
    {
        return $this->strana;
    }


}
