<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Rasas\Rasa;

use App\Model\Paseka\Entity\Rasas\Rasa\Linia\Linia;
use App\Model\Paseka\Entity\Rasas\Rasa\Linia\Id as LiniaId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="paseka_rasas_rasas")
 */
class Rasa
{
    /**
     * @var Id
     * @ORM\Column(type="paseka_rasas_rasa_id")
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
    private $psewdo;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $sort;

    // /**
    //  * @var Status
    //  * @ORM\Column(type="work_projects_project_status", length=16)
    //  */
    // private $status;

    /**
     * @var ArrayCollection|Linia[]
     * @ORM\OneToMany(
     *     targetEntity="App\Model\Paseka\Entity\Rasas\Rasa\Linia\Linia",
     *     mappedBy="rasa", orphanRemoval=true, cascade={"all"}
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $linias;

    public function __construct(Id $id, string $name, string $psewdo, int $sort)
    {
        $this->id = $id;
        $this->name = $name;
        $this->psewdo = $psewdo;
        $this->sort = $sort;
        // $this->status = Status::active();
        $this->linias = new ArrayCollection();
    }

    public function edit(string $name, string $psewdo, int $sort): void
    {
        $this->name = $name;
        $this->psewdo = $psewdo;
        $this->sort = $sort;
    }

    // public function archive(): void
    // {
    //     if ($this->isArchived()) {
    //         throw new \DomainException('Project is already archived.');
    //     }
    //     $this->status = Status::archived();
    // }

    // public function reinstate(): void
    // {
    //     if ($this->isActive()) {
    //         throw new \DomainException('Project is already active.');
    //     }
    //     $this->status = Status::active();
    // }

    public function addLinia(LiniaId $id, string $name): void
    {
        foreach ($this->linias as $linia) {
            if ($linia->isNameEqual($name)) {
                throw new \DomainException('Department already exists.');
            }
        }
        $this->linias->add(new Linia($this, $id, $name));
    }

    public function editLinia(LiniaId $id, string $name): void
    {
        foreach ($this->linias as $current) {
            if ($current->getId()->isEqual($id)) {
                $current->edit($name);
                return;
            }
        }
        throw new \DomainException('Department is not found.');
    }

    public function removeLinia(LiniaId $id): void
    {
        foreach ($this->linias as $linia) {
            if ($linia->getId()->isEqual($id)) {
                $this->linias->removeElement($linia);
                return;
            }
        }
        throw new \DomainException('Department is not found.');
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

    public function getPsewdo(): string
    {
        return $this->psewdo;
    }

    public function getSort(): int
    {
        return $this->sort;
    }

    // public function getStatus(): Status
    // {
    //     return $this->status;
    // }

    public function getLinias()
    {
        return $this->linias->toArray();
    }

    public function getLinia(LiniaId $id): Linia
    {
        foreach ($this->linias as $linia) {
            if ($linia->getId()->isEqual($id)) {
                return $linia;
            }
        }
        throw new \DomainException('linias is not found.');
    }
}
