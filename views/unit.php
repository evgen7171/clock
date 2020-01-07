<?php
/**
 * @var string $imgSrc
 * @var array $data
 * @var array $params
 * @var array $properties
 * @var \App\models\User $user
 */

extract($params);
?>
<p>Таблица <span id="tableName"><?= $tableName ?></span></p>
<table>
    <tr>
        <td></td>
        <?php for ($i = 0; $i < count($properties); $i++): ?>
            <td class="table-header">
                <?= $properties[$i] ?>
            </td>
        <?php endfor; ?>
        <td></td>
    </tr>
    <tr>
        <td class="pic"><img src="<?= $imgSrc ?>" alt=""></td>
        <?php foreach ($properties as $property): ?>
            <td class="<?= $property !== 'id' ? 'cellContent' : 'cellContent' ?>"
                data-property="<?= $property ?>">
                <span class="<?= $property !== 'id' ? 'cellContentSpan' : 'cellContentId' ?>"><?= $data->$property ?></span>
            </td>
        <?php endforeach; ?>
        <td class="table-buttons">
            <a href="#"
               data-table="<?= $tableName ?>"
               data-id="<?= $data->id ?>"
               id="editButton">Редактировать</a>
            <a href="#"
               data-table="<?= $tableName ?>"
               data-id="<?= $data->id ?>"
               id="saveButton" class="hideButtons">Сохранить</a>
            <a href="#"
               data-table="<?= $tableName ?>"
               id="cancelButton" class="hideButtons">Отмена</a>
        </td>
    </tr>
</table>