<?php

declare(strict_types=1);

namespace App\Model\Adminka\Entity\DrevMatkas;

use App\Model\Adminka\Entity\DrevMatkas\SezonDrev\SezonDrev;
use App\Model\Adminka\Entity\DrevMatkas\SezonDrev\Id as SezonDrevId;

use App\Model\Adminka\Entity\Uchasties\Uchastie\Uchastie;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchastieId;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="adm_drev_uchasdrevs", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"plemmatka_id", "uchastie_id"})
 * })
 */
class UchasDrev
{
    /**
     * @var string
     * @ORM\Column(type="guid")
     * @ORM\Id
     */
    private $id;

    /**
     * @var DrevMatka
     * @ORM\ManyToOne(targetEntity="DrevMatka", inversedBy="uchasdrev")
     * @ORM\JoinColumn(name="plemmatka_id", referencedColumnName="id", nullable=false)
     */
    private $plemmatka;

    /**
     * @var Uchastie
     * @ORM\ManyToOne(targetEntity="App\Model\Adminka\Entity\Uchasties\Uchastie\Uchastie")
     * @ORM\JoinColumn(name="uchastie_id", referencedColumnName="id", nullable=false)
     */
    private $uchastie;

    /**
     * @var ArrayCollection|SezonDrev[]
     * @ORM\ManyToMany(targetEntity="App\Model\Adminka\Entity\DrevMatkas\SezonDrev\SezonDrev")
     * @ORM\JoinTable(name="adm_drev_uchasdrev_sezondrevs",
     *     joinColumns={@ORM\JoinColumn(name="uchasdrev_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="sezondrev_id", referencedColumnName="id")}
     * )
     */
    private $sezondrevs;


    /**
     * UchasDrev constructor.
     * @param DrevMatka $plemmatka
     * @param Uchastie $uchastie
     * @param ArrayCollection|SezonDrev[] $sezondrevs
     * @throws \Exception
     */
    public function __construct(DrevMatka $plemmatka, Uchastie $uchastie ,
                                array $sezondrevs)
    {
        $this->guardSezonDrevs($sezondrevs);

        $this->id = Uuid::uuid4()->toString();
        $this->plemmatka = $plemmatka;
        $this->uchastie = $uchastie;
        $this->sezondrevs = new ArrayCollection($sezondrevs);
    }
    /**
     * @param SezonDrev[] $sezondrevs
     */
    public function changeSezonDrevs(array $sezondrevs): void
    {
        $this->guardSezonDrevs($sezondrevs);

        $current = $this->sezondrevs->toArray();
        $new = $sezondrevs;

        $compare = static function (SezonDrev $a, SezonDrev $b): int {
            return $a->getId()->getValue() <=> $b->getId()->getValue();
        };

        foreach (array_udiff($current, $new, $compare) as $item) {
            $this->sezondrevs->removeElement($item);
        }

        foreach (array_udiff($new, $current, $compare) as $item) {
            $this->sezondrevs->add($item);
        }
    }


    public function isForUchastie(UchastieId $id): bool
    {
        return $this->uchastie->getId()->isEqual($id);
    }

    public function isForSezonDrev(SezonDrevId $id): bool
    {
        foreach ($this->sezondrevs as $sezondrev) {
            if ($sezondrev->getId()->isEqual($id)) {
                return true;
            }
        }
        return false;
    }


    public function getUchastie(): Uchastie
    {
        return $this->uchastie;
    }


    public function getId(): string
    {
        return $this->id;
    }


    public function getPlemmatka(): DrevMatka
    {
        return $this->plemmatka;
    }


    public function getSezonDrevs(): array
    {
        return $this->sezondrevs->toArray();
    }

    public function guardSezonDrevs(array $sezondrevs): void
    {
        if (\count($sezondrevs) === 0) {
            throw new \DomainException('Установите хотя бы один сезон.');
        }
    }

}