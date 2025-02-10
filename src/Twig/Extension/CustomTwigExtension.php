<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\CustomTwigRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class CustomTwigExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [CustomTwigRuntime::class, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [CustomTwigRuntime::class, 'doSomething']),
            new TwigFunction('getActiveRoute', [$this, 'getActiveRoute'])
        ];
    }

    public function getActiveRoute(string $value, string $route): string{
        return $value === $route ? 'active' : '';
    }
}
