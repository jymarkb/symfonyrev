<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class CustomTwigRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // Inject dependencies if needed
    }

    public function doSomething($value)
    {
        // ...
    }
}
