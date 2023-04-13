<?php

declare(strict_types=1);

namespace App\Model\Adminka\Entity\Matkas\ChildMatka;

use App\Model\Adminka\Entity\Matkas\PlemMatka\Department\Id as DepartmentId;
use App\Model\AggregateRoot;
use App\Model\EventsTrait;
use App\Model\Adminka\Entity\Matkas\ChildMatka\Change\Change;
use App\Model\Adminka\Entity\Matkas\ChildMatka\Change\Id as ChangeId;
use App\Model\Adminka\Entity\Matkas\ChildMatka\Change\Set;
use App\Model\Adminka\Entity\Matkas\ChildMatka\File\File;
use App\Model\Adminka\Entity\Matkas\ChildMatka\File\Id as FileId;
use App\Model\Adminka\Entity\Matkas\ChildMatka\File\Info;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;

use App\Model\Adminka\Entity\Uchasties\Uchastie\Uchastie;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchastieId;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="admin_matkas_childmatkas", indexes={
 *     @ORM\Index(columns={"date"})
 * })
 */
class ChildMatka
//    implements AggregateRoot
{
//    use EventsTrait;
    /**
     * @var Id
     * @ORM\Column(type="admin_matkas_childmatka_id")
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\SequenceGenerator(sequenceName="admin_matkas_childmatkas_seq", initialValue=1)
     * @ORM\Id
     */
    private $id;
//SEQUENCE  -- NONE
    /**
     * @var PlemMatka
     * @ORM\ManyToOne(targetEntity="App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka")
     * @ORM\JoinColumn(name="plemmatka_id", referencedColumnName="id", nullable=false)
     */
    private $plemmatka;

    /**
     * @var Uchastie
     * @ORM\ManyToOne(targetEntity="App\Model\Adminka\Entity\Uchasties\Uchastie\Uchastie")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", nullable=false)
     */
    private $author;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private $date;

    /**
     * @var \DateTimeImmutable|null
     * @ORM\Column(type="date_immutable", nullable=true)
     */
    private $zakazDate;

    /**
     * @var \DateTimeImmutable|null
     * @ORM\Column(type="date_immutable", nullable=true)
     */
    private $planDate; // запланированная дата

    /**
     * @var \DateTimeImmutable|null
     * @ORM\Column(type="date_immutable", nullable=true)
     */
    private $startDate;


    /**
     * @var \DateTimeImmutable|null
     * @ORM\Column(type="date_immutable", nullable=true)
     */
    private $endDate;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @var Type
     * @ORM\Column(type="admin_matkas_childmatka_type", length=16)
     */
    private $type;


    /**
     * @var ArrayCollection|File[]
     * @ORM\OneToMany(targetEntity="App\Model\Adminka\Entity\Matkas\ChildMatka\File\File", mappedBy="childmatka", orphanRemoval=true, cascade={"all"})
     * @ORM\OrderBy({"date" = "ASC"})
     */
    private $files;


    /**
     * @ORM\Column(type="smallint")
     */
    private $priority;

    /**
     * @var ChildMatka|null
     * @ORM\ManyToOne(targetEntity="ChildMatka")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $parent;  // родитель

    /**
     * @var Status
     * @ORM\Column(type="admin_matkas_childmatka_status", length=16)
     */
    private $status;


    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $kolChild;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $godaVixod;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $sezonPlem;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $sezonChild;

     /**
     * @var Uchastie[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Model\Adminka\Entity\Uchasties\Uchastie\Uchastie")
     * @ORM\JoinTable(name="admin_matkas_childmatkas_executors",
     *      joinColumns={@ORM\JoinColumn(name="childmatka_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="uchastie_id", referencedColumnName="id")}
     * )
     * @ORM\OrderBy({"name.first" = "ASC"})
     */
    private $executors; // экзекутор - исполнитель

    /**
     * @var Change[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Model\Adminka\Entity\Matkas\ChildMatka\Change\Change", mappedBy="childmatka", orphanRemoval=true, cascade={"persist"})
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private $changes;

    public function __construct(
        Id $id,
        PlemMatka $plemmatka,
        Uchastie $author,
        \DateTimeImmutable $date,
        Type $type,
        int $priority,
        string $name,
        ?string $content,
        int $kolChild,
        int $godaVixod,
        string $sezonPlem,
        ?string $sezonChild
    )
    {
        $this->id = $id;
        $this->plemmatka = $plemmatka;
        $this->author = $author;
        $this->date = $date;
        $this->name = $name;
        $this->content = $content;
        $this->files = new ArrayCollection();
        $this->type = $type;
        $this->priority = $priority;
        $this->status = Status::new();
        $this->kolChild = $kolChild;
        $this->godaVixod = $godaVixod;
        $this->sezonPlem = $sezonPlem;
        $this->sezonChild = $sezonChild;
        $this->executors = new ArrayCollection();
        $this->changes = new ArrayCollection();
        $this->addChange($author, $date, Set::forNewChildMatka($plemmatka->getId(), $name, $content, $type, $priority,
                                                                $kolChild, $godaVixod, $sezonPlem, $sezonChild ));
    }



    public function edit(Uchastie $actor, \DateTimeImmutable $date,
//                         string $name,
                         ?string $content): void
    {

        if ($content !== $this->content) {
            $this->content = $content;
            $this->addChange($actor, $date, Set::fromContent($content));
        }
    }

    public function addFile(Uchastie $actor, \DateTimeImmutable $date, FileId $id, Info $info): void
    {
        $this->files->add(new File($this, $id, $actor, $date, $info));
        $this->addChange($actor, $date, Set::fromFile($id));
    }

    public function removeFile(Uchastie $actor, \DateTimeImmutable $date, FileId $id): void
    {
        foreach ($this->files as $current) {
            if ($current->getId()->isEqual($id)) {
                $this->files->removeElement($current);
                $this->addChange($actor, $date, Set::fromRemovedFile($current->getId()));
                return;
            }
        }
        throw new \DomainException('File is not found.');
    }



    public function zakaz(\DateTimeImmutable $date): void
    {
        if (!$this->isNew()) {
            throw new \DomainException('Матка уже заказана.');
        }
         if (!$this->executors->count()) {
             throw new \DomainException('У матки нет исполнителя.');
         }
        $this->changeStatus(Status::zakaz(), $date);

    }

    public function start(Uchastie $actor, \DateTimeImmutable $date): void
    {
       // dd($date);
        if (!$this->isNew() and !$this->isZakaz()) {
            throw new \DomainException('Матка уже заказана.');
        }
        if (!$this->executors->count()) {
            throw new \DomainException('У матки нет исполнителя.');
        }
        $this->changeStatus($actor, $date, Status::working());
    }


    public function setChildOf(Uchastie $actor, \DateTimeImmutable $date,ChildMatka $parent): void
    {
        if ($parent === $this->parent) {
            return;
        }
        $current = $parent;
        do {
            if ($current === $this) {
                throw new \DomainException('Цикломатические дети.');
            }
        }
        while ($current && $current = $current->getParent());

        $this->parent = $parent;

        $this->addChange($actor, $date, Set::fromParent($parent->getId()));
    }


    public function setRoot(Uchastie $actor, \DateTimeImmutable $date): void
    {
        $this->parent = null;
        $this->addChange($actor, $date, Set::forRemovedParent());
    }

    public function plan(Uchastie $actor, \DateTimeImmutable $date, \DateTimeImmutable $plan): void
    {
        $this->planDate = $plan;
        $this->addChange($actor, $date, Set::fromPlan($plan));

    }

    public function removePlan(Uchastie $actor, \DateTimeImmutable $date): void
    {
        $this->planDate = null;
        $this->addChange($actor, $date, Set::forRemovedPlan());
    }
// переместить
    public function move(Uchastie $actor, \DateTimeImmutable $date, PlemMatka $plemmatka): void
    {
        if ($plemmatka === $this->plemmatka) {
            throw new \DomainException('PlemMatka это уже то же самое.');
        }
        $this->plemmatka = $plemmatka;
         $this->addChange($actor, $date, Set::fromPlemMatka($plemmatka->getId()));

    }

//изменить тип
    public function changeType(Uchastie $actor,
                               \DateTimeImmutable $date,
                               Type $type): void
    {
        if ($this->type->isEqual($type)) {
            throw new \DomainException('Тип уже тот же самый.');
        }
        $this->type = $type;
        $this->addChange($actor, $date, Set::fromType($type));
    }


    public function changeStatus(Uchastie $actor, \DateTimeImmutable $date, Status $status): void
    {
        if ($this->status->isEqual($status)) {
            throw new \DomainException('Статус уже тот же.');
        }
        $this->status = $status;
        $this->addChange($actor, $date, Set::fromStatus($status));

        if (!$status->isNew() && !$this->startDate) {
            $this->startDate = $date;
        }
        if ($status->isDone()) {
//            if ($this->progress !== 100) {
//                $this->changeProgress($actor, $date, 100);
//            }
            $this->endDate = $date;
        } else {
            $this->endDate = null;
        }
    }

    public function changePriority(Uchastie $actor, \DateTimeImmutable $date, int $priority): void
    {
        Assert::range($priority, 1, 4);
        if ($priority === $this->priority) {
            throw new \DomainException('Приоритет уже тот же.');
        }
        $this->priority = $priority;
        $this->addChange($actor, $date, Set::fromPriority($priority));
//        $this->recordEvent(new Event\PlemMatkaPriorityChanged($actor->getId(), $this->id, $priority));

    }
//-------------  Executor
    public function hasExecutor(UchastieId $id): bool
    {
        foreach ($this->executors as $executor) {
            if ($executor->getId()->isEqual($id)) {
                return true;
            }
        }
        return false;
    }

    public function assignExecutor(Uchastie $actor, \DateTimeImmutable $date, Uchastie $executor): void
    {
        if ($this->executors->contains($executor)) {
            throw new \DomainException('Исполнитель уже назначен.');
        }
        $this->executors->add($executor);
        $this->addChange($actor, $date, Set::fromExecutor($executor->getId()));
//        $this->recordEvent(new Event\ChildExecutorAssigned($actor->getId(), $this->id, $executor->getId()));
    }

    public function revokeExecutor(Uchastie $actor, \DateTimeImmutable $date, UchastieId $id): void
    {
        foreach ($this->executors as $current) {
            if ($current->getId()->isEqual($id)) {
                $this->executors->removeElement($current);
                $this->addChange($actor, $date, Set::fromRevokedExecutor($current->getId()));
                return;
            }
        }
        throw new \DomainException('Executor is not assigned.');
    }

//------------- end Executor
    public function idDepart($departmentFetcher): DepartmentId
    {
        foreach ($departmentFetcher as $key => $value) {
            if ($value = $this->getSezonPlem()) {
                $idDeppart = $key;
                return new DepartmentId($idDeppart ) ;
                break;
            }
            throw new \DomainException('сезон не найден.');
        }
    }

    public function isNew(): bool
    {
        return $this->status->isNew();
    }

    public function isZakaz(): bool
    {
        return $this->status->isZakaz();
    }

    public function isWorking(): bool
    {
        return $this->status->isWorking();
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getPlemMatka(): PlemMatka
    {
        return $this->plemmatka;
    }

    public function getAuthor(): Uchastie
    {
        return $this->author;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getZakazDate(): ?\DateTimeImmutable
    {
        return $this->zakazDate;
    }

    public function getPlanDate(): ?\DateTimeImmutable
    {
        return $this->planDate;
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getType(): Type
    {
        return $this->type;
    }


    public function getPriority(): int
    {
        return $this->priority;
    }


    public function getParent(): ?ChildMatka
    {
        return $this->parent;
    }


    public function getStatus(): Status
    {
        return $this->status;
    }


    /**
     * @return Uchastie[]
     */
    public function getExecutors(): array
    {
        return $this->executors->toArray();
    }


    public function getKolChild(): int
    {
        return $this->kolChild;
    }


    public function getGodaVixod(): int
    {
        return $this->godaVixod;
    }


    public function getSezonPlem(): string
    {
        return $this->sezonPlem;
    }


    public function getSezonChild(): ?string
    {
        return $this->sezonChild;
    }


    /**
     * @return File[]
     */
    public function getFiles(): array
    {
        return $this->files->toArray();
    }


     /**
      * @return Change[]
      */
     public function getChanges(): array
     {
         return $this->changes->toArray();
     }

     private function addChange(Uchastie $actor, \DateTimeImmutable $date, Set $set): void
     {
         if ($last = $this->changes->last()) {
             /** @var Change $last */
             $next = $last->getId()->next();
         } else {
             $next = ChangeId::first();
         }
         $this->changes->add(new Change($this, $next, $actor, $date, $set));
     }
}
