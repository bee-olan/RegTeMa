<?php

declare(strict_types=1);

namespace App\Model\Adminka\Entity\Matkas\ChildMatka\Change;

use App\Model\Adminka\Entity\Matkas\ChildMatka\ChildMatka;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Uchastie;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="admin_matkas_child_changes")
 */
class Change
{
// Change  ==   Изменить
    /**
     * @var ChildMatka
     * @ORM\ManyToOne(targetEntity="App\Model\Adminka\Entity\Matkas\ChildMatka\ChildMatka", inversedBy="changes")
     * @ORM\JoinColumn(name="childmatka_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * @ORM\Id
     */
    private $childmatka;
    /**
     * @var string
     * @ORM\Column(type="admin_matkas_child_change_id")
     * @ORM\Id
     */
    private $id;
    /**
     * @var Uchastie
     * @ORM\ManyToOne(targetEntity="App\Model\Adminka\Entity\Uchasties\Uchastie\Uchastie")
     * @ORM\JoinColumn(name="actor_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $actor;
    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private $date;
    /**
     * @var Set
     * @ORM\Embedded(class="Set")
     */
    private $set;

    public function __construct(ChildMatka $childmatka, Id $id, Uchastie $actor, \DateTimeImmutable $date, Set $set)
    {
        $this->childmatka = $childmatka;
        $this->id = $id;
        $this->date = $date;
        $this->actor = $actor;
        $this->set = $set;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getActor(): Uchastie
    {
        return $this->actor;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getSet(): Set
    {
        return $this->set;
    }
}
