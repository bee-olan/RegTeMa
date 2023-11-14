<?php

declare(strict_types=1);

namespace App\Model\Adminka\Entity\DrevMatkas;

use App\Model\Adminka\Entity\DrevMatkas\SezonDrev\SezonDrev;
use App\Model\Adminka\Entity\DrevMatkas\SezonDrev\Id as SezonDrevId;
use App\Model\Adminka\Entity\DrevMatkas;
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

    /**
     * @var ArrayCollection|SezonDrev[]
     * @ORM\OneToMany(
     *     targetEntity="App\Model\Adminka\Entity\DrevMatkas\SezonDrev\SezonDrev",
     *     mappedBy="plemmatka", orphanRemoval=true, cascade={"all"}
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $sezondrevs;

    /**
     * @var ArrayCollection|UchasDrev[]
     * @ORM\OneToMany(targetEntity="UchasDrev", mappedBy="plemmatka", orphanRemoval=true, cascade={"all"})
     */
    private $uchasdrevs;

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

        $this->sezondrevs = new ArrayCollection();
        $this->uchasdrevs = new ArrayCollection();
    }

    ////////////////
    public function addSezonDrev(SezonDrevId $id, string $name): void
    {
        foreach ($this->sezondrevs as $sezondrev) {
            if ($sezondrev->isNameEqual($name)) {
                throw new \DomainException('Сезон уже существует.');
            }
        }
        $this->sezondrevs->add(new SezonDrev($this, $id, $name));
    }

    public function editSezonDrev(SezonDrevId $id, string $name): void
    {
        foreach ($this->sezondrevs as $current) {
            if ($current->getId()->isEqual($id)) {
                $current->edit($name);
                return;
            }
        }
        throw new \DomainException('Сезон не найден.');
    }

    public function removeSezonDrev(SezonDrevId $id): void
    {
        foreach ($this->sezondrevs as $sezondrev) {
            if ($sezondrev->getId()->isEqual($id)) {
                foreach ($this->uchasdrevs as $uchasdrev) {
                    if ($uchasdrev->isForSezonDrev($id)) {
                        throw new \DomainException('Не удалось удалить отдел с участиемs.');
                    }
                }
                $this->sezondrevs->removeElement($sezondrev);
                return;
            }
        }
        throw new \DomainException('Сезон не найден.');
    }
    ///////
    public function hasUchastie(UchastieId $id): bool
    {
        foreach ($this->uchasdrevs as $uchasdrev) {
            if ($uchasdrev->isForUchastie($id)) {
                return true;
            }
        }
        return false;
    }


    /**
     * @param Uchastie $uchastie
     * @param SezonDrevId[] $sezondrevIds
     * @throws \Exception
     */
    public function addUchastie(Uchastie $uchastie, array $sezondrevIds): void
    {
        foreach ($this->uchasdrevs as $uchasdrev) {
            if ($uchasdrev->isForUchastie($uchastie->getId())) {
                throw new \DomainException('Такой участник уже добавлен.');
            }
        }
        $sezondrevs = array_map([$this, 'getSezondrev'], $sezondrevIds);
        $this->uchasdrevs->add(new UchasDrev($this, $uchastie, $sezondrevs));
    }

    /**
     * @param UchastieId $uchastie
     * @param SezonDrevId[] $sezondrevIds
     */
    public function editUchastie(UchastieId $uchastie, array $sezondrevIds): void
    {
        foreach ($this->uchasdrevs as $uchasdrev) {
            if ($uchasdrev->isForUchastie($uchastie)) {
                $uchasdrev->changeDepartments(array_map([$this, 'getSezondrev'], $sezondrevIds));
//                $uchasdrev->changeRoles($roles);
                return;
            }
        }
        throw new \DomainException('Участие не найдено.');
    }

    /**
     * @param UchastieId $uchastie
     * @param SezonDrevId[] $sezondrevIds
     */
    public function editSezonUchastie(UchastieId $uchastie, array $sezondrevIds): void
    {
        foreach ($this->uchasdrevs as $uchasdrev) {
            if ($uchasdrev->isForUchastie($uchastie)) {
                $uchasdrev->changeDepartments(array_map([$this, 'getSezondrev'], $sezondrevIds));
//                $uchasdrev->changeRoles($roles);
                return;
            }
        }
        throw new \DomainException('Участие не найдено.');
    }

    public function removeUchastie(UchastieId $uchastie): void
    {
        foreach ($this->uchasdrevs as $uchasdrev) {
            if ($uchasdrev->isForUchastie($uchastie)) {
                $this->uchasdrevs->removeElement($uchasdrev);
                return;
            }
        }
        throw new \DomainException('Участие не найдено.');
    }

// если есть у пользователя разрешение !!!!!!!!!!!!!!!!!!!!!!!!!
    public function isUchastieGranted(UchastieId $id, string $permission): bool
    {
        foreach ($this->uchasdrevs as $uchasdrev) {
            if ($uchasdrev->isForUchastie($id)) {
                return $uchasdrev->isGranted($permission);
            }
        }
        return false;
    }
    ///

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

    public function getSezondrevs()
    {
        return $this->sezondrevs->toArray();
    }

    public function getSezondrev(SezonDrevId $id): SezonDrev
    {
        foreach ($this->sezondrevs as $sezondrev) {
            if ($sezondrev->getId()->isEqual($id)) {
                return $sezondrev;
            }
        }
        throw new \DomainException('сезон  не найден.');
    }


    public function getUchasdrevs()
    {
        return $this->uchasdrevs->toArray();;
    }

//    public function getUchasdrev(UchastieId $id): UchasDrev
//    {
//        foreach ($this->uchasdrevs as $uchasdrev) {
//            if ($uchasdrev->getId()->isEqual($id)) {
//                return $uchasdrev;
//            }
//        }
//        throw new \DomainException('сезон  не найден.');
//    }
}
