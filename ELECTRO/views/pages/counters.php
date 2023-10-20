<?php
use App\Services\Page;
use App\Services\Router;
if(!$_SESSION['user']) {
    Router::redirect('/');
}
?>

<!DOCTYPE html>
<html lang="en">
<?php Page::part('head'); 
require_once('vendor/db.php');
$id = $_GET['id'];

// подготовка таблиц для записи данных

$month = [
    'counter_01'.date('Y'),
    'counter_02'.date('Y'),
    'counter_03'.date('Y'),
    'counter_04'.date('Y'),
    'counter_05'.date('Y'),
    'counter_06'.date('Y'),
    'counter_07'.date('Y'),
    'counter_08'.date('Y'),
    'counter_09'.date('Y'),
    'counter_10'.date('Y'),
    'counter_11'.date('Y'),
    'counter_12'.date('Y')
];

$monthArenda = [
    'arenda_01'.date('Y'),
    'arenda_02'.date('Y'),
    'arenda_03'.date('Y'),
    'arenda_04'.date('Y'),
    'arenda_05'.date('Y'),
    'arenda_06'.date('Y'),
    'arenda_07'.date('Y'),
    'arenda_08'.date('Y'),
    'arenda_09'.date('Y'),
    'arenda_10'.date('Y'),
    'arenda_11'.date('Y'),
    'arenda_12'.date('Y')
];

// опрос БД на наличие таблиц / Создание таблиц

for($i = 0; $i < 12; $i++) {
    if(mysqli_query($db, "SELECT * FROM `". $month[$i]."`")) { // если есть таблица, пропускаем итерацию
        continue;
    } else { // если нету, создаем таблицу
        mysqli_query($db, "CREATE TABLE `".$month[$i]."` (`id_counter` INT(10) NOT NULL DEFAULT '0', `value` DECIMAL(10,3) NOT NULL DEFAULT '0', `date_input` DATE NOT NULL, UNIQUE INDEX `id_counter` (`id_counter`) USING BTREE) COLLATE='utf8mb3_general_ci' ENGINE=MYISAM;");
    };
};

for($i = 0; $i < 12; $i++) {
    if(mysqli_query($db, "SELECT * FROM `". $monthArenda[$i]."`")) { // если есть таблица, пропускаем итерацию
        continue;
    } else { // если нету, создаем таблицу
        mysqli_query($db, "CREATE TABLE `".$monthArenda[$i]."` (`id_counter` INT(10) NOT NULL DEFAULT '0', `value` DECIMAL(10,3) NOT NULL DEFAULT '0', `pay` DECIMAL(10,3) NULL DEFAULT NULL, `date_input` DATE NOT NULL, UNIQUE INDEX `id_counter` (`id_counter`) USING BTREE)");
    };
};
// коннект к БД с показаниями счетчиков

$counterConn = mysqli_connect('10.245.31.5', 'counter', '@1QAZwsx', 'ctell');

$table = 'counter_'.date('mY');
$counters = mysqli_query($db, "SELECT `id_counter` FROM `object_counter`");
$counters = mysqli_fetch_all($counters);

// опрос показаний счетчиков по имеющимся заводским номерам 
if(!$_SESSION['user']['counter']){
    $_SESSION['user']['counter'] = true;
    for($i = 0; $i < count($counters); $i++) {
        $counterID = $counters[$i][0];

        $sn = mysqli_query($db, "SELECT `sn` FROM `object_counter` WHERE `id_counter` = '$counterID'");
        $sn = mysqli_fetch_assoc($sn);
        $sn = $sn['sn'];

        $date = date('Y-m-d');

        $cntData = mysqli_query($counterConn, "SELECT v0ind FROM bm_cnt_data INNER JOIN (SELECT c_id, MAX(id) AS maxid FROM bm_cnt_data WHERE c_id = (select c_id from bm_cnts where fact_num like '$sn' AND fact_num NOT IN ('0030615003918','0030615003929') LIMIT 1)) AS m where bm_cnt_data.id = m.maxid");
        $cntData = mysqli_fetch_row($cntData);
        if($cntData) {
            $value = $cntData[0];
        } else {
            continue;
        };

        $checkTableInfo = mysqli_query($db, "SELECT * FROM `$table` WHERE `id_counter` = '$counterID'");
        $checkTableInfo = mysqli_fetch_assoc($checkTableInfo);

        if($checkTableInfo) {
            $currentValue = mysqli_query($db, "SELECT `value` FROM `$table` WHERE `id_counter` = '$counterID'");
            $currentValue = mysqli_fetch_assoc($currentValue);
            $currentValue = $currentValue['value'];
            if($currentValue == $value) {
                continue;
            } else {
                mysqli_query($db, "UPDATE `$table` SET `value` = '$value', `date_input` = '$date' WHERE `id_counter` = '$counterID'");
                mysqli_query($db, "UPDATE `object_counter` SET `online` = 1 WHERE `id_counter` = '$counterID'");
            }        
        } else {
            mysqli_query($db, "INSERT INTO `$table`(`id_counter`, `value`, `date_input`) VALUES ('$counterID', '$value', '$date')");
            mysqli_query($db, "UPDATE `object_counter` SET `online` = 1 WHERE `id_counter` = '$counterID'");
        }
        
    };
};


$query = mysqli_query($db, "SELECT obc.id_counter, obc.online, obc.transform, obc.sn, obc.counter_type, ct.name, jan.value AS jan, f.value AS feb, mar.value AS mar, apr.value AS apr, may.value AS may, jun.value AS jun, jul.value AS jul, aug.value AS aug, s.value AS sep, o.value AS oct, n.value AS nov, d.value AS december  FROM `object_counter` obc LEFT JOIN `counter_type` ct ON (obc.counter_type = ct.counter_type) LEFT JOIN `$month[0]` jan ON (jan.id_counter = obc.id_counter) LEFT JOIN `$month[1]` f ON (f.id_counter = obc.id_counter) LEFT JOIN `$month[2]` mar ON (mar.id_counter = obc.id_counter) LEFT JOIN `$month[3]` apr ON (apr.id_counter = obc.id_counter) LEFT JOIN `$month[4]` may ON (may.id_counter = obc.id_counter) LEFT JOIN `$month[5]` jun ON (jun.id_counter = obc.id_counter) LEFT JOIN `$month[6]` jul ON (jul.id_counter = obc.id_counter) LEFT JOIN `$month[7]` aug ON (aug.id_counter = obc.id_counter) LEFT JOIN `$month[8]` s ON (s.id_counter = obc.id_counter) LEFT JOIN `$month[9]` o ON (o.id_counter = obc.id_counter) LEFT JOIN `$month[10]` n ON (n.id_counter = obc.id_counter) LEFT JOIN `$month[11]` d ON (d.id_counter = obc.id_counter) WHERE obc.id_object = '$id'");
$datas = [];
while($row = mysqli_fetch_assoc($query)) {
    $datas[] = $row;
}

$object = mysqli_query($db, "SELECT `object_name` FROM `object` WHERE `id_object` = '$id'");
$object = mysqli_fetch_assoc($object);

$jan = "counter_01".date('Y');
$feb = "counter_02".date('Y');
$mar = "counter_03".date('Y');
$apr = "counter_04".date('Y');
$may = "counter_05".date('Y');
$jun = "counter_06".date('Y');
$jul = "counter_07".date('Y');
$aug = "counter_08".date('Y');
$sep = "counter_09".date('Y');
$oct = "counter_10".date('Y');
$nov = "counter_11".date('Y');
$dec = "counter_12".date('Y');

$janArenda = "arenda_01".date('Y');
$febArenda = "arenda_02".date('Y');
$marArenda = "arenda_03".date('Y');
$aprArenda = "arenda_04".date('Y');
$mayArenda = "arenda_05".date('Y');
$junArenda = "arenda_06".date('Y');
$julArenda = "arenda_07".date('Y');
$augArenda = "arenda_08".date('Y');
$sepArenda = "arenda_09".date('Y');
$octArenda = "arenda_10".date('Y');
$novArenda = "arenda_11".date('Y');
$decArenda = "arenda_12".date('Y');

$arenda = mysqli_query($db,"SELECT DISTINCT obc.counter_type, obc.id_counter, ct.name, jan.value AS jan, f.value AS feb, mar.value AS mar, apr.value AS apr, may.value AS may, jun.value AS jun, jul.value AS jul, aug.value AS aug, s.value AS sep, o.value AS oct, n.value AS nov, d.value AS december, jan.pay as jan_pay, f.pay as feb_pay, mar.pay as mar_pay, apr.pay as apr_pay, may.pay as may_pay, jun.pay as jun_pay, jul.pay as jul_pay, aug.pay as aug_pay, s.pay as sep_pay, o.pay as oct_pay, n.pay as nov_pay, d.pay as december_pay  FROM `object_counter_arenda` obc LEFT JOIN `counter_type` ct ON (obc.counter_type = ct.counter_type) LEFT JOIN `$janArenda` jan ON (jan.id_counter = obc.id_counter) LEFT JOIN `$febArenda` f ON (f.id_counter = obc.id_counter) LEFT JOIN `$marArenda` mar ON (mar.id_counter = obc.id_counter) LEFT JOIN `$aprArenda` apr ON (apr.id_counter = obc.id_counter) LEFT JOIN `$mayArenda` may ON (may.id_counter = obc.id_counter) LEFT JOIN `$junArenda` jun ON (jun.id_counter = obc.id_counter) LEFT JOIN `$julArenda` jul ON (jul.id_counter = obc.id_counter) LEFT JOIN `$augArenda` aug ON (aug.id_counter = obc.id_counter) LEFT JOIN `$sepArenda` s ON (s.id_counter = obc.id_counter) LEFT JOIN `$octArenda` o ON (o.id_counter = obc.id_counter) LEFT JOIN `$novArenda` n ON (n.id_counter = obc.id_counter) LEFT JOIN `$decArenda` d ON (d.id_counter = obc.id_counter) WHERE obc.id_object = '$id'");

if(isset($arenda)) {
    $arendas = [];
    while($row = mysqli_fetch_assoc($arenda)) {
        $arendas[] = $row;
    }
}


// $counterConn = mysqli_connect('10.245.31.5', 'counter', '@1QAZwsx', 'ctell');
// $data = mysqli_query($counterConn, "SELECT m.c_id, v0ind FROM bm_cnt_data INNER JOIN (SELECT c_id, MAX(id) AS maxid FROM bm_cnt_data WHERE c_id = (select c_id from bm_cnts where fact_num like '%191110' LIMIT 1)) AS m where bm_cnt_data.id = m.maxid");
// $data = mysqli_fetch_assoc($data);
// var_dump($data);
?>

<style>
    table > thead > tr > th,
    table > tbody > tr > td {
        font-size: small;
        text-align: center;
    }
    .name {
        text-align: center;
    }
    .id_counter {
        font-weight: bold;
    }
    a {
        text-decoration: none;
    }
    .arena-cnt {
        border: none;
    }
</style>

<body>
    <?php Page::part('navbar'); ?>
    <h2 class="text-center">&#127969 <?=$object['object_name']?></h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>№</th>
                <th>Тип счетчика</th>
                <th>№ заводской</th>
                <th>Январь <?=date('Y');?></th>
                <th>Февраль <?=date('Y');?></th>
                <th>Март <?=date('Y');?></th>
                <th>Апрель <?=date('Y');?></th>
                <th>Май <?=date('Y');?></th>
                <th>Июнь <?=date('Y');?></th>
                <th>Июль <?=date('Y');?></th>
                <th>Август <?=date('Y');?></th>
                <th>Сентябрь <?=date('Y');?></th>
                <th>Октябрь <?=date('Y');?></th>
                <th>Ноябрь <?=date('Y');?></th>
                <th>Декабрь <?=date('Y');?></th>
                <th>
                    <button type="button" title="Добавить счетчик" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCounter" id-object="<?=$id?>" obj-name="<?=$object['object_name']?>">&#10010</button>
                </th>
                <th>
                    <button type="button" title="Фильтр" class="btn btn-outline-primary ms-3" data-bs-toggle="modal" data-bs-target="#filter" id-object="<?=$id?>">&#128269</button>
                </th>
            </tr>
        </thead> 
        <tbody>
            <?php
                foreach ($datas as $key => $data) {
                    # code...
                    ?>
                        <tr>
                            <td class="align-middle id_counter"><?= $data["id_counter"] ?></td>
                            <td class="align-middle name"><?= $data["name"] ?></td>
                            <td class="align-middle"><?= $data["sn"] ?></td>
                            <td class="align-middle">
                                <?php
                                    if($data["jan"]) {
                                        ?>
                                            <button type="button" class="<?php if($data['online']) echo 'btn btn-success'; else echo 'btn btn-outline-secondary' ?>" data-bs-toggle="modal" data-bs-target="#addCounterData" month="январь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['jan']?>" obj="<?=$id?>" cnt-table="<?=$jan?>"><?=$data['jan']?></button>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterData" month="январь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['jan']?>" obj="<?=$id?>" cnt-table="<?=$jan?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["feb"]) {
                                        ?>
                                            <button type="button" class="<?php if($data['online']) echo 'btn btn-success'; else echo 'btn btn-outline-secondary' ?>" data-bs-toggle="modal" data-bs-target="#addCounterData" month="февраль" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['feb']?>" obj="<?=$id?>" cnt-table="<?=$feb?>"><?=$data['feb']?></button>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterData" month="февраль" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['feb']?>" obj="<?=$id?>" cnt-table="<?=$feb?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>            
                            <td class="align-middle">
                                <?php
                                    if($data["mar"]) {
                                        ?>
                                            <button type="button" class="<?php if($data['online']) echo 'btn btn-success'; else echo 'btn btn-outline-secondary' ?>" data-bs-toggle="modal" data-bs-target="#addCounterData" month="март" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['mar']?>" obj="<?=$id?>" cnt-table="<?=$mar?>"><?=$data['mar']?></button>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterData" month="март" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['mar']?>" obj="<?=$id?>" cnt-table="<?=$mar?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["apr"]) {
                                        ?>
                                            <button type="button" class="<?php if($data['online']) echo 'btn btn-success'; else echo 'btn btn-outline-secondary' ?>" data-bs-toggle="modal" data-bs-target="#addCounterData" month="апрель" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['apr']?>" obj="<?=$id?>" cnt-table="<?=$apr?>"><?=$data['apr']?></button>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterData" month="апрель" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['apr']?>" obj="<?=$id?>" cnt-table="<?=$apr?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["may"]) {
                                        ?>
                                            <button type="button" class="<?php if($data['online']) echo 'btn btn-success'; else echo 'btn btn-outline-secondary' ?>" data-bs-toggle="modal" data-bs-target="#addCounterData" month="май" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['may']?>" obj="<?=$id?>" cnt-table="<?=$may?>"><?=$data['may']?></button>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterData" month="май" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['may']?>" obj="<?=$id?>" cnt-table="<?=$may?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["jun"]) {
                                        ?>
                                            <button type="button" class="<?php if($data['online']) echo 'btn btn-success'; else echo 'btn btn-outline-secondary' ?>" data-bs-toggle="modal" data-bs-target="#addCounterData" month="июнь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['jun']?>" obj="<?=$id?>" cnt-table="<?=$jun?>"><?=$data['jun']?></button>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterData" month="июнь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['jun']?>" obj="<?=$id?>" cnt-table="<?=$jun?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["jul"]) {
                                        ?>
                                            <button type="button" class="<?php if($data['online']) echo 'btn btn-success'; else echo 'btn btn-outline-secondary' ?>" data-bs-toggle="modal" data-bs-target="#addCounterData" month="июль" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['jul']?>" obj="<?=$id?>" cnt-table="<?=$jul?>"><?=$data['jul']?></button>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterData" month="июль" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['jul']?>" obj="<?=$id?>" cnt-table="<?=$jul?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["aug"]) {
                                        ?>
                                            <button type="button" class="<?php if($data['online']) echo 'btn btn-success'; else echo 'btn btn-outline-secondary' ?>" data-bs-toggle="modal" data-bs-target="#addCounterData" month="август" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['aug']?>" obj="<?=$id?>" cnt-table="<?=$aug?>"><?=$data['aug']?></button>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterData" month="август" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['aug']?>" obj="<?=$id?>" cnt-table="<?=$aug?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["sep"]) {
                                        ?>
                                            <button type="button" class="<?php if($data['online']) echo 'btn btn-success'; else echo 'btn btn-outline-secondary' ?>" data-bs-toggle="modal" data-bs-target="#addCounterData" month="сентябрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['sep']?>" obj="<?=$id?>" cnt-table="<?=$sep?>"><?=$data['sep']?></button>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterData" month="сентябрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['sep']?>" obj="<?=$id?>" cnt-table="<?=$sep?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["oct"]) {
                                        ?>
                                            <button type="button" class="<?php if($data['online']) echo 'btn btn-success'; else echo 'btn btn-outline-secondary' ?>" data-bs-toggle="modal" data-bs-target="#addCounterData" month="октябрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['oct']?>" obj="<?=$id?>" cnt-table="<?=$oct?>"><?=$data['oct']?></button>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterData" month="октябрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['oct']?>" obj="<?=$id?>" cnt-table="<?=$oct?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["nov"]) {
                                        ?>
                                            <button type="button" class="<?php if($data['online']) echo 'btn btn-success'; else echo 'btn btn-outline-secondary' ?>" data-bs-toggle="modal" data-bs-target="#addCounterData" month="ноябрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['nov']?>" obj="<?=$id?>" cnt-table="<?=$nov?>"><?=$data['nov']?></button>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterData" month="ноябрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['nov']?>" obj="<?=$id?>" cnt-table="<?=$nov?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["december"]) {
                                        ?>
                                            <button type="button" class="<?php if($data['online']) echo 'btn btn-success'; else echo 'btn btn-outline-secondary' ?>" data-bs-toggle="modal" data-bs-target="#addCounterData" month="декабрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['december']?>" obj="<?=$id?>" cnt-table="<?=$dec?>"><?=$data['december']?></button>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterData" month="декабрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['december']?>" obj="<?=$id?>" cnt-table="<?=$dec?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle" colspan="2">
                                <button type="button" title="Информация" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateCounter" cnt-id="<?=$data['id_counter']?>" cnt-type="<?=$data['name']?>" cnt-sn="<?=$data['sn']?>" obj-id="<?=$id?>" trans="<?=$data['transform']?>">&#9997</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-midle"></td>
                            <td class="align-midle">потребление</td>
                            <td class="align-midle"></td>
                            <td class="align-midle">
                                <?php
                                    $year = date('Y') - 1;
                                    $table = "counter_12".$year;
                                    $idCnt = $data['id_counter'];
                                    $prevQeury = mysqli_query($db, "SELECT c.value FROM `$table` WHERE `id_counter` = '$idCnt'");                                    
                                    if($prevQeury){
                                        $prevDec = mysqli_fetch_assoc($prevQeury);
                                        if($prevDec['value']-$data['jan'] < 0) {
                                            echo "0";
                                        } else {
                                            echo round(($prevDec['value']-$data['jan'])*$data['transform'],2);
                                        }
                                    }else{
                                        echo "0";
                                    }                                    
                                ?>
                            </td>
                            <td class="align-midle">
                                <?php
                                    if($data['feb']-$data['jan'] < 0) {
                                        echo "0";
                                    } else {
                                        echo round(($data['feb']-$data['jan'])*$data['transform'],2);
                                    }
                                ?>
                            </td>
                            <td class="align-midle">
                                <?php
                                    if($data['mar']-$data['feb'] < 0) {
                                        echo "0";
                                    } else {
                                        echo round(($data['mar']-$data['feb'])*$data['transform'],2);
                                    }
                                ?>
                            </td>
                            <td class="align-midle">
                                <?php
                                    if($data['apr']-$data['mar'] < 0) {
                                        echo "0";
                                    } else {
                                        echo round(($data['apr']-$data['mar'])*$data['transform'],2);
                                    }
                                ?>
                            </td>
                            <td class="align-midle">
                                <?php
                                    if($data['may']-$data['apr'] < 0) {
                                        echo "0";
                                    } else {
                                        echo round(($data['may']-$data['apr'])*$data['transform'],2);
                                    }
                                ?>
                            </td>
                            <td class="align-midle">
                                <?php
                                    if($data['jun']-$data['may'] < 0) {
                                        echo "0";
                                    } else {
                                        echo round(($data['jun']-$data['may'])*$data['transform'],2);
                                    }
                                ?>
                            </td>
                            <td class="align-midle">
                                <?php
                                    if($data['jul']-$data['jun'] < 0) {
                                        echo "0";
                                    } else {
                                        echo round(($data['jul']-$data['jun'])*$data['transform'],2);
                                    }
                                ?>
                            </td>
                            <td class="align-midle">
                                <?php
                                    if($data['aug']-$data['jul'] < 0) {
                                        echo "0";
                                    } else {
                                        echo round(($data['aug']-$data['jul'])*$data['transform'],2);
                                    }
                                ?>
                            </td>
                            <td class="align-midle">
                                <?php
                                    if($data['sep']-$data['aug'] < 0) {
                                        echo "0";
                                    } else {
                                        echo round(($data['sep']-$data['aug'])*$data['transform'],2);
                                    }
                                ?>
                            </td>
                            <td class="align-midle">
                                <?php
                                    if($data['oct']-$data['sep'] < 0) {
                                        echo "0";
                                    } else {
                                        echo round(($data['oct']-$data['sep'])*$data['transform'],2);
                                    }
                                ?>
                            </td>
                            <td class="align-midle">
                                <?php
                                    if($data['nov']-$data['oct'] < 0) {
                                        echo "0";
                                    } else {
                                        echo round(($data['nov']-$data['oct'])*$data['transform'],2);
                                    }
                                ?>
                            </td>
                            <td class="align-midle">
                                <?php
                                    if($data['december']-$data['nov'] < 0) {
                                        echo "0";
                                    } else {
                                        echo round(($data['december']-$data['nov'])*$data['transform'],2);
                                    }
                                ?>
                            </td>                            
                            <td class="align-midle" colspan="2"></td>
                        </tr>
                    <?php
                }
            ?>
        </tbody>
    </table>
    <h2 class="text-center">Данные по счет-фактуре энергоснабжающей организации</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>№</th>
                <th></th>
                <th>Показания</th>
                <th>Январь <?=date('Y');?></th>
                <th>Февраль <?=date('Y');?></th>
                <th>Март <?=date('Y');?></th>
                <th>Апрель <?=date('Y');?></th>
                <th>Май <?=date('Y');?></th>
                <th>Июнь <?=date('Y');?></th>
                <th>Июль <?=date('Y');?></th>
                <th>Август <?=date('Y');?></th>
                <th>Сентябрь <?=date('Y');?></th>
                <th>Октябрь <?=date('Y');?></th>
                <th>Ноябрь <?=date('Y');?></th>
                <th>Декабрь <?=date('Y');?></th>
                <th>
                    <button type="button" title="Добавить показания" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCounterArenda" id-object="<?=$id?>" obj-name="<?=$object['object_name']?>">&#10010</button>
                </th>
                <th></th>
                <th></th>
            </tr>
        </thead> 
        <tbody>
            <?php
                foreach ($arendas as $key => $data) {
                    # code...
                    ?>
                        <tr>
                            <td class="align-middle id_counter"><?=$data['id_counter']?></td>
                            <td class="align-middle name">Счет-фактура</td>
                            <td class="align-middle name"><?= $data["name"] ?></td>
                            <td class="align-middle">
                                <?php
                                    if($data["jan"]) {
                                        ?>
                                            <button type="button" class="btn btn-outline-primary arena-cnt" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="январь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['jan']?>" obj="<?=$id?>" cnt-table="<?=$janArenda?>" pay="<?=$data['jan_pay']?>"><?=$data['jan']?></button>
                                            <p class="text-center fw-semibold"><?=$data['jan_pay']?> р.</p>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="январь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['jan']?>" obj="<?=$id?>" cnt-table="<?=$janArenda?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["feb"]) {
                                        ?>
                                            <button type="button" class="btn btn-outline-primary arena-cnt" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="февраль" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['feb']?>" obj="<?=$id?>" cnt-table="<?=$febArenda?>" pay="<?=$data['feb_pay']?>"><?=$data['feb']?></button>
                                            <p class="text-center fw-semibold"><?=$data['feb_pay']?> р.</p>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="февраль" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['feb']?>" obj="<?=$id?>" cnt-table="<?=$febArenda?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>             
                            <td class="align-middle">
                                <?php
                                    if($data["mar"]) {
                                        ?>
                                            <button type="button" class="btn btn-outline-primary arena-cnt" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="март" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['mar']?>" obj="<?=$id?>" cnt-table="<?=$marArenda?>" pay="<?=$data['mar_pay']?>"><?=$data['mar']?></button>
                                            <p class="text-center fw-semibold"><?=$data['mar_pay']?> р.</p>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="март" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['mar']?>" obj="<?=$id?>" cnt-table="<?=$marArenda?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["apr"]) {
                                        ?>
                                            <button type="button" class="btn btn-outline-primary arena-cnt" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="апрель" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['apr']?>" obj="<?=$id?>" cnt-table="<?=$aprArenda?>" pay="<?=$data['apr_pay']?>"><?=$data['apr']?></button>
                                            <p class="text-center fw-semibold"><?=$data['apr_pay']?> р.</p>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="апрель" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['apr']?>" obj="<?=$id?>" cnt-table="<?=$aprArenda?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["may"]) {
                                        ?>
                                            <button type="button" class="btn btn-outline-primary arena-cnt" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="май" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['may']?>" obj="<?=$id?>" cnt-table="<?=$mayArenda?>" pay="<?=$data['may_pay']?>"><?=$data['may']?></button>
                                            <p class="text-center fw-semibold"><?=$data['may_pay']?> р.</p>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="май" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['may']?>" obj="<?=$id?>" cnt-table="<?=$mayArenda?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["jun"]) {
                                        ?>
                                            <button type="button" class="btn btn-outline-primary arena-cnt" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="июнь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['jun']?>" obj="<?=$id?>" cnt-table="<?=$junArenda?>" pay="<?=$data['jun_pay']?>"><?=$data['jun']?></button>
                                            <p class="text-center fw-semibold"><?=$data['jun_pay']?> р.</p>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="июнь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['jun']?>" obj="<?=$id?>" cnt-table="<?=$junArenda?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["jul"]) {
                                        ?>
                                            <button type="button" class="btn btn-outline-primary arena-cnt" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="июль" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['jul']?>" obj="<?=$id?>" cnt-table="<?=$julArenda?>" pay="<?=$data['jul_pay']?>"><?=$data['jul']?></button>
                                            <p class="text-center fw-semibold"><?=$data['jul_pay']?> р.</p>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="июль" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['jul']?>" obj="<?=$id?>" cnt-table="<?=$julArenda?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["aug"]) {
                                        ?>
                                            <button type="button" class="btn btn-outline-primary arena-cnt" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="август" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['aug']?>" obj="<?=$id?>" cnt-table="<?=$augArenda?>" pay="<?=$data['aug_pay']?>"><?=$data['aug']?></button>
                                            <p class="text-center fw-semibold"><?=$data['aug_pay']?> р.</p>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="август" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['aug']?>" obj="<?=$id?>" cnt-table="<?=$augArenda?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["sep"]) {
                                        ?>
                                            <button type="button" class="btn btn-outline-primary arena-cnt" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="сентябрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['sep']?>" obj="<?=$id?>" cnt-table="<?=$sepArenda?>" pay="<?=$data['sep_pay']?>"><?=$data['sep']?></button>
                                            <p class="text-center fw-semibold"><?=$data['sep_pay']?> р.</p>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="сентябрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['sep']?>" obj="<?=$id?>" cnt-table="<?=$sepArenda?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["oct"]) {
                                        ?>
                                            <button type="button" class="btn btn-outline-primary arena-cnt" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="октябрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['oct']?>" obj="<?=$id?>" cnt-table="<?=$octArenda?>" pay="<?=$data['oct_pay']?>"><?=$data['oct']?></button>
                                            <p class="text-center fw-semibold"><?=$data['oct_pay']?> р.</p>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="октябрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['oct']?>" obj="<?=$id?>" cnt-table="<?=$octArenda?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["nov"]) {
                                        ?>
                                            <button type="button" class="btn btn-outline-primary arena-cnt" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="ноябрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['nov']?>" obj="<?=$id?>" cnt-table="<?=$novArenda?>" pay="<?=$data['nov_pay']?>"><?=$data['nov']?></button>
                                            <p class="text-center fw-semibold"><?=$data['nov_pay']?> р.</p>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="ноябрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['nov']?>" obj="<?=$id?>" cnt-table="<?=$novArenda?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["december"]) {
                                        ?>
                                            <button type="button" class="btn btn-outline-primary arena-cnt" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="декабрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['december']?>" obj="<?=$id?>" cnt-table="<?=$decArenda?>" pay="<?=$data['december_pay']?>"><?=$data['december']?></button>
                                            <p class="text-center fw-semibold"><?=$data['december_pay']?> р.</p>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="декабрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['december']?>" obj="<?=$id?>" cnt-table="<?=$decArenda?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle" colspan="3">
                                <form class="deleteForm" action="./counter/deleteArenda" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id_delete" value="<?=$data['id_counter']?>">
                                    <input type="hidden" name="id_object_delete" value="<?=$id?>">
                                    <button type="submit" class="btn btn-danger deleteButton" onclick="deleteDataFromArendaCounter()">&#10006</button>
                                </form>
                            </td>
                        </tr>
                    <?php
                }
            ?>
        </tbody>
    </table>
    <?php 
        Page::modal('modalForCounters'); 
        Page::modal('modalForNavbar');
        mysqli_close($db);
    ?>
</body>



</html>