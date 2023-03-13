<?php

declare(strict_types=1);

namespace App\Twig\Extension\Adminka;

use App\Service\Adminka\Processor\Driver\Driver;
use App\Service\Adminka\Processor\Processor;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ProcessorExtension extends AbstractExtension
{
    /**
     * @var Driver[]
     */
    private $processor;

    public function __construct(Processor $processor)
    {
        $this->processor = $processor;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('adminka_processor', [$this, 'process'], ['is_safe' => ['html']]),
        ];
    }

    public function process(?string $text): string
    {
         return $this->processor->process($text);
    }
}
