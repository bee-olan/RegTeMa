<?php

declare(strict_types=1);

namespace App\Model\Adminka\Entity\Matkas\ChildMatka\Change;


use App\Model\Adminka\Entity\Matkas\ChildMatka\Id as ChildMatkaId;
use App\Model\Adminka\Entity\Matkas\ChildMatka\File\Info;
use App\Model\Adminka\Entity\Matkas\ChildMatka\File\Id as FileId;
use App\Model\Adminka\Entity\Matkas\ChildMatka\Status;
use App\Model\Adminka\Entity\Matkas\ChildMatka\Type;
use App\Model\Adminka\Entity\Matkas\PlemMatka\Id as PlemMatkaId;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchastieId;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Set
{
// Set  установить присвоить
    /**
     * @var PlemMatkaId
     * @ORM\Column(type="admin_matkas_plemmatka_id", nullable=true)
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
     * @ORM\Column(type="adminka_matkas_childmatka_file_id", nullable=true)
     */
    private $fileId;
    /**
     * @var Info|null
     * @ORM\Column(type="adminka_matkas_childmatka_file_id", nullable=true)
     */
    private $removedFileId;

    /**
     * @var Type|null
     * @ORM\Column(type="admin_matkas_childmatka_type", length=16, nullable=true)
     */
    private $type;

    /**
     * @var Status|null
     * @ORM\Column(type="admin_matkas_childmatka_status", nullable=true)
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
     * @var ChildMatkaId
     * @ORM\Column(type="admin_matkas_childmatka_id", nullable=true)
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

    public static function forNewChildMatka(PlemMatkaId $plemmatka,
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

    public static function fromParent(ChildMatkaId $parent): self
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

    public static function fromPlemMatka(PlemMatkaId $plemmatka): self
    {
        $set = new self();
        $set->plemmatkaId = $plemmatka;
        return $set;
    }
}
