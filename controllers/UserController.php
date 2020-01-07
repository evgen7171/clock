<?php

namespace App\controllers;

use App\models\User;
use App\services\BD;

class UserController extends Controller
{
    public function getTableName()
    {
        return "users";
    }
}