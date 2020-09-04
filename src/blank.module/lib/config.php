<?php
//TODO дописать класс с конфигами
namespace Your\Config;

class Config  {

    private $someData = 123;

    public static function getSomeData() {
        return self::$someData;
    }

}