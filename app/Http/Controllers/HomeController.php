<?php

namespace App\Http\Controllers;

use App\Ninja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function doNinja()
    {
        $ninja = Ninja::getOne('id', 2);
//        $ninja->name = 'over';
//        $ninja->address = 'turu';
//        $ninja->nick = 'Never ends';
//        $ninja->alias = 'majic';
//        $ninja->age = 99;
//        $ninja->age = 44;
//        $ninja->update();

        return $ninja;
    }

}
