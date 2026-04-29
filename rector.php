<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;

$level = 17;
return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withPhpSets()
    ->withTypeCoverageLevel($level)
    ->withDeadCodeLevel($level)
    ->withCodeQualityLevel($level)
    ->withSkip([
        ClassPropertyAssignToConstructorPromotionRector::class => [
            __DIR__ . '/src/Builders/FromSexagesimal.php',
            __DIR__ . '/src/Comparisons/Fuzzy/Comparison.php'
        ]
    ]);
