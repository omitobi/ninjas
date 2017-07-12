<?php
/**
 * Created by PhpStorm.
 * User: omitobisam
 * Date: 12/07/2017
 * Time: 21:05
 */

namespace App;


class Ninja extends NinjaBase
{

    protected $all;
    function __construct($all = [])
    {
        $this->all = $all;
    }

    function __get($name)
    {
        $method = 'get'.ucfirst($name);
        if (method_exists($this, $method)) {
           return $this->{$method}();
        }

        if (array_key_exists($name, $this->all)) {
            return $this->all[$name];
        }
        return null;
    }


    function __set($name, $value)
    {
        if(!array_key_exists($name, $this->all)) {
            $this->all = array_merge($this->all, [$name => $value]);
        } else {
            $this->all[$name] = $value;
        }
        return $this;
    }

    function __toString()
    {
        return json_encode($this->all);
    }

    function __call($name, $arguments)
    {
        if(!method_exists($this, $name)) {
            if(starts_with('get', $name)) {
                return $this->{'get'.$name}();
            }
        }
    }

    static function _ninja($all = [])
    {
        return new self($all);
    }

    static function staticNinja ()
    {

    }

    function normalNinja ()
    {

    }

    public function save(Ninja $ninja = null)
    {
        if (! $ninja) {

            if(!count($this->all)) {
                throw new \Exception('No ninja to save :( Pass some Ninjas');
            }

            $ninja = self::_ninja($this->all);
        }
        $new_ninja = parent::keep($ninja);
        if($new_ninja) {
            $this->id = $new_ninja->id;
            return $this;
        }
        throw  new \Exception('Couldn\'t save ninja :( ');
    }

    public static function getAll()
    {
        return static::pour();
    }

    public function toArray()
    {
        return $this->all;
    }

    public static function get($key, $value)
    {
        return self::getA($key, $value);
    }

    public static function getOne($key, $value)
    {
        return new self(self::getA($key, $value, true));
    }

    public function update(Ninja $ninja = null)
    {
        return $this->save($ninja);
    }
}