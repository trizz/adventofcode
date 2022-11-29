
<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__.'/src/');

$config = new PhpCsFixer\Config();

return $config
    ->setRules([
        '@PSR2' => true,
        '@Symfony' => true,
        '@PhpCsFixer' => true,
        'phpdoc_order' => true,
        'ordered_class_elements' => true,
        'multiline_whitespace_before_semicolons' => false,
        'phpdoc_annotation_without_dot' => false,
        'phpdoc_types_order' => [
            'null_adjustment' => 'always_last',
        ],
        'yoda_style' => false,
        'ternary_to_null_coalescing' => true,
        'array_syntax' => ['syntax' => 'short'],
        'php_unit_test_class_requires_covers' => false,
        'single_line_comment_style' => false,
        'phpdoc_to_comment' => false,
    ])
    ->setFinder($finder);
