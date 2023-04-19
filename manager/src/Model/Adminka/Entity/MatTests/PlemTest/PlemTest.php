<?php

declare(strict_types=1);

namespace App\Model\Adminka\Entity\MatTests\PlemTest;

//use App\Model\Adminka\Entity\Matkas\PlemMatka\Sezon\Sezon;
//use App\Model\Adminka\Entity\Matkas\PlemMatka\Sezon\Id as SezonId;

//use App\Model\Adminka\Entity\Uchasties\Uchastie\Uchastie;
//use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchastieId;
//
//use App\Model\Mesto\Entity\InfaMesto\MestoNomer;
//use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="admin_mattest_plemtests")
 */
class PlemTest
{
    /**
     * @var Id
     * @ORM\Column(type="admin_mattest_plemtest_id")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $star_linia;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $star_nomer;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $title;


    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $sort;

    /**
     * @var Status
     * @ORM\Column(type="admin_mattest_plemtest_status", length=16)
     */
    private $status;


    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $godaVixod;


//    /**
//     * @var ArrayCollection|Sezon[]
//     * @ORM\OneToMany(
//     *     targetEntity="App\Model\Adminka\Entity\Matkas\PlemMatka\Sezon\Sezon",
//     *     mappedBy="plemmatka", orphanRemoval=true, cascade={"all"}
//     * )
//     * @ORM\OrderBy({"name" = "ASC"})
//     */
//    private $sezons;

    public function __construct( Id $id,
                                 string $name,
                                 int $sort,
                                 string $title,
                                 int $godaVixod,
                                 string $star_linia,
                                 string $star_nomer

                                  )
    {
        $this->id = $id;
        $this->name = $name;
        $this->sort = $sort;
        $this->title = $title;
        $this->godaVixod = $godaVixod;
        $this->star_linia = $star_linia;
        $this->star_nomer = $star_nomer;

        $this->status = Status::active();

//        $this->sezons = new ArrayCollection();
//        $this->uchastniks = new ArrayCollection();

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
//    public function addSezon(SezonId $id, string $name): void
//    {
//        foreach ($this->sezons as $sezon) {
//            if ($sezon->isNameEqual($name)) {
//                throw new \DomainException('Отдел уже существует.');
//            }
//        }
//        $this->sezons->add(new Sezon($this, $id, $name));
//    }
//
//    public function editSezon(SezonId $id, string $name): void
//    {
//        foreach ($this->sezons as $current) {
//            if ($current->getId()->isEqual($id)) {
//                $current->edit($name);
//                return;
//            }
//        }
//        throw new \DomainException('Отдел не найден.');
//    }
//
//    public function removeSezon(SezonId $id): void
//    {
//        foreach ($this->sezons as $sezon) {
//            if ($sezon->getId()->isEqual($id)) {
//                foreach ($this->uchastniks as $uchastnik) {
//                     if ($uchastnik->isForSezon($id)) {
//                         throw new \DomainException('Не удалось удалить отдел с участиемs.');
//                     }
//                }
//                $this->sezons->removeElement($sezon);
//                return;
//            }
//        }
//        throw new \DomainException('Отдел не найден.');
//    }
    ///////

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

    public function getGodaVixod(): int
    {
        return $this->godaVixod;
    }


    public function getStarLinia(): string
    {
        return $this->star_linia;
    }

    public function getStarNomer(): string
    {
        return $this->star_nomer;
    }


//    public function getSezons()
//    {
//        return $this->sezons->toArray();
//    }
//
//
//    public function getSezon(SezonId $id): Sezon
//    {
//        foreach ($this->sezons as $sezon) {
//            if ($sezon->getId()->isEqual($id)) {
//                return $sezon;
//            }
//        }
//        throw new \DomainException('раздел  не найден.');
//    }

}
