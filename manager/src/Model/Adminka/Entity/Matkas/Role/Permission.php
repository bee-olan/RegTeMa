<?php

declare(strict_types=1);

namespace App\Model\Adminka\Entity\Matkas\Role;

use Webmozart\Assert\Assert;

class Permission
{
    public const MANAGE_PLEMMATKA_UCHASTIES = 'Manage_plemMatok_uchasties';
    public const VIEW_CHILDMATKAS = 'view_childMatkas';
    public const VIEW_PLEMMATKAS = 'view_plemMatkas';
    public const MANAGE_CHILDMATKAS = 'manage_childMatkas';
    public const MANAGE_PLEMMATKAS = 'manage_plemMatkas';

//    public const MANAGE_PROJECT_MEMBERS = 'manage_project_members';
//    public const VIEW_TASKS = 'view_tasks';
//    public const MANAGE_TASKS = 'manage_tasks';

    private $name;

    public function __construct(string $name)
    {
        Assert::oneOf($name, self::names());
        $this->name = $name;
    }

    public static function names(): array
    {
        return [
            self::MANAGE_PLEMMATKA_UCHASTIES => 'Управление матками участниками',
            self::VIEW_CHILDMATKAS => 'Смотреть ДочьМаток',
            self::VIEW_PLEMMATKAS => 'Смотреть ПлемМаток',
            self::MANAGE_CHILDMATKAS => 'Управление ДочьМаток',
            self::MANAGE_PLEMMATKAS => 'Управление ПлемМаток',
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
