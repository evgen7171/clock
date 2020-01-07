<?php

namespace App\models;

use App\services\BD;
use App\services\IBD;

abstract class Model
{
    /**
     * @var BD Класс для работы с базой данных
     * @method static User($id)
     */
    protected $bd;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        $this->bd = BD::getInstance();
        $this->properties = $this->getProperties();
    }

    /**
     * метод проверки свойств модели
     * @param $prop
     * @return bool
     */
    public function isProperty($prop)
    {
        return in_array($prop, $this->properties);
    }

    /**
     * Возращает запись с указанным id
     *
     * @param int $id ID Записи таблицы
     * @return array
     */
    public function getOne($id)
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE id = :id";
        return BD::getInstance()->queryObject($sql, get_called_class(), [':id' => $id]);
    }

    /**
     * возвращает все записи таблицы базы данных
     * @param $id
     * @return mixed
     */
    public static function getAll()
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName}";
        return BD::getInstance()->queryObjects($sql, get_called_class());
    }

    /**
     * получить данные по всем id в виде массива
     * @return mixed
     */
    public function readAll()
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName}";
        return BD::getInstance()->getAll($sql);
    }

    /**
     * получить данные по id в виде массива
     * @param $id
     * @return mixed
     */
    public function readOne($id)
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE id=:id";
        return BD::getInstance()->getOne($sql, [':id' => $id]);
    }

    /**
     * метод вставки данных в таблицу
     */
    public function insert()
    {
        $columns = [];
        $params = [];
        foreach ($this as $key => $value) {
            if ($this->isProperty($key)) {
                $columns[] = $key;
                $params[":{$key}"] = $value;
            }
        }
        var_dump($columns);
        $columnsStr = implode(', ', $columns);
        $placeholders = implode(', ', array_keys($params));

        $tableName = static::getTableName();
        $sql = "INSERT INTO {$tableName} ({$columnsStr})
                VALUES ({$placeholders})";
        $this->bd->execute($sql, $params);
        $this->id = $this->bd->lastInsertId();
    }

    /*
     * метод удаления данных по заранее заданному id
     */
    public function delete($params = [])
    {
        $tableName = static::getTableName();
        $sql = "DELETE FROM {$tableName} WHERE id={$this->id}";
        $this->bd->execute($sql, $params);
    }

    public function deleteOne($id)
    {
        $tableName = static::getTableName();
        $sql = "DELETE FROM {$tableName} WHERE id={$id}";
        $this->bd->execute($sql);
    }

    /**
     * метод обновления данных в таблице БД
     */
    public function update()
    {
        $params = [];
        $keyValueElems = [];
        foreach ($this->properties as $key => $value) {
            if ($this->isProperty($key) && $key !== 'id') {
                $keyValueElems[] = "{$key}='{$value}'";
            }
        }
        $keyValueString = implode(', ', $keyValueElems);
        $tableName = static::getTableName();
        $sql = "UPDATE {$tableName} SET {$keyValueString} WHERE id = {$this->id};";
        $this->bd->execute($sql, $params);
    }

    /**
     * метод сохранения данных
     * в случае если id указан в данных - обновляет таблицу данных БД
     * если id не указан - добавляет последней строчкой в таблицу БД
     */
    public function save()
    {
        if (empty($this->id)) {
            $this->insert();
        }
        $this->update();
    }

    /**
     * метод получения всех свойств модели
     */
    public function getProperties()
    {
        $props = $this->bd->getProperties($this->getTableName());
        return $props;
    }

}
