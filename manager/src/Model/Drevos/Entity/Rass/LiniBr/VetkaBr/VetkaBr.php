<?php

declare(strict_types=1);

namespace App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr;

use App\Model\Drevos\Entity\Rass\LiniBr\LiniBr;
//use App\Model\Drevos\Entity\Rass\LiniBr\Id;
use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\NomerBr\NomerBr;
use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\NomerBr\Id as NomerBrId;
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
	
	 /**
     * @var ArrayCollection|NomerBr[]
     * @ORM\OneToMany(
     *     targetEntity="App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\NomerBr\NomerBr",
     *     mappedBy="vetka", orphanRemoval=true, cascade={"all"}
     * )
     * @ORM\OrderBy({"nomBr" = "ASC"})
     */
    private $nomers;
	
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


		$this->nomers = new ArrayCollection();
    }

	public function edit(string $nomer, string $god): void
    {
        $this->nomer = $nomer;
        $this->god = $god;
    }


    public function addNomerBr(NomerBrId $id,
                               string $nomBr,
                               string $god,
                               int $sortNom,
                               string $title
                                ): void
    {

        foreach ($this->nomers as $nomer) {
            if ($nomer->isNomWEqual($nomBr)) {
                throw new \DomainException('номер уже существует.');
            }

        }
        $this->nomers->add(new NomerBr($this, $id, $nomBr, $god, $sortNom, $title));
    }

    public function editNomerBr(NomerBrId $id,
                                string $nomBr,
                                string $god
                            ): void
    {
        foreach ($this->nomers as $current) {
            if ($current->getId()->isEqual($id)) {
                $current->edit($nomBr, $god);
                return;
            }
        }
        throw new \DomainException('nomer is not found.');
    }

    public function removeNomerBr(NomerBrId $id): void
    {
        foreach ($this->nomers as $nomer) {
            if ($nomer->getId()->isEqual($id)) {
                $this->nomers->removeElement($nomer);
                return;
            }
        }
        throw new \DomainException('NomerBr is not found.');
    }
	
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


    public function getNomers()
    {
        return $this->nomers->toArray();;
    }


    public function getNomerBr(NomerBrId $id): NomerBr
    {
        foreach ($this->nomers as $nomer) {
            if ($nomer->getId()->isEqual($id)) {
                return $nomer;
            }
        }
        throw new \DomainException('NomWet is not found.');
    }


}
