<?php

namespace App\models;

/**
 * Class User
 * @package App\models
 * @method static getOne($id)
 * @method static getAll()
 */
class User extends Model
{
    // свойства модели получаются с помощью запроса к базе данных

    public $id;
    public $login;
    public $password;

    protected static function getTableName()
    {
        return 'users';
    }

}
