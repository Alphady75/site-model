<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\AppExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [AppExtensionRuntime::class, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('services', [AppExtensionRuntime::class, 'getServices']),
            new TwigFunction('apropo', [AppExtensionRuntime::class, 'getApropos']),
            new TwigFunction('membres', [AppExtensionRuntime::class, 'getMembres']),
            new TwigFunction('partenaires', [AppExtensionRuntime::class, 'getPartenaires']),
            new TwigFunction('statuts', [AppExtensionRuntime::class, 'getStatuts']),
            new TwigFunction('activites', [AppExtensionRuntime::class, 'getActivites']),
            new TwigFunction('tarifications', [AppExtensionRuntime::class, 'getTarifications']),
            new TwigFunction('temoignages', [AppExtensionRuntime::class, 'getTemoignages']),
            new TwigFunction('StatutTarification', [AppExtensionRuntime::class, 'getTarificationByStatut']),
        ];
    }
}
