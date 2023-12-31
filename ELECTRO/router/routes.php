<?php

use App\Services\Router;
use App\Controllers\Auth;
use App\Controllers\Contract;
use App\Controllers\Obj;
use App\Controllers\Counter;
use App\Controllers\Ports;
use App\Controllers\Device;
use App\Controllers\News;
use App\Controllers\Info;
require_once('app/Controllers/ExcelImport.php');

/**
 * прописываем наши роуты в классе Router
 * заполняем наш Router::$list[]
 */

Router::page('/', 'home');
Router::page('/login', 'login');
Router::page('/admin', 'admin');
Router::page('/profile', 'profile');
Router::page('/rues', 'rues');
Router::page('/arenda', 'arenda');
Router::page('/arendaadd', 'arendaAdd');
Router::page('/contracts', 'contracts');
Router::page('/counters', 'counters');
Router::page('/search', 'search');
Router::page('/device', 'device');
Router::page('/test', 'test');
Router::page('/filter', 'filter');
Router::page('/analis', 'analis');
Router::page('/analisData', 'analisData');
Router::page('/mount', 'mount');

/**
 * Обработка POST-запросов form
 */

Router::post('/auth/register', Auth::class, 'register', true);
Router::post('/auth/login', Auth::class, 'login', true);
Router::post('/auth/logout', Auth::class, 'logout');
Router::post('/auth/update', Auth::class, 'update', true);
Router::post('/auth/delete', Auth::class, 'delete', true);
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
Router::post('/contract/clone', Contract::class, 'clone', true);

Router::post('/counter/add', Counter::class, 'add', true);
Router::post('/counter/delete', Counter::class, 'delete', true);
Router::post('/counter/update', Counter::class, 'update', true);
Router::post('/counter/addData', Counter::class, 'addData', true);
Router::post('/counter/deleteData', Counter::class, 'deleteData', true);
Router::post('/counter/addArenda', Counter::class, 'addArenda', true);
Router::post('/counter/deleteArenda', Counter::class, 'deleteArenda', true);
Router::post('/counter/addArendaData', Counter::class, 'addArendaData', true);
Router::post('/counter/deleteArendaData', Counter::class, 'deleteArendaData', true);

Router::post('/ports/add', Ports::class, 'add', true);
Router::post('/ports/delete', Ports::class, 'delete', true);

Router::post('/device/add', Device::class, 'add', true);
Router::post('/device/delete', Device::class, 'delete', true);
Router::post('/device/update', Device::class, 'update', true);

Router::post('/excel/electro', ExcelImport::class, 'electro', true);
Router::post('/excel/warm', ExcelImport::class, 'warm', true);
Router::post('/excel/analis', ExcelImport::class, 'analis', true);
Router::post('/excel/analisArenda', ExcelImport::class, 'analisArenda', true);
Router::post('/excel/object', ExcelImport::class, 'object', true);
Router::post('/excel/filterArenda', ExcelImport::class, 'filterArenda', true);
Router::post('/excel/objectsExcel', ExcelImport::class, 'objectsExcel', true);

Router::post('/news/load', News::class, 'load', true);

Router::post('/info', Info::class, 'load', true);

/**
 * читаем $_GET['q'] - адрес на который ссылается пользователь
 * открываем нужный роут
 */

Router::enable();
?>
