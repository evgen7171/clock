<?php
/**
 * @var string $imgSrc
 * @var array $data
 * @var array $params
 * @var array $properties
 * @var array $hideProperties
 * @var \App\models\User $user
 */
extract($params);
?>
<p>Таблица <span id="tableName"><?= $tableName ?></span></p>
<table>
    <tr>
        <td></td>
        <?php foreach ($properties as $property):
            ?>
            <td class="table-header">
                <?= in_array($property, $hideProperties) ? '' : $property ?>
            </td>
        <?php endforeach; ?>
        <td></td>
    </tr>
    <?php for ($i = 0; $i < count($data); $i++): ?>
        <tr>
            <td class="pic"><img src="<?= $imgSrc ?>" alt=""></td>
            <?php foreach ($properties as $property): ?>
                <td class="table-cell"><?= in_array($property, $hideProperties) ? '' : $data[$i]->$property ?></td>
            <?php endforeach; ?>
            <td class="table-buttons">
                <a href="?action=showOne&table=<?= $tableName ?>&id=<?= $data[$i]->id ?>">Перейти</a>
                <a href="?action=delete&table=<?= $tableName ?>&id=<?= $data[$i]->id ?>">Удалить</a>
            </td>
        </tr>
    <?php endfor; ?>
    <tr id="addCells">
        <td></td>
        <?php foreach ($properties as $property): ?>
            <td></td>
        <?php endforeach;
        $propertiesStr = implode(', ', $properties);
        ?>
        <td class="addButton table-cell"><a href="#"
               id="addButton"
               data-properties="<?= $propertiesStr ?>">Добавить</a></td>
    </tr>
</table>
<div id="formAdd"></div>
