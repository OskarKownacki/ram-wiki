<?php

return [
    'fields' => [
        'ram' => [
            'product_code' => [
                'csv'   => 'Symbol',
                'rules' => 'required|string',
                'info'  => ['uniqueIndex' => true],
            ],
            'description' => [
                'csv'   => 'Opis',
                'rules' => 'required|string',
            ],
            'manufacturer' => [
                'csv'   => 'Producent',
                'rules' => 'string',
            ],
            'hardware_trait_id' => [
                'csv'   => 'Cecha',
                'rules' => 'nullable',
                'info'  => ['relationship' => 'hardware_traits', 'foreignKey' => 'name'],
            ],
            // 'group' => [
            //     'csv'   => 'Grupa',
            //     'rules' => 'string',
            // ],
        ],
        'trait' => [
            'name' => [
                'csv'   => 'Nazwa',
                'rules' => 'required|string',
                'info'  => ['uniqueIndex' => true],
            ],
            'capacity' => [
                'csv'   => 'Pojemność całkowita',
                'rules' => 'string',
            ],
            'bundle' => [
                'csv'   => 'Zestaw',
                'rules' => 'string',
            ],
            'type' => [
                'csv'   => 'Typ',
                'rules' => 'string',
            ],
            'rank' => [
                'csv'   => 'Rank',
                'rules' => 'string',
            ],
            'memory_type' => [
                'csv'   => 'Rodzaj pamięci',
                'rules' => 'string',
            ],
            'ecc_support' => [
                'csv'   => 'Obsługa ECC',
                'rules' => 'integer',
            ],
            'ecc_registered' => [
                'csv'   => 'Rejestrowanie (ECC Registered)',
                'rules' => 'integer',
            ],
            'speed' => [
                'csv'   => 'Szybkość modułu',
                'rules' => 'string',
            ],
            'frequency' => [
                'csv'   => 'Częstotliwość',
                'rules' => 'string',
            ],
            'cycle_latency' => [
                'csv'   => 'Opóźnienie (Cycle Latency)',
                'rules' => 'string',
            ],
            'voltage_v' => [
                'csv'   => 'Napięcie (V)',
                'rules' => 'numeric|nullable',
            ],
            'bus' => [
                'csv'   => 'Złącze',
                'rules' => 'string',
            ],
            'module_build' => [
                'csv'   => 'Budowa modułu',
                'rules' => 'string',
            ],
            'module_ammount' => [
                'csv'   => 'Liczba modułów',
                'rules' => 'string',
            ],
            'guarancy' => [
                'csv'   => 'Gwarancja',
                'rules' => 'string',
            ],
        ],
        'server' => [
            'manufacturer' => [
                'csv'   => 'PRODUCENT',
                'rules' => 'string|nullable',
            ],
            'model' => [
                'csv'   => 'MODEL',
                'rules' => 'string',
                'info'  => ['uniqueIndex' => true],
            ],
            'hardware_trait_id' => [
                'csv'   => 'CECHA',
                'rules' => 'nullable',
                'info'  => ['MtM' => 'hardware_trait_server',
                    'delimeter'   => ',', ],
            ],
        ],
    ],
];
