<?php

$db = mysqli_connect('127.0.0.1:3306', 'root', '','electro'); // аргументы: адрес сервера, логин, пароль, название БД

/*
$informix = odbc_connect("gmaidids2", "informix", "ids2k");

if(!$informix) {
    die("Can't connect to informix...");
}
*/

if(!$db) {
    die("DB error connect...");
}