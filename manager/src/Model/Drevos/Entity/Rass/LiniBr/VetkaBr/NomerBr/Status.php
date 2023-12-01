<?php
declare(strict_types=1);

namespace App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\NomerBr;

use Webmozart\Assert\Assert;

class Status
{
    public const ACTIVE = 'active';
    public const ARCHIVED = 'archived';
    public const OJIDAET = 'ojidaet';

    private $name;

    public function __construct(string $name)
    {
        Assert::oneOf($name, [
            self::ACTIVE,
            self::ARCHIVED,
            self::OJIDAET,
        ]);

        $this->name = $name;
    }

    public static function active(): self
    {
        return new self(self::ACTIVE);
    }

    public static function archived(): self
    {
        return new self(self::ARCHIVED);
    }

    public static function ojidaet(): self
    {
        return new self(self::OJIDAET);
    }
    
    public function isEqual(self $other): bool
    {
        return $this->getName() === $other->getName();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isActive(): bool
    {
        return $this->name === self::ACTIVE;
    }

    public function isArchived(): bool
    {
        return $this->name === self::ARCHIVED;
    }

    public function isOjidaet(): bool
    {
        return $this->name === self::OJIDAET;
    }
}
