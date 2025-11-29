<?php

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12'                      => true,
        'class_attributes_separation' => [
            'elements' => [
                'property' => 'one',
                'method'   => 'one',
            ],
        ],
        'no_unused_imports'           => true,
        'ordered_imports'             => ['sort_algorithm' => 'alpha'],
        'single_blank_line_at_eof'    => true,
        'array_syntax'                => ['syntax' => 'short'],
        'trailing_comma_in_multiline' => true,
        'array_indentation'           => true,
        'method_argument_space'       => [
            'on_multiline' => 'ensure_fully_multiline',
        ],
        'binary_operator_spaces' => [
            'operators' => ['=>' => 'align_single_space_minimal'],
        ],
    ])
    // ->setIndent("\t")
    ->setLineEnding("\n")
;
