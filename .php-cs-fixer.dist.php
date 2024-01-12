<?php

$finder = PhpCsFixer\Finder::create()
    ->notPath('vendor')
    ->in(__DIR__)
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
;

$config = new PhpCsFixer\Config();

$config
    ->setLineEnding("\n")
    ->setCacheFile(__DIR__.'/.php-cs-fixer.cache')
    ->setIndent('    ')
    ->setRules([
        '@Symfony'                          => true,
        'binary_operator_spaces'            => ['operators' => ['=>' => 'align']],
        'array_syntax'                      => ['syntax' => 'short'],
        'array_indentation'                 => true,
        'linebreak_after_opening_tag'       => true,
        'not_operator_with_successor_space' => true,
        'ordered_imports'                   => true,
        'phpdoc_order'                      => true,
        'increment_style'                   => ['style' => 'post'],
        'global_namespace_import'           => [
            'import_classes'   => true,
            'import_constants' => null,
            'import_functions' => null,
        ],
    ])
    ->setFinder($finder);

return $config;
