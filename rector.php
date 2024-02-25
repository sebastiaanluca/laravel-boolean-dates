<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\FuncCall\BoolvalToTypeCastRector;
use Rector\CodeQuality\Rector\FuncCall\FloatvalToTypeCastRector;
use Rector\CodeQuality\Rector\FuncCall\IntvalToTypeCastRector;
use Rector\CodeQuality\Rector\FuncCall\StrvalToTypeCastRector;
use Rector\CodingStyle\Rector\Catch_\CatchExceptionNameMatchingTypeRector;
use Rector\CodingStyle\Rector\FuncCall\ArraySpreadInsteadOfArrayMergeRector;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\Config\RectorConfig;
use Rector\EarlyReturn\Rector\If_\ChangeAndIfToEarlyReturnRector;
use Rector\EarlyReturn\Rector\If_\ChangeOrIfContinueToMultiContinueRector;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\Php81\Rector\Array_\FirstClassCallableRector;
use Rector\Php81\Rector\Property\ReadOnlyPropertyRector;
use Rector\Php82\Rector\Class_\ReadOnlyClassRector;
use Rector\PHPUnit\Set\PHPUnitSetList;

return RectorConfig::configure()
    ->withParallel()
    ->withPaths([
        __DIR__.'/src',
        __DIR__.'/tests',
    ])
    ->withImportNames(
        importDocBlockNames: false,
        removeUnusedImports: true,
    )
    ->withPhpSets()
    ->withPreparedSets(
        deadCode: true,
        codingStyle: true,
        typeDeclarations: true,
        privatization: true,
        earlyReturn: true,
        strictBooleans: true,
    )
    ->withSets([
        PHPUnitSetList::PHPUNIT_80,
        PHPUnitSetList::PHPUNIT_90,
        PHPUnitSetList::PHPUNIT_100,
        // PHPUnitSetList::PHPUNIT_110,
    ])
    ->withRules([
        BoolvalToTypeCastRector::class,
        FloatvalToTypeCastRector::class,
        IntvalToTypeCastRector::class,
        StrvalToTypeCastRector::class,
        ReadOnlyClassRector::class,
        ReadOnlyPropertyRector::class,
    ])
    ->withSkip([
        ArraySpreadInsteadOfArrayMergeRector::class,
        CatchExceptionNameMatchingTypeRector::class,
        ChangeAndIfToEarlyReturnRector::class,
        ChangeOrIfContinueToMultiContinueRector::class,
        ClosureToArrowFunctionRector::class,
        FirstClassCallableRector::class,
        NewlineAfterStatementRector::class,
    ]);
