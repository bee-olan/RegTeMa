<?php

declare(strict_types=1);

namespace App\Model\Adminka\Entity\Matkas\PlemMatka;

use App\Model\Adminka\Entity\Matkas\Kategoria\Kategoria;

use App\Model\Adminka\Entity\Matkas\PlemMatka\Department\Department;
use App\Model\Adminka\Entity\Matkas\PlemMatka\Department\Id as DepartmentId;


use App\Model\Adminka\Entity\Matkas\Role\Role;
use App\Model\Adminka\Entity\Rasas\Linias\Nomers\Nomer;
use App\Model\Adminka\Entity\Uchasties\Personas\Persona;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Uchastie;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchastieId;

use App\Model\Mesto\Entity\InfaMesto\MestoNomer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="admin_matkas_plemmatkas")
 */
class PlemMatka
{
    /**
     * @var Id
     * @ORM\Column(type="admin_matkas_plemmatka_id")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

//    /**
//     * @var string
//     * @ORM\Column(type="string", name="uchastie_id")
//     */
//    private $uchastieId;

//    /**
//     * @var string
//     * @ORM\Column(type="string", name="rasa_nom_id")
//     */
    /**
     * @var Nomer
     * @ORM\ManyToOne(targetEntity="App\Model\Adminka\Entity\Rasas\Linias\Nomers\Nomer")
     * @ORM\JoinColumn(name="nomer_id", referencedColumnName="id", nullable=false)
     */
    private $nomer;

//    /**
//     * @var string
//     * @ORM\Column(type="string")
//     */
    /**
     * @var MestoNomer
     * @ORM\ManyToOne(targetEntity="App\Model\Mesto\Entity\InfaMesto\MestoNomer")
     * @ORM\JoinColumn(name="mesto_id", referencedColumnName="id", nullable=false)
     */
      private $mesto;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $title;

//    /**
//     * @var int
//     * @ORM\Column(type="integer")
//     */
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
     * @ORM\Column(type="admin_matkas_plemmatka_status", length=16)
     */
    private $status;


    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $godaVixod;

    /**
     * @var Kategoria
     * @ORM\ManyToOne(targetEntity="App\Model\Adminka\Entity\Matkas\Kategoria\Kategoria")
     * @ORM\JoinColumn(name="kategoria_id", referencedColumnName="id", nullable=false)
     */
    private $kategoria;

    /**
     * @var ArrayCollection|Department[]
     * @ORM\OneToMany(
     *     targetEntity="App\Model\Adminka\Entity\Matkas\PlemMatka\Department\Department",
     *     mappedBy="plemmatka", orphanRemoval=true, cascade={"all"}
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $departments;

    /**
     * @var ArrayCollection|Uchastnik[]
     * @ORM\OneToMany(targetEntity="Uchastnik", mappedBy="plemmatka", orphanRemoval=true, cascade={"all"})
     */
    private $uchastniks;

// string $uchastieId,

//                                 string $nameKateg,
//
//
    public function __construct( Id $id,
                                 string $name,
                                 int $sort,
                                 string $title,
                                 int $godaVixod,
                                 MestoNomer  $mesto,
                                 Nomer $nomer,
                                 Persona  $persona,
                                 Kategoria $kategoria
                                  )
    {
        $this->id = $id;
        $this->name = $name;
        $this->sort = $sort;
        $this->title = $title;
        $this->godaVixod = $godaVixod;
        $this->kategoria = $kategoria;
        $this->mesto = $mesto;
        $this->persona = $persona;
        $this->nomer = $nomer;
        $this->status = Status::active();

        $this->departments = new ArrayCollection();
        $this->uchastniks = new ArrayCollection();

    }


    public function edit( string $title): void
    {
        $this->title = $title;
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
    ////////////////
    public function addDepartment(DepartmentId $id, string $name): void
    {
        foreach ($this->departments as $department) {
            if ($department->isNameEqual($name)) {
                throw new \DomainException('Отдел уже существует.');
            }
        }
        $this->departments->add(new Department($this, $id, $name));
    }

    public function editDepartment(DepartmentId $id, string $name): void
    {
        foreach ($this->departments as $current) {
            if ($current->getId()->isEqual($id)) {
                $current->edit($name);
                return;
            }
        }
        throw new \DomainException('Отдел не найден.');
    }

    public function removeDepartment(DepartmentId $id): void
    {
        foreach ($this->departments as $department) {
            if ($department->getId()->isEqual($id)) {
                foreach ($this->uchastniks as $uchastnik) {
                     if ($uchastnik->isForDepartment($id)) {
                         throw new \DomainException('Не удалось удалить отдел с участиемs.');
                     }
                }
                $this->departments->removeElement($department);
                return;
            }
        }
        throw new \DomainException('Отдел не найден.');
    }
    ///////


    public function hasUchastie(UchastieId $id): bool
    {
        foreach ($this->uchastniks as $uchastnik) {
            if ($uchastnik->isForUchastie($id)) {
                return true;
            }
        }
        return false;
    }


    /**
     * @param Uchastie $uchastie
     * @param DepartmentId[] $departmentIds
     * @param Role[] $roles
     * @throws \Exception
     */
    public function addUchastie(Uchastie $uchastie, array $departmentIds, array $roles): void
    {
        foreach ($this->uchastniks as $uchastnik) {
            if ($uchastnik->isForUchastie($uchastie->getId())) {
                throw new \DomainException('Такой участник уже добавлен.');
            }
        }
        $departments = array_map([$this, 'getDepartment'], $departmentIds);
        $this->uchastniks->add(new Uchastnik($this, $uchastie, $departments, $roles));
    }

    /**
     * @param UchastieId $uchastie
     * @param DepartmentId[] $departmentIds
     * @param Role[] $roles
     */
    public function editUchastie(UchastieId $uchastie, array $departmentIds, array $roles): void
    {
        foreach ($this->uchastniks as $uchastnik) {
            if ($uchastnik->isForUchastie($uchastie)) {
                $uchastnik->changeDepartments(array_map([$this, 'getDepartment'], $departmentIds));
                $uchastnik->changeRoles($roles);
                return;
            }
        }
        throw new \DomainException('Участие не найдено.');
    }

    /**
     * @param UchastieId $uchastie
     * @param DepartmentId[] $departmentIds
//     * @param Role[] $roles
     */
    public function editSezonUchastie(UchastieId $uchastie, array $departmentIds): void
    {
        foreach ($this->uchastniks as $uchastnik) {
            if ($uchastnik->isForUchastie($uchastie)) {
                $uchastnik->changeDepartments(array_map([$this, 'getDepartment'], $departmentIds));
//                $uchastnik->changeRoles($roles);
                return;
            }
        }
        throw new \DomainException('Участие не найдено.');
    }

    public function removeUchastie(UchastieId $uchastie): void
    {
        foreach ($this->uchastniks as $uchastnik) {
            if ($uchastnik->isForUchastie($uchastie)) {
                $this->uchastniks->removeElement($uchastnik);
                return;
            }
        }
        throw new \DomainException('Участие не найдено.');
    }

// если есть у пользователя разрешение
    public function isUchastieGranted(UchastieId $id, string $permission): bool
    {
        foreach ($this->uchastniks as $uchastnik) {
            if ($uchastnik->isForUchastie($id)) {
                return $uchastnik->isGranted($permission);
            }
        }
        return false;
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

    public function getTitle(): string
    {
        return $this->title;
    }
    public function getSort(): int
    {
        return $this->sort;
    }
    public function getStatus(): Status
    {
        return $this->status;
    }
    /**
     * @return int
     */
    public function getGodaVixod(): int
    {
        return $this->godaVixod;
    }


    public function getUchastniks()
    {
        return $this->uchastniks->toArray();
    }


    public function getUchastnik(UchastieId $id): Uchastnik
    {
        foreach ($this->uchastniks as $uchastnik) {
            if ($uchastnik->isForUchastie($id)) {
                return $uchastnik;
            }
        }
        throw new \DomainException('Такого участника  нет.');
    }


    public function getKategoria(): Kategoria
    {
        return $this->kategoria;
    }

    public function getMesto(): MestoNomer
    {
        return $this->mesto;
    }

    public function getPersona(): Persona
    {
        return $this->persona;
    }


    public function getNomer(): Nomer
    {
        return $this->nomer;
    }



    public function getDepartments()
    {
        return $this->departments->toArray();
    }


    public function getDepartment(DepartmentId $id): Department
    {
        foreach ($this->departments as $department) {
            if ($department->getId()->isEqual($id)) {
                return $department;
            }
        }
        throw new \DomainException('раздел  не найден.');
    }


}
