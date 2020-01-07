<?php

namespace App\controllers;

use App\models\User;
use App\services\DB;

class UserController extends Controller
{
    public function getTableName()
    {
        return "users";
    }
}