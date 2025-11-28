<?php

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'class_attributes_separation' => [
            'elements' => [
                'property' => 'one',
                'method' => 'one',
            ],
        ],
        'no_unused_imports' => true,
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'single_blank_line_at_eof' => true,
    ])
    // ->setIndent("\t")
    ->setLineEnding("\n")
;
