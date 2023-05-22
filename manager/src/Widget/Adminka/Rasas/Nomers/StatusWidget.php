<?php

declare(strict_types=1);

namespace App\Widget\Adminka\Rasas\Nomers;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class StatusWidget extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('nomer_status', [$this, 'status'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function status(Environment $twig, string $status): string
    {
        return $twig->render('widget/adminka/rasas/nomers/status.html.twig', [
            'status' => $status
        ]);
    }
}

