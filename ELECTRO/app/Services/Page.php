<?php

namespace App\Services;

class Page {

    /**
     * Метод для подключения нужных компонентов на странице
     */

    public static function part($part_name) {
        require("./views/components/" . $part_name . ".php");
    }

    public static function modal($modal_name) {
        require("./views/modal/" . $modal_name . ".php");
    }

    public static function pages($page) {
        require_once("pages/" . $page . ".php");
    }
}