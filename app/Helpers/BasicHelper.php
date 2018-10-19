<?php
/**
 * Created by PhpStorm.
 * User: sile
 * Date: 19.10.18.
 * Time: 02.31
 */

namespace App\Helpers;


use Carbon\Carbon;

class BasicHelper
{
    public static function getMinutesToTheNextHour()
    {
        return 1;
        return Carbon::now()->diffInMinutes(Carbon::now()->addHour()->format('Y-m-d H:00:00'));
    }
}