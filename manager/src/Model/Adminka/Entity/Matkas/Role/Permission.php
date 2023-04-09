<?php

declare(strict_types=1);

namespace App\Model\Adminka\Entity\Matkas\Role;

use Webmozart\Assert\Assert;

class Permission
{
    public const MANAGE_PLEMMATKA_UCHASTIES = 'Управление матками участниками';
    public const VIEW_CHILD = 'Смотреть ДочьМаток';
    public const VIEW_PLEMMATKAS = 'Смотреть_ПлемМаток';
    public const MANAGE_CHILDMATKAS = 'Управление_ДочьМаток';
    public const MANAGE_PLEMMATKAS = 'Управление ПлемМаток';


    private $name;

    public function __construct(string $name)
    {
        Assert::oneOf($name, self::names());
        $this->name = $name;
    }

    public static function names(): array
    {
        return [
            self::MANAGE_PLEMMATKA_UCHASTIES,
            self::VIEW_CHILD ,
            self::VIEW_PLEMMATKAS,
            self::MANAGE_CHILDMATKAS,
            self::MANAGE_PLEMMATKAS
        ];
    }

    public function isNameEqual(string $name): bool
    {
        return $this->name === $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
