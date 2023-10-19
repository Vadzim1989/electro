<?php
namespace App\Services;

class App {

    /**
     * Основной метод, который исполняет все методы ниже
     */
    
    public static function start() {
        //self::libs();
        //self::db();
    }

    /**
     * метод для полключения нужной библиотеки
     */

    public static function libs() {
        $config = require_once('config/app.php');
        foreach ($config['libs'] as $lib) {
            require_once "libs/" . $lib . ".php";
        }
    }

    /**
     * метод для подклюяения к БД
     */

    public static function db() {

        $config = require_once "config/db.php";
        if($config['enable']) {
            \R::setup('mysql:host=' . $config['host'] . ";port=" . $config['port'] . ';dbname=' . $config['db'], $config['username'], $config['password']); // \R - поиск класса RedBeanPhp - глобально
        }
        if(!\R::testConnection()) {
            die('Error database connection...');
        }
    }
}