<?php

return [
    'fields' => [
        'ram' => [
            'product_code' => [
                'csv'   => 'Symbol',
                'rules' => 'required|string',
                'info'  => 'uniqueIndex',
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
                'info'  => 'relationship:hardware_traits|foreignKey:name',
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
                'info'  => 'uniqueIndex',
            ],
            'capacity' => [
                'csv'   => 'Pojemność całkowita',
                'rules' => 'required|string',
            ],
            'bundle' => [
                'csv'   => 'Zestaw',
                'rules' => 'required|string',
            ],
            'type' => [
                'csv'   => 'Typ',
                'rules' => 'required|string',
            ],
            'rank' => [
                'csv'   => 'Rank',
                'rules' => 'required|string',
            ],
            'memory_type' => [
                'csv'   => 'Rodzaj pamięci',
                'rules' => 'required|string',
            ],
            'ecc_support' => [
                'csv'   => 'Obsługa ECC',
                'rules' => 'required|boolean',
            ],
            'ecc_registered' => [
                'csv'   => 'Rejestrowanie (ECC Registered)',
                'rules' => 'boolean',
            ],
            'speed' => [
                'csv'   => 'Szybkość modułu',
                'rules' => 'required|string',
            ],
            'frequency' => [
                'csv'   => 'Częstotliwość',
                'rules' => 'required|string',
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
                'rules' => 'string',
            ],
            'model' => [
                'csv'   => 'MODEL',
                'rules' => 'required|string',
                'info'  => 'uniqueIndex',
            ],
            'hardware_trait_id' => [
                'csv'   => 'CECHA',
                'rules' => 'nullable',
                'info'  => 'MtM:hardware_trait_server',
            ],
        ],
    ],
];
