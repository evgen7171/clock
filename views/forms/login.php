<?php

use App\main\App;

// @param $content - данные в виде массива
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?= App::getHTMLstyles() ?>
    <title><?= App::getTitle() ?></title>
</head>
<body>
<br>
<div class="container">

    <div class="content-center">
        <?= $siteTitle ?>
        <hr>
        <form action="#" class="form">
            <input type="text" placeholder="имя">
            <input type="text" placeholder="пароль">
            <input type="submit" value="войти">
        </form>
        <a href="login/forget">Забыл пароль</a><br>
        <a href="login/reg">Регистрация</a>
    </div>

</div>
<?= App::getHTMLscripts() ?>
</body>
</html>