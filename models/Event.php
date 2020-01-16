<?php

namespace App\models;

use App\services\DB;

/**
 * Class User
 * @package App\models
 * @method static getOne($id)
 * @method static getAll()
 */
class Event extends Model
{
    // свойства модели получаются с помощью запроса к базе данных

    public $id;
    public $user_id;
    public $name;
    public $date;
    public $start;
    public $end;

    protected static function getTableName()
    {
        return 'events';
    }

    public function getUserEvents($user_id)
    {
        $props = $this->getProperties();
        unset($props[array_search('user_id', $props)]);
        unset($props[array_search('id', $props)]);
        $args = join(', ', $props);
        $sql = "SELECT ".$args." FROM events WHERE user_id = " . $user_id . " ORDER BY date";
        return DB::getInstance()->findAll($sql);
    }
}
