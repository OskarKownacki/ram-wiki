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
        'braces' => [
            'position_after_functions_and_oop_constructs' => 'next',
            'position_after_anonymous_constructs'         => 'next',
        ],
        'control_structure_continuation_position' => [
            'position' => 'next_line',
        ],
        'curly_braces_position' => [
            'control_structures_opening_brace'  => 'next_line_unless_newline_at_signature_end',
            'functions_opening_brace'           => 'next_line_unless_newline_at_signature_end',
            'anonymous_functions_opening_brace' => 'next_line_unless_newline_at_signature_end',
            'classes_opening_brace'             => 'next_line_unless_newline_at_signature_end',
            'anonymous_classes_opening_brace'   => 'next_line_unless_newline_at_signature_end',
        ],
    ])
    // ->setIndent("\t")
    ->setLineEnding("\n")
;
