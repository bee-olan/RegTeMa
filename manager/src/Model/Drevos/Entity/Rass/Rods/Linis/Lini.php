<?php

declare(strict_types=1);

namespace App\Model\Drevos\Entity\Rass\Rods\Linis;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\Wetka;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\Id as WetkaId;

use App\Model\Drevos\Entity\Rass\Rods\Rod;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="dre_ras_rod_linis")
 */
class Lini
{

    /**
     * @var Rod
     * @ORM\ManyToOne(targetEntity="App\Model\Drevos\Entity\Rass\Rods\Rod", inversedBy="linias")
     * @ORM\JoinColumn(name="rodo_id", referencedColumnName="id", nullable=false)
     */
    private $rodo;
	
    /**
     * @var Id
     * @ORM\Column(type="dre_ras_rod_lini_id")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;



	
	 /**
     * @var ArrayCollection|Wetka[]
     * @ORM\OneToMany(
     *     targetEntity="App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\Wetka",
     *     mappedBy="linia", orphanRemoval=true, cascade={"all"}
     * )
     * @ORM\OrderBy({"nameW" = "ASC"})
     */
    private $wetkas;

	 /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $sortLini;

    public function __construct(Rod $rodo, Id $id,
                                string $name,
								int $sortLini

                                )
    {
        $this->rodo = $rodo;
        $this->id = $id;
        $this->name = $name;
		$this->sortLini = $sortLini;


		$this->wetkas = new ArrayCollection();
    }

	public function edit(string $name
    ): void
    {
        $this->name = $name;

    }


    public function addWetka(WetkaId $id,
                                string $nameW,
//                                string $nomW,
//                                string $godW,
//                                string $titW,
                                int $sortWetka
                                ): void
    {
        foreach ($this->wetkas as $wetka) {
            if ($wetka->isNameEqual($nameW)) {
                throw new \DomainException('ветка уже существует.');
            }

        }
        $this->wetkas->add(new Wetka($this, $id, $nameW, $sortWetka));
    }

    public function editWetka(WetkaId $id, string $nameW): void
    {
        foreach ($this->wetkas as $current) {
            if ($current->getId()->isEqual($id)) {
                $current->edit($nameW);
                return;
            }
        }
        throw new \DomainException('wetka is not found.');
    }

    public function removeWetka(WetkaId $id): void
    {
        foreach ($this->wetkas as $wetka) {
            if ($wetka->getId()->isEqual($id)) {
                $this->wetkas->removeElement($wetka);
                return;
            }
        }
        throw new \DomainException('Lini is not found.');
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

	
	public function getSortLini(): int
    {
        return $this->sortLini;
    }
	
	  
    public function getWetkas()
    {
        return $this->wetkas->toArray();
    }

    public function getWetka(WetkaId $id): Wetka
    {
        foreach ($this->wetkas as $wetka) {
            if ($wetka->getId()->isEqual($id)) {
                return $wetka;
            }
        }
        throw new \DomainException('Wetka is not found.');
    }


    public function getRodo(): Rod
    {
        return $this->rodo;
    }


}
