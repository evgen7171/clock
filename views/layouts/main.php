<?php
/**
 * @var $content
 * @var $menuContent
 */

use App\main\App; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?=App::getHTMLstyles()?>
    <title>Document</title>
</head>
<body>
<header class="header container">
    <div class="menuContent"><?= $menuContent ?></div>
</header>
<div class="content"><?= $content ?></div>
<?=App::getHTMLscripts()?>
</body>
</html>
