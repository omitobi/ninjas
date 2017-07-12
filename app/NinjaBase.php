<?php
/**
 * Created by PhpStorm.
 * User: omitobisam
 * Date: 12/07/2017
 * Time: 22:42
 */

namespace App;


use Illuminate\Support\Facades\Cache;

class NinjaBase
{
    /**
     * Save a ninja
     *
     * @param Ninja $ninja
     */
    protected static function keep(Ninja $ninja)
    {
        Cache::has('last_ninja') ? Cache::increment('last_ninja', 1) : Cache::forever('last_ninja', 0);
        $last_ninja = Cache::get('last_ninja');
if(isset($ninja->id) && $ninja->id <= $last_ninja){
    Cache::forget('ninja_'.$ninja->id);
    Cache::forever('ninja_'.$ninja->id, $ninja);
}
        $ninja->id = isset($ninja->id) && $ninja->id <= $last_ninja ? $ninja->id : $last_ninja;
        Cache::forever('ninja_'.$last_ninja, $ninja);
        return Cache::get('ninja_'.$last_ninja);
    }

    public static function pour(){
        $last_ninja = Cache::get('last_ninja');
        $ninjas = [];
        while ($last_ninja > 0) {
            $nin = Cache::get('ninja_'.$last_ninja);
            if(!is_null($nin)) {
                $ninjas[] = $nin->toArray();
            }
            $last_ninja --;
        }
        return $ninjas;
    }

    public static function getA($key, $value, $first = false)
    {
        $ninjas = collect(self::pour());
        $returned_ninja =  $ninjas->where($key, $value);
        if($first) { return $returned_ninja->first(); }
        return $returned_ninja;
    }

}