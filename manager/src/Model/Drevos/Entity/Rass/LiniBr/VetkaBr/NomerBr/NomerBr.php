<?php

declare(strict_types=1);

namespace App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\NomerBr;

use App\Model\Drevos\Entity\Rass\LiniBr\LiniBr;

use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\VetkaBr;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="dre_ras_linibr_vet_noms")
 */
class NomerBr
{

    /**
     * @var VetkaBr
     * @ORM\ManyToOne(targetEntity="App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\VetkaBr", inversedBy="nomers")
     * @ORM\JoinColumn(name="vetka_id", referencedColumnName="id", nullable=false)
     */
    private $vetka;
	
    /**
     * @var Id
     * @ORM\Column(type="dre_ras_linibr_vet_nom_id")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $nomBr;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $god;

	 /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $sortNom;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @var Status
     * @ORM\Column(type="dre_ras_linibr_vet_nom_status", length=16)
     */
    private $status;

    public function __construct(VetkaBr $vetka, Id $id,
                                string $nomBr,
                                string $god,
								int $sortNom,
                                string $title

                                )
    {
        $this->vetka = $vetka;
        $this->id = $id;
        $this->nomBr = $nomBr;
        $this->god = $god;
		$this->sortNom = $sortNom;
        $this->title = $title;

        $this->status = Status::ojidaet();

    }

	public function edit(string $nomBr, string $god): void
    {
        $this->nomBr = $nomBr;
        $this->god = $god;
    }

    //------------------------------------------------------
    public function archive(): void
    {
        if ($this->isArchived()) {
            throw new \DomainException('Номер уже заархивирован.');
        }
        $this->status = Status::archived();
    }


    public function getTitle(): string
    {
        return $this->title;
    }


    public function getStatus(): Status
    {
        return $this->status;
    }

    public function reinstate(): void
    {
        if ($this->isActive()) {
            throw new \DomainException('Номер уже активен.?');
        }
        $this->status = Status::active();
    }

    public function ojidaetActive(): void
    {
        if ($this->isActive()) {
            throw new \DomainException('Номер уже активен.?');
        }
        $this->status = Status::active();

    }

    public function activeOjidaet(): void
    {
        if ($this->isOjidaet()) {
            throw new \DomainException('Номер уже ожидает');
        }
        $this->status = Status::ojidaet();

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

	
// равно Ли Имя
    public function isNomerEqual(string $nomBr): bool
    {
        return $this->nomBr === $nomBr;
    }


    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return VetkaBr
     */
    public function getVetka(): VetkaBr
    {
        return $this->vetka;
    }


    public function getNomBr(): string
    {
        return $this->nomBr;
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
    public function getSortNom(): int
    {
        return $this->sortNom;
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
