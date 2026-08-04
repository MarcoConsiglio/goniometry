<?php

declare(strict_types=1);

use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\Config\RectorConfig;

$level = 51;
return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withPhpSets()
    ->withTypeCoverageLevel($level)
    ->withDeadCodeLevel($level)
    ->withCodeQualityLevel($level)
    ->withCodingStyleLevel(12)
    ->withImportNames(removeUnusedImports: true)
    ->withSkip([
        NewlineAfterStatementRector::class,
        EncapsedStringsToSprintfRector::class
    ]);
