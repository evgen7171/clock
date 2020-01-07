<?php
return [
    'rootPath' => $_SERVER['DOCUMENT_ROOT'] . '/',
    'name' => 'Органайзер',
    'defaultControllerName' => 'user',
    'public' => [
        'css' => [
            'css/style.css'
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
                'host' => 'localhost:3307',
                'charset' => 'UTF8',
            ]
        ]
    ],
];