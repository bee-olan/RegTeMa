<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Rasas\Kategor;

use Webmozart\Assert\Assert;

class Permission
{
    public const ES_DOKYMENT_MATKI = 'Есть документы на матку';
    public const NO_DOKYMENT_MATKI = 'Нет документов на матку';
    public const ADAPTIROV_MATKI = 'Адаптированные матки';

    private $name;

    public function __construct(string $name)
    {
        Assert::oneOf($name, self::names());
        $this->name = $name;
    }

    public static function names(): array
    {
        return [
            self::ES_DOKYMENT_MATKI,
            self::NO_DOKYMENT_MATKI,
            self::ADAPTIROV_MATKI,
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
