<?php

$finder = PhpCsFixer\Finder::create()
    ->in( __DIR__ )
    ->exclude( '/vendor' );

$config = new PhpCsFixer\Config();
return $config->setRules( [
    '@PSR12'                         => true,

    // Array notation
    'array_syntax'                   => [ 'syntax' => 'short' ],
    'trim_array_spaces'              => true,

    // Basic
    'encoding'                       => true,

    // Casing
    'native_function_type_declaration_casing' => true,

    // Control Structure
    'trailing_comma_in_multiline'    => true,

    // Function Notation
    'function_typehint_space' => true,

    // PHPDoc
    'phpdoc_single_line_var_spacing' => true,
    'phpdoc_var_without_name'        => true,
    'phpdoc_scalar'                  => true,

    // PHPUnit
    'php_unit_method_casing'         => [
        'case' => 'snake_case',
    ],

    'class_attributes_separation'       => [
        'elements' => [
            'method' => 'one',
        ],
    ],
    'method_argument_space'             => [
        'on_multiline'                     => 'ensure_fully_multiline',
        'keep_multiple_spaces_after_comma' => true,
    ],

    // Class Notation
    'single_trait_insert_per_statement' => true,

    // Import
    'no_unused_imports'                 => true,
    'ordered_imports'                   => [ 'sort_algorithm' => 'alpha' ],

    // Operator
    'binary_operator_spaces'            => [
        'operators' => [
            '=>' => 'align'
        ]
    ],
    'not_operator_with_successor_space' => true,
    'unary_operator_spaces'             => true,

    // Whitespace
    'array_indentation'                 => true,
    'no_spaces_around_offset'           => [
        'positions' => [
            'outside'
        ]
    ],
    'blank_line_before_statement'       => [
        'statements' => [ 'break', 'continue', 'declare', 'return', 'throw', 'try' ],
    ],

] )
    ->setFinder( $finder );
