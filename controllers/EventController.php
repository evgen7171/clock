<?php

namespace App\controllers;

use App\models\Event;
use App\models\User;
use App\services\DB;

class EventController extends Controller
{
    public function getTableName()
    {
        return "events";
    }

    public function getUserEvents($user_id)
    {
        return (new Event())->getUserEvents($user_id);
    }
}