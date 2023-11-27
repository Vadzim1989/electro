<?php

namespace App\Services;

class Router
{

    public static $list = [];

    /**
     * метод для наполнения наших роутов
     * принимает:
     * uri - адресс
     * page - имя
     */

    public static function page($uri, $page_name)
    {
        self::$list[] = [
            "uri" => $uri,
            "page" => $page_name
        ];
    }

    /**
     * Обработка POST запросов
     */

    public static function post($uri, $class, $method, $formdata = false, $files = false)
    {
        self::$list[] = [
            "uri" => $uri,
            "class" => $class,
            "method" => $method,
            "post" => true,
            "formdata" => $formdata,
            "files" => $files
        ];
    }

    /**
     * метод для роутинга по страницам
     * через $_GET['q'] смотрим на какой адрес ссылается пользователь
     * ищем данный адрес в нашем $list
     * делам роут на нужную страницу либо на 404
     */

    public static function enable()
    {
        $query = isset($_GET['q']) ? $_GET['q'] : '';
        foreach (self::$list as $key => $route) {
            # code...

            if ($route['uri'] === '/' . $query) {
                if (isset($route['post']) && $_SERVER["REQUEST_METHOD"] === "POST") {
                    $action = new $route['class'];
                    $method = $route['method'];
                    if($route['formdata'] && $route['files']) {
                        $action->$method($_POST, $_FILES);
                        die();
                    } elseif($route['formdata'] && !$route['files']) {
                        $action->$method($_POST);
                        die();
                    } else {
                        $action->$method();
                        die();
                    }   
                } else {
                    require_once("views/pages/" . $route['page'] . ".php");
                    die();
                }
            }
        }

        self::error('404');
    }

    /**
     * Метод для роута на page 404
     */

    public static function error($error)
    {
        require_once "views/errors/" . $error . ".php";
    }

    public static function redirect($uri) {
        header("Location: http://localhost/ELECTRO/" . $uri);
        die();
    }

    public static function redirect_wrong($uri) {
        header("Refresh: 0.1, URL=http://electro.gmltelecom.int" . $uri);
        echo "<script>alert('Не верный логин или пароль')</script>";
        die();
    }
}
