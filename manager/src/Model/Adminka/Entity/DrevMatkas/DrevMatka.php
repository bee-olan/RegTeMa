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
//    ////////////////
//    public function addDepartment(DepartmentId $id, string $name): void
//    {
//        foreach ($this->departments as $department) {
//            if ($department->isNameEqual($name)) {
//                throw new \DomainException('Отдел уже существует.');
//            }
//        }
//        $this->departments->add(new Department($this, $id, $name));
//    }
//
//    public function editDepartment(DepartmentId $id, string $name): void
//    {
//        foreach ($this->departments as $current) {
//            if ($current->getId()->isEqual($id)) {
//                $current->edit($name);
//                return;
//            }
//        }
//        throw new \DomainException('Отдел не найден.');
//    }
//
//    public function removeDepartment(DepartmentId $id): void
//    {
//        foreach ($this->departments as $department) {
//            if ($department->getId()->isEqual($id)) {
//                foreach ($this->uchastniks as $uchastnik) {
//                     if ($uchastnik->isForDepartment($id)) {
//                         throw new \DomainException('Не удалось удалить отдел с участиемs.');
//                     }
//                }
//                $this->departments->removeElement($department);
//                return;
//            }
//        }
//        throw new \DomainException('Отдел не найден.');
//    }
//    ///////


//    public function hasUchastie(UchastieId $id): bool
//    {
//        foreach ($this->uchastniks as $uchastnik) {
//            if ($uchastnik->isForUchastie($id)) {
//                return true;
//            }
//        }
//        return false;
//    }
//
//
//    /**
//     * @param Uchastie $uchastie
//     * @param DepartmentId[] $departmentIds
//     * @param Role[] $roles
//     * @throws \Exception
//     */
//    public function addUchastie(Uchastie $uchastie, array $departmentIds, array $roles): void
//    {
//        foreach ($this->uchastniks as $uchastnik) {
//            if ($uchastnik->isForUchastie($uchastie->getId())) {
//                throw new \DomainException('Такой участник уже добавлен.');
//            }
//        }
//        $departments = array_map([$this, 'getDepartment'], $departmentIds);
//        $this->uchastniks->add(new Uchastnik($this, $uchastie, $departments, $roles));
//    }
//
//    /**
//     * @param UchastieId $uchastie
//     * @param DepartmentId[] $departmentIds
//     * @param Role[] $roles
//     */
//    public function editUchastie(UchastieId $uchastie, array $departmentIds, array $roles): void
//    {
//        foreach ($this->uchastniks as $uchastnik) {
//            if ($uchastnik->isForUchastie($uchastie)) {
//                $uchastnik->changeDepartments(array_map([$this, 'getDepartment'], $departmentIds));
//                $uchastnik->changeRoles($roles);
//                return;
//            }
//        }
//        throw new \DomainException('Участие не найдено.');
//    }
//
//    /**
//     * @param UchastieId $uchastie
//     * @param DepartmentId[] $departmentIds
////     * @param Role[] $roles
//     */
//    public function editSezonUchastie(UchastieId $uchastie, array $departmentIds): void
//    {
//        foreach ($this->uchastniks as $uchastnik) {
//            if ($uchastnik->isForUchastie($uchastie)) {
//                $uchastnik->changeDepartments(array_map([$this, 'getDepartment'], $departmentIds));
////                $uchastnik->changeRoles($roles);
//                return;
//            }
//        }
//        throw new \DomainException('Участие не найдено.');
//    }
//
//    public function removeUchastie(UchastieId $uchastie): void
//    {
//        foreach ($this->uchastniks as $uchastnik) {
//            if ($uchastnik->isForUchastie($uchastie)) {
//                $this->uchastniks->removeElement($uchastnik);
//                return;
//            }
//        }
//        throw new \DomainException('Участие не найдено.');
//    }
//
//// если есть у пользователя разрешение !!!!!!!!!!!!!!!!!!!!!!!!!
//    public function isUchastieGranted(UchastieId $id, string $permission): bool
//    {
//        foreach ($this->uchastniks as $uchastnik) {
//            if ($uchastnik->isForUchastie($id)) {
//                return $uchastnik->isGranted($permission);
//            }
//        }
//        return false;
//    }


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

    public function getKorotkoName(): string
    {

        $korotkoNames= explode(" ",$this->getName() );

//        dd(  $this->godaVixod);
        return $this->korotkoName = $korotkoNames[0]."-";
    }


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
