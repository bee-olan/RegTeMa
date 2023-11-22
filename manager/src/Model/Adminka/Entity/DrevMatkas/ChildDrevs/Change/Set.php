<?php

declare(strict_types=1);

namespace App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\Change;

use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\File\Info;
use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\File\Id as FileId;
use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\Id as ChildDrevId;
use App\Model\Adminka\Entity\DrevMatkas\DrevMatka\Id as DrevMatkaId;
use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\Status;
use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\Type;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchastieId;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Set
{
// Set  установить присвоить
    /**
     * @var DrevMatkaId
     * @ORM\Column(type="admin_drevmatka_id", nullable=true)
     */
    private $plemmatkaId;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @var Info|null
     * @ORM\Column(type="admin_childdrev_file_id", nullable=true)
     */
    private $fileId;
    /**
     * @var Info|null
     * @ORM\Column(type="admin_childdrev_file_id", nullable=true)
     */
    private $removedFileId;

    /**
     * @var Type|null
     * @ORM\Column(type="admin_childdrev_type", length=16, nullable=true)
     */
    private $type;

    /**
     * @var Status|null
     * @ORM\Column(type="admin_childdrev_status", nullable=true)
     */
    private $status;

    /**
     * @var int|null
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $priority;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $kolChild;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $godaVixod;

    /**
     * @var ChildDrevId
     * @ORM\Column(type="admin_childdrev_id", nullable=true)
     */
    private $parentId;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $removedParent;
    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="date_immutable", nullable=true)
     */
    private $plan;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $removedPlan;

    /**
     * @var UchastieId
     * @ORM\Column(type="admin_uchasties_uchastie_id", nullable=true)
     */
    private $executorId;

    /**
     * @var UchastieId
     * @ORM\Column(type="admin_uchasties_uchastie_id", nullable=true)
     */
    private $revokedExecutorId;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private $sezonPlem;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private $sezonChild;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $urowni;

    private function __construct()
    {

    }

    public static function forNewChildDrev(DrevMatkaId $plemmatka,
                                            string $name, ?string $content,
                                            Type $type, int $priority,
                                             int $kolChild,
                                            int $godaVixod,
                                            string $sezonPlem,
                                            ?string $sezonChild,
                                            int $urowni
                                        ): self
    {
        $set = new self();
        $set->plemmatkaId = $plemmatka;
        $set->name = $name;
        $set->content = $content;
        $set->type = $type;
        $set->priority = $priority;
        $set->kolChild = $kolChild;
        $set->godaVixod= $godaVixod;
        $set->sezonPlem= $sezonPlem;
        $set->sezonChild = $sezonChild;
        $set->urowni = $urowni;
        return $set;
    }
    public static function fromSezonChild(string $sezonChild): self
    {
        $set = new self();
        $set->sezonChild = $sezonChild;
        return $set;
    }
    public static function fromSezonPlem(string $sezonPlem): self
    {
        $set = new self();
        $set->sezonPlem = $sezonPlem;
        return $set;
    }

    public static function fromGodaVixod(int $godaVixod): self
    {
        $set = new self();
        $set->godaVixod = $godaVixod;
        return $set;
    }

    public static function fromKolChild(int $kolChild): self
    {
        $set = new self();
        $set->kolChild = $kolChild;
        return $set;
    }

    public static function fromName(string $name): self
    {
        $set = new self();
        $set->name = $name;
        return $set;
    }

    public static function fromContent(string $content): self
    {
        $set = new self();
        $set->content = $content;
        return $set;
    }

    public static function fromType(Type $type): self
    {
        $set = new self();
        $set->type = $type;
        return $set;
    }

    public static function fromFile(FileId $file): self
    {
        $set = new self();
        $set->fileId = $file;
        return $set;
    }

    public static function fromRemovedFile(FileId $file): self
    {
        $set = new self();
        $set->removedFileId = $file;
        return $set;
    }

    public static function fromStatus(Status $status): self
    {
        $set = new self();
        $set->status = $status;
        return $set;
    }

    public static function fromPriority(int $priority): self
    {
        $set = new self();
        $set->priority = $priority;
        return $set;
    }

    public static function fromParent(ChildDrevId $parent): self
    {
        $set = new self();
        $set->parentId = $parent;
        return $set;
    }

    public static function forRemovedParent(): self
    {
        $set = new self();
        $set->removedParent = true;
        return $set;
    }

    public static function fromPlan(\DateTimeImmutable $plan): self
    {
        $set = new self();
        $set->plan = $plan;
        return $set;
    }

    public static function forRemovedPlan(): self
    {
        $set = new self();
        $set->removedPlan = true;
        return $set;
    }

    public static function fromExecutor(UchastieId $executor): self
    {
        $set = new self();
        $set->executorId = $executor;
        return $set;        
    }

    public static function fromRevokedExecutor(UchastieId $executor): self
    {
        $set = new self();
        $set->revokedExecutorId = $executor;
        return $set;        
    }

    public static function fromDrevMatka(DrevMatkaId $plemmatka): self
    {
        $set = new self();
        $set->plemmatkaId = $plemmatka;
        return $set;
    }
}
