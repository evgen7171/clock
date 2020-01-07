<?php
/**
 * @var $menuUnits (array) то, что будет отображено в меню
 */

?>
<ul>
    <?php
    foreach ($menuUnits as $tableNames => $arr) {
        ?>
        <li class="menu-list"><a href="?action=showAll&table=<?= $tableNames ?>"><?= $tableNames ?></a>
            <ul class="drop-menu">
                <?php foreach ($arr as $item): ?>
                    <li><a href="?action=showOne&table=<?= $tableNames ?>&id=<?= $item['id'] ?>">
                            <?= $item['prop'] ?></a></li>
                <?php endforeach; ?>
            </ul>
        </li>
        <?php
    }
    ?>
</ul>