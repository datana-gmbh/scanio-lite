<?php

declare(strict_types=1);

use ComposerUnused\ComposerUnused\Configuration\Configuration;
use ComposerUnused\ComposerUnused\Configuration\NamedFilter;
use ComposerUnused\ComposerUnused\Configuration\PatternFilter;
use Webmozart\Glob\Glob;

return static fn (Configuration $config): Configuration => $config
    ->addPatternFilter(PatternFilter::fromString('/datana-gmbh\/doctrine-.*/'))
    ->addNamedFilter(NamedFilter::fromString('datana-gmbh/logz-io-handler'))
    ->addNamedFilter(NamedFilter::fromString('ext-pdo_pgsql'))
    ->addNamedFilter(NamedFilter::fromString('symfony/flex'))
    ->addNamedFilter(NamedFilter::fromString('symfony/mime'))
    ->addNamedFilter(NamedFilter::fromString('symfony/var-dumper'))
    ->setAdditionalFilesFor('datana-gmbh/scanio-lite', [
        __FILE__,
        ...array_merge(
            Glob::glob(__DIR__.'/bin/*.php'),
            Glob::glob(__DIR__.'/config/*.php'),
            Glob::glob(__DIR__.'/public/*.php'),
            Glob::glob(__DIR__.'/templates/*.php'),
        ),
    ]);
