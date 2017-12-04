<?php

$config = [
    'basename' => 'timaflu',
    'db' => 'mysql:dbname=timaflu;host=localhost',
    'defaultdb' => 'timaflu',
    'css' =>[
        'bootstrap' => [
            'main' => 'bootstrap',
            'file' => '/css/bootstrap.min.css'
        ],
        'custom' => [
            'main' => 'css',
            'file' => '/main.css'
        ],
        'colors' => [
            'main' => 'css',
            'file' => '/colors.css'
        ],
        'error' => [
            'main' => 'css',
            'file' => '/error.css'
        ]
    ],
    'js' =>[
        'jquery' => [
            'main' => 'jquery',
            'file' => '/jquery-3.2.1.slim.js'
        ],
        'poppers' => [
            'main' => 'poppers',
            'file' => '/popper.min.js'
        ],
        'bootstrap' => [
            'main' => 'bootstrap',
            'file' => '/js/bootstrap.min.js'
        ],
    ]
];

return $config;