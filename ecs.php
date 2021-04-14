<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(__DIR__ . '/vendor/symplify/easy-coding-standard/config/set/clean-code.php');

    $containerConfigurator->import(__DIR__ . '/vendor/symplify/easy-coding-standard/config/set/symfony.php');

    $containerConfigurator->import(__DIR__ . '/vendor/symplify/easy-coding-standard/config/set/php71.php');

    $containerConfigurator->import(__DIR__ . '/vendor/symplify/easy-coding-standard/config/set/psr12.php');

    $parameters = $containerConfigurator->parameters();

    $parameters->set('skip', [
        'SlevomatCodingStandard\Sniffs\Variables\UnusedVariableSniff.UnusedVariable' => null,
        'SlevomatCodingStandard\Sniffs\Classes\UnusedPrivateElementsSniff.UnusedMethod' => ['tests/Integration/Presentation/Cli/QueryCommandTest.php'],
        'PhpCsFixer\Fixer\Phpdoc\PhpdocToCommentFixer' => null,
    ]);
};
