<?php

declare(strict_types=1);

namespace App\Model\Adminka\Entity\OtecForRas\Linias\Nomers;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * @ORM\Embeddable
 */
class Matka
{
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $linia;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $nomer;



    public function __construct(string $linia, string $nomer)
    {
        Assert::notEmpty($linia);
        Assert::notEmpty($nomer);

        $this->linia = $linia;
        $this->nomer = $nomer;

    }


    public function getLinia(): string
    {
        return $this->linia;
    }


    public function getNomer(): string
    {
        return $this->nomer;
    }


    public function getFull(): string
    {
        return $this->linia . ' ' . $this->nomer;
    }

}

