<?php
return [
    'rootPath' => $_SERVER['DOCUMENT_ROOT'] . '/',
    'title' => 'Органайзер',
    'defaultControllerName' => 'user',
    'public' => [
        'css' => [
            'css/style.css'
        ],
        'js' => [
            'js/script.js'
        ]
    ],

    'components' => [
        'db' => [
            'class' => \App\services\DB::class,
            'config' => [
                'user' => 'root',
                'password' => '',
                'driver' => 'mysql',
                'db' => 'clock',
                'host' => 'localhost:3306',
                'charset' => 'UTF8',
            ]
        ]
    ],
];