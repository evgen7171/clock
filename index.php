<?php

include $_SERVER['DOCUMENT_ROOT'] .
    '/services/Autoload.php';
spl_autoload_register(
    [new Autoload(),
        'loadClass']
);

\App\main\App::call()->run();