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
<?php
var_dump($data[0]->login);
?>