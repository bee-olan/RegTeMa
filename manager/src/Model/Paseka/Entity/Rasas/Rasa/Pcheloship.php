<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Rasas\Rasa;

use App\Model\Paseka\Entity\Pchelowods\Pchelowod\Id as PchelowodId;
use App\Model\Paseka\Entity\Pchelowods\Pchelowod\Pchelowod;
use App\Model\Paseka\Entity\Rasas\Rasa\Linia\Linia;
use App\Model\Paseka\Entity\Rasas\Rasa\Linia\Id as LiniaId;
use App\Model\Paseka\Entity\Rasas\Kategor\Kategor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="paseka_rasas_rasas_pcheloships", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"rasa_id", "pchelowod_id"})
 * })
 */
class Pcheloship
{
    /**
     * @var string
     * @ORM\Column(type="guid")
     * @ORM\Id
     */
    private $id;
    /**
     * @var Rasa
     * @ORM\ManyToOne(targetEntity="Rasa", inversedBy="pcheloships")
     * @ORM\JoinColumn(name="rasa_id", referencedColumnName="id", nullable=false)
     */
    private $rasa;
    /**
     * @var Pchelowod
     * @ORM\ManyToOne(targetEntity="App\Model\Paseka\Entity\Pchelowods\Pchelowod\Pchelowod")
     * @ORM\JoinColumn(name="pchelowod_id", referencedColumnName="id", nullable=false)
     */
    private $pchelowod;


    /**
     * @var ArrayCollection|Linia[]
     * @ORM\ManyToMany(targetEntity="App\Model\Paseka\Entity\Rasas\Rasa\Linia\Linia")
     * @ORM\JoinTable(name="paseka_rasas_rasa_pcheloship_linias",
     *     joinColumns={@ORM\JoinColumn(name="pcheloship_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="linias_id", referencedColumnName="id")}
     * )
     */
    private $linias;

    /**
     * @var ArrayCollection|Kategor[]
     * @ORM\ManyToMany(targetEntity="App\Model\Paseka\Entity\Rasas\Kategor\Kategor")
     * @ORM\JoinTable(name="paseka_rasas_rasa_pcheloship_kategors",
     *     joinColumns={@ORM\JoinColumn(name="pcheloship_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="kategor_id", referencedColumnName="id")}
     * )
     */
    private $kategors;

    /**
     * Pcheloship constructor.
     * @param Rasa $rasa
     * @param Pchelowod $pchelowod
     * @param ArrayCollection|Linia[] $linias
     * @param ArrayCollection|Kategor[] $kategors
     * @throws \Exception
     */
    public function __construct(Rasa $rasa, Pchelowod $pchelowod, array $linias, array $kategors)
    {
        $this->guardLinias($linias);
        $this->guardKategors($kategors);

        $this->id = Uuid::uuid4()->toString();
        $this->rasa = $rasa;
        $this->pchelowod = $pchelowod;
        $this->linias = new ArrayCollection($linias);
        $this->kategors = new ArrayCollection($kategors);
    }


    /**
     * @param Linia[] $linias
     */
    public function changeLinias(array $linias): void
    {
        $this->guardLinias($linias);

        $current = $this->linias->toArray();
        $new = $linias;

        $compare = static function (Linia $a, Linia $b): int {
            return $a->getId()->getValue() <=> $b->getId()->getValue();
        };

        foreach (array_udiff($current, $new, $compare) as $item) {
            $this->linias->removeElement($item);
        }

        foreach (array_udiff($new, $current, $compare) as $item) {
            $this->linias->add($item);
        }
    }

    /**
     * @param Kategor[] $kategors
     */
    public function changeKategors(array $kategors): void
    {
        $this->guardKategors($kategors);

        $current = $this->kategors->toArray();
        $new = $kategors;

        $compare = static function (Kategor $a, Kategor $b): int {
            return $a->getId()->getValue() <=> $b->getId()->getValue();
        };

        foreach (array_udiff($current, $new, $compare) as $item) {
            $this->kategors->removeElement($item);
        }

        foreach (array_udiff($new, $current, $compare) as $item) {
            $this->kategors->add($item);
        }
    }

    public function isForPchelowod(PchelowodId $id): bool
    {
        return $this->pchelowod->getId()->isEqual($id);
    }

    public function isForLinia(LiniaId $id): bool
    {
        foreach ($this->linias as $linia) {
            if ($linia->getId()->isEqual($id)) {
                return true;
            }
        }
        return false;
    }

    public function isGranted(string $permission): bool
    {
        foreach ($this->kategors as $kategor) {
            if ($kategor->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    public function getPchelowod(): Pchelowod
    {
        return $this->pchelowod;
    }

    /**
     * @return Kategor[]
     */
    public function getKategors(): array
    {
        return $this->kategors->toArray();
    }

    /**
     * @return Linia[]
     */
    public function getLinias(): array
    {
        return $this->linias->toArray();
    }

    public function guardLinias(array $linias): void
    {
        if (\count($linias) === 0) {
            throw new \DomainException('Set at least one linia.');
        }
    }

    public function guardKategors(array $kategors): void
    {
        if (\count($kategors) === 0) {
            throw new \DomainException('Set at least one kategor.');
        }
    }
}
