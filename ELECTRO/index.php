<?php
session_start();
// Подключяем класс App для подключения к БД
use App\Services\App; 
// Подключаем наше пространство имен
require_once __DIR__ . "/vendor/autoload.php";
// Подключение к БД
App::start();
// Подключаем наши роуты
require_once __DIR__ . "/router/routes.php";


