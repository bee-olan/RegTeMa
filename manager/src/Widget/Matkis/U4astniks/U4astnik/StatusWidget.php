<?php

declare(strict_types=1);

namespace App\Widget\Matkis\U4astniks\U4astnik;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class StatusWidget extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('u4astnik_status', [$this, 'status'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function status(Environment $twig, string $status): string
    {
        return $twig->render('widget/matkis/u4astniks/u4astnik/status.html.twig', [
            'status' => $status
        ]);
    }
}
