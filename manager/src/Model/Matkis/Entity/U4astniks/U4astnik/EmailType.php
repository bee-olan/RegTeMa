<?php

declare(strict_types=1);

namespace App\Model\Matkis\Entity\U4astniks\U4astnik;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class EmailType extends StringType
{
    public const NAME = 'matkis_u4astniks_u4astnik_email';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof Email ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new Email($value) : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
