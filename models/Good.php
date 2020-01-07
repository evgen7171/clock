<?php

namespace App\models;

class Good extends Model
{
    // свойства модели получаются с помощью запроса к базе данных

//    public $id;
//    public $price;
//    public $name;
//    public $info;

    protected static function getTableName()
    {
        return 'goods';
    }

    protected static function getMainProperty()
    {
        return 'name';
    }

    protected static function getHidePropertiesArray()
    {
        return ['info'];
    }
}