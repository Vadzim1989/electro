<?php

use App\Services\Router;
use App\Controllers\Auth;
use App\Controllers\Contract;
use App\Controllers\Obj;
use App\Controllers\Counter;
use App\Controllers\Device;
use App\Controllers\XML;
use App\Controllers\Excel;
use App\Controllers\News;

/**
 * прописываем наши роуты в классе Router
 * заполняем наш Router::$list[]
 */

Router::page('/', 'home');
Router::page('/login', 'login');
Router::page('/admin', 'admin');
Router::page('/profile', 'profile');
Router::page('/add', 'objectAdd');
Router::page('/rues', 'rues');
Router::page('/arenda', 'arenda');
Router::page('/arendaadd', 'arendaAdd');
Router::page('/contracts', 'contracts');
Router::page('/counters', 'counters');
Router::page('/search', 'search');
Router::page('/device', 'device');
Router::page('/makeExcel', 'makeExcel');
Router::page('/filter', 'filter');
Router::page('/analysis', 'analysis');
Router::page('/analisData', 'analisData');
Router::page('/getFile', 'getFile');

/**
 * Обработка запросов на методы классов
 */

Router::post('/auth/register', Auth::class, 'register', true);
Router::post('/auth/login', Auth::class, 'login', true);
Router::post('/auth/logout', Auth::class, 'logout');
Router::post('/auth/update', Auth::class, 'update', true);
Router::post('/auth/userUpdate', Auth::class, 'userUpdate', true);
Router::post('/auth/userInfo', Auth::class, 'userInfo', true);

Router::post('/object/add', Obj::class, 'add', true);
Router::post('/object/delete', Obj::class, 'delete', true);
Router::post('/object/update', Obj::class, 'update', true);
Router::post('/object/arenda', Obj::class, 'arenda', true);
Router::post('/object/remark', Obj::class, 'remark', true);

Router::post('/contract/add', Contract::class, 'add', true);
Router::post('/contract/update', Contract::class, 'update', true);
Router::post('/contract/delete', Contract::class, 'delete', true);

Router::post('/counter/add', Counter::class, 'add', true);
Router::post('/counter/delete', Counter::class, 'delete', true);
Router::post('/counter/update', Counter::class, 'update', true);
Router::post('/counter/addData', Counter::class, 'addData', true);
Router::post('/counter/deleteData', Counter::class, 'deleteData', true);
Router::post('/counter/addArenda', Counter::class, 'addArenda', true);
Router::post('/counter/deleteArenda', Counter::class, 'deleteArenda', true);
Router::post('/counter/addArendaData', Counter::class, 'addArendaData', true);
Router::post('/counter/deleteArendaData', Counter::class, 'deleteArendaData', true);

Router::post('/device/add', Device::class, 'add', true);
Router::post('/device/delete', Device::class, 'delete', true);
Router::post('/device/update', Device::class, 'update', true);

Router::post('/xml/load', XML::class, 'load', true, true);

Router::post('/excel/objects', Excel::class, 'objects', true);
Router::post('/excel/objectByRues', Excel::class, 'objectByRues', true);
Router::post('/excel/electro', Excel::class, 'electro', true);
Router::post('/excel/analis', Excel::class, 'analis', true);
Router::post('/excel/analisArenda', Excel::class, 'analisArenda', true);

Router::post('/news/load', News::class, 'load', true, true);

/**
 * читаем $_GET['q'] - адрес на который ссылается пользователь
 * открываем нужный роут
 */

Router::enable();
?>
