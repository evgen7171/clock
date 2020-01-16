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

    <div class="content">
        <table>
            <?php if ($content): ?>
                <?php foreach ($content as $item): ?>
                    <tr>
                        <?php foreach ($item as $sub): ?>
                            <td><?= $sub ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>

</div>
<?= App::getHTMLscripts() ?>
</body>
</html>