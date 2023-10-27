<?php

declare(strict_types=1);

namespace App\Model\Adminka\Entity\DrevMatkas;


use App\Model\Adminka\Entity\Uchasties\Personas\Persona;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Uchastie;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchastieId;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\Nom;
use App\Model\Mesto\Entity\InfaMesto\MestoNomer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="admin_drevmatkas")
 */
class DrevMatka
{
    /**
     * @var Id
     * @ORM\Column(type="admin_drevmatka_id")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    private $korotkoName;

    /**
     * @var Nom
     * @ORM\ManyToOne(targetEntity="App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\Nom")
     * @ORM\JoinColumn(name="nomer_id", referencedColumnName="id", nullable=false)
     */
    private $nomer;

    /**
     * @var MestoNomer
     * @ORM\ManyToOne(targetEntity="App\Model\Mesto\Entity\InfaMesto\MestoNomer")
     * @ORM\JoinColumn(name="mesto_id", referencedColumnName="id", nullable=false)
     */
      private $mesto;

//    /**
//     * @var string
//     * @ORM\Column(type="string")
//     */
//    private $title;

    /**
     * @var Persona
     * @ORM\ManyToOne(targetEntity="App\Model\Adminka\Entity\Uchasties\Personas\Persona")
     * @ORM\JoinColumn(name="persona_id", referencedColumnName="id", nullable=false)
     */
    private $persona;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $sort;

    /**
     * @var Status
     * @ORM\Column(type="admin_drevmatka_status", length=16)
     */
    private $status;


//    /**
//     * @var int
//     * @ORM\Column(type="integer")
//     */
//    private $godaVixod;

//    /**
//     * @var Kategoria
//     * @ORM\ManyToOne(targetEntity="App\Model\Adminka\Entity\Matkas\Kategoria\Kategoria")
//     * @ORM\JoinColumn(name="kategoria_id", referencedColumnName="id", nullable=false)
//     */
//    private $kategoria;

//    /**
//     * @var OtecNomer
//     * @ORM\ManyToOne(targetEntity="App\Model\Adminka\Entity\OtecForRas\Linias\Nomers\Nomer")
//     * @ORM\JoinColumn(name="otec_nomer_id", referencedColumnName="id", nullable=false)
//     */
//    private $otecNomer;

//    /**
//     * @var ArrayCollection|Department[]
//     * @ORM\OneToMany(
//     *     targetEntity="App\Model\Adminka\Entity\Matkas\PlemMatka\Department\Department",
//     *     mappedBy="plemmatka", orphanRemoval=true, cascade={"all"}
//     * )
//     * @ORM\OrderBy({"name" = "ASC"})
//     */
//    private $departments;
//
//    /**
//     * @var ArrayCollection|Uchastnik[]
//     * @ORM\OneToMany(targetEntity="Uchastnik", mappedBy="plemmatka", orphanRemoval=true, cascade={"all"})
//     */
//    private $uchastniks;

    public function __construct( Id $id,
                                 string $name,
                                 int $sort,
                                 MestoNomer  $mesto,
                                 Nom $nomer,
                                 Persona  $persona

                                  )
    {
        $this->id = $id;
        $this->name = $name;
        $this->sort = $sort;
        $this->mesto = $mesto;
        $this->persona = $persona;
        $this->nomer = $nomer;
        $this->status = Status::active();

    }



    public function archive(): void
    {
        if ($this->isArchived()) {
            throw new \DomainException('ПлемМатка уже заархивирована.');
        }
        $this->status = Status::archived();
    }

    public function reinstate(): void
    {
        if ($this->isActive()) {
            throw new \DomainException('ПлемМатка уже активена.');
        }
        $this->status = Status::active();
    }



    public function isArchived(): bool
    {
        return $this->status->isArchived();
    }

    public function isActive(): bool
    {
        return $this->status->isActive();
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

//    public function getKorotkoName(): string
//    {
//
//        $korotkoNames= explode(" ",$this->getName() );
//
//
//        return $this->korotkoName = $korotkoNames[0]."-";
//    }


    public function getSort(): int
    {
        return $this->sort;
    }
    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getMesto(): MestoNomer
    {
        return $this->mesto;
    }

    public function getPersona(): Persona
    {
        return $this->persona;
    }

    public function getNomer(): Nom
    {
        return $this->nomer;
    }


}
