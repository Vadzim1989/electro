<?php

namespace App\Services;

class Page {

    /**
     * Метод для подключения нужных компонентов на странице
     */

    public static function part($part_name) {
        require_once("views/components/" . $part_name . ".php");
    }

    public static function pages($page) {
        require_once("pages/" . $page . ".php");
    }
}