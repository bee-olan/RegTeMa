<?php

declare(strict_types=1);

namespace App\Model\Matkis\Entity\U4astniks\U4astnik;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class StatusType extends StringType
{
    public const NAME = 'matkis_u4astniks_u4astnik_status';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof Status ? $value->getName() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new Status($value) : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}