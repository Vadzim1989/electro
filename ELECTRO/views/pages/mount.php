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

$monthPorts = [
    'ports_01'.date('Y'),
    'ports_02'.date('Y'),
    'ports_03'.date('Y'),
    'ports_04'.date('Y'),
    'ports_05'.date('Y'),
    'ports_06'.date('Y'),
    'ports_07'.date('Y'),
    'ports_08'.date('Y'),
    'ports_09'.date('Y'),
    'ports_10'.date('Y'),
    'ports_11'.date('Y'),
    'ports_12'.date('Y')
];

// опрос БД на наличие таблиц / Создание таблиц

for($i = 0; $i < 12; $i++) {
    $check = mysqli_query($db, "SHOW TABLES FROM `electro` LIKE '".$monthPorts[$i]."'");
    $check = mysqli_fetch_assoc($check);
    if($check) { // если есть таблица, пропускаем итерацию
        continue;
    } else { // если нету, создаем таблицу
        mysqli_query($db, "CREATE TABLE `".$monthPorts[$i]."` (`id_object` INT(10) NULL DEFAULT NULL, `mount` INT(10) NULL DEFAULT NULL, `used` INT(10) NULL DEFAULT NULL, `date_input` DATE NULL DEFAULT NULL) COLLATE='utf8mb3_general_ci' ENGINE=InnoDB");
    };
};

/**
 * Прописать аглоритм переноса задействованной и используемой емкости из предыдущего месяца
 */

$currentMonth = 'ports_'.date('mY');
if($currentMonth == 'ports_01'.date('Y')) {
    $prevMonth = 'ports_12'.(date('Y')-1);
} else {
    $prevMonth = $monthPorts[array_search($currentMonth, $monthPorts) - 1];
}

$objects = mysqli_query($db, "SELECT DISTINCT id_object FROM `object`");
$objects = mysqli_fetch_all($objects);

foreach($objects as $data) {
    $checkValue = mysqli_query($db, "SELECT o.id_object, p.mount, p.used FROM `object` o LEFT JOIN `$currentMonth` p ON (o.id_object = p.id_object) WHERE o.id_object = '".$data[0]."'");
    $checkValue = mysqli_fetch_all($checkValue);
    if(is_null($checkValue[0][1])) {
        mysqli_query($db, "INSERT INTO `$currentMonth` SELECT * FROM `$prevMonth` WHERE id_object = '".$data[0]."'");        
    }
    mysqli_query($db, "UPDATE `object_mount` SET `mount` = (SELECT `mount` FROM `$currentMonth` WHERE `id_object` = '".$data[0]."'), `used` = (SELECT `used` FROM `$currentMonth` WHERE `id_object` = '".$data[0]."') WHERE id_object = '".$data[0]."'");
}

$query = mysqli_query($db, "SELECT  jan.mount AS janm, jan.used as janu, f.mount AS febm, f.used as febu, mar.mount AS marm, mar.used as maru, apr.mount AS aprm, apr.used as apru, may.mount AS maym, may.used as mayu, jun.mount AS junm, jun.used as junu, jul.mount AS julm, jul.used as julu, aug.mount AS augm, aug.used as augu, s.mount AS sepm, s.used as sepu, o.mount AS octm, o.used as octu, n.mount AS novm, n.used as novu, d.mount AS decemberm, d.used as decemberu  FROM `object` obc LEFT JOIN `$monthPorts[0]` jan ON (jan.id_object = obc.id_object) LEFT JOIN `$monthPorts[1]` f ON (f.id_object = obc.id_object) LEFT JOIN `$monthPorts[2]` mar ON (mar.id_object = obc.id_object) LEFT JOIN `$monthPorts[3]` apr ON (apr.id_object = obc.id_object) LEFT JOIN `$monthPorts[4]` may ON (may.id_object = obc.id_object) LEFT JOIN `$monthPorts[5]` jun ON (jun.id_object = obc.id_object) LEFT JOIN `$monthPorts[6]` jul ON (jul.id_object = obc.id_object) LEFT JOIN `$monthPorts[7]` aug ON (aug.id_object = obc.id_object) LEFT JOIN `$monthPorts[8]` s ON (s.id_object = obc.id_object) LEFT JOIN `$monthPorts[9]` o ON (o.id_object = obc.id_object) LEFT JOIN `$monthPorts[10]` n ON (n.id_object = obc.id_object) LEFT JOIN `$monthPorts[11]` d ON (d.id_object = obc.id_object) WHERE obc.id_object = '$id'");
$datas = [];
while($row = mysqli_fetch_assoc($query)) {
    $datas[] = $row;
}

$rues = mysqli_query($db, "SELECT obcal.name FROM `object_code_adm_list` obcal WHERE obcal.code_adm in (select code_adm from `object` where id_object = '$id')");
$rues = mysqli_fetch_assoc($rues);

$object = mysqli_query($db, "SELECT `object_name` FROM `object` WHERE `id_object` = '$id'");
$object = mysqli_fetch_assoc($object);

$jan = "ports_01".date('Y');
$feb = "ports_02".date('Y');
$mar = "ports_03".date('Y');
$apr = "ports_04".date('Y');
$may = "ports_05".date('Y');
$jun = "ports_06".date('Y');
$jul = "ports_07".date('Y');
$aug = "ports_08".date('Y');
$sep = "ports_09".date('Y');
$oct = "ports_10".date('Y');
$nov = "ports_11".date('Y');
$dec = "ports_12".date('Y');

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
    <h2 class="text-center"><?=$rues['name']?> - &#127969 <?=$object['object_name']?></h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Емкость</th>
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
                    <button type="button" title="Фильтр" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filter" id-object="<?=$id?>">&#128269</button>
                </th>
            </tr>
        </thead> 
        <tbody>
            <?php
                foreach ($datas as $key => $data) {
                    # code...
                    ?>
                        <tr>
                            <td class="align-middle">Задействовано</td>
                            <td class="align-middle">
                                <?php
                                    if($data["janu"]) {
                                        ?>
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="январь" used="<?=$data['janu']?>" mount="<?=$data['janm']?>" obj="<?=$id?>" table="<?=$jan?>"><?=$data['janu']?></button>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="январь" obj="<?=$id?>" table="<?=$jan?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["febu"]) {
                                        ?>
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="февраль" used="<?=$data['febu']?>" mount="<?=$data['febm']?>" obj="<?=$id?>" table="<?=$feb?>"><?=$data['febu']?></button>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="февраль" obj="<?=$id?>" table="<?=$feb?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>            
                            <td class="align-middle">
                                <?php
                                    if($data["maru"]) {
                                        ?>
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="март" used="<?=$data['maru']?>" mount="<?=$data['marm']?>" obj="<?=$id?>" table="<?=$mar?>"><?=$data['maru']?></button>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="март" obj="<?=$id?>" table="<?=$mar?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["apru"]) {
                                        ?>
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="апрель" used="<?=$data['apru']?>" mount="<?=$data['aprm']?>" obj="<?=$id?>" table="<?=$apr?>"><?=$data['apru']?></button>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="апрель" obj="<?=$id?>" table="<?=$apr?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["mayu"]) {
                                        ?>
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="май" used="<?=$data['mayu']?>" mount="<?=$data['maym']?>" obj="<?=$id?>" table="<?=$may?>"><?=$data['mayu']?></button>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="май" obj="<?=$id?>" table="<?=$may?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["junu"]) {
                                        ?>
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="июнь" used="<?=$data['junu']?>" mount="<?=$data['junm']?>" obj="<?=$id?>" table="<?=$jun?>"><?=$data['junu']?></button>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="июнь" obj="<?=$id?>" table="<?=$jun?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["julu"]) {
                                        ?>
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="июль" used="<?=$data['julu']?>" mount="<?=$data['julm']?>" obj="<?=$id?>" table="<?=$jul?>"><?=$data['julu']?></button>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="июль" obj="<?=$id?>" table="<?=$jul?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["augu"]) {
                                        ?>
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="август" used="<?=$data['augu']?>" mount="<?=$data['augm']?>" obj="<?=$id?>" table="<?=$aug?>"><?=$data['augu']?></button>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="август" obj="<?=$id?>" table="<?=$aug?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["sepu"]) {
                                        ?>
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="сентябрь" used="<?=$data['sepu']?>" mount="<?=$data['sepm']?>" obj="<?=$id?>" table="<?=$sep?>"><?=$data['sepu']?></button>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="сентябрь" obj="<?=$id?>" table="<?=$sep?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["octu"]) {
                                        ?>
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="октябрь" used="<?=$data['octu']?>" mount="<?=$data['octm']?>" obj="<?=$id?>" table="<?=$oct?>"><?=$data['octu']?></button>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="октябрь" obj="<?=$id?>" table="<?=$oct?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["novu"]) {
                                        ?>
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="ноябрь" used="<?=$data['novu']?>" mount="<?=$data['novm']?>" obj="<?=$id?>" table="<?=$nov?>"><?=$data['novu']?></button>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="ноябрь" obj="<?=$id?>" table="<?=$nov?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                    if($data["decemberu"]) {
                                        ?>
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="декабрь" used="<?=$data['decemberu']?>" mount="<?=$data['decemberm']?>" obj="<?=$id?>" table="<?=$dec?>"><?=$data['decemberu']?></button>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="декабрь" obj="<?=$id?>" table="<?=$dec?>">&#10006</button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td class="align-middle">
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle">Монтировано</td>
                            <td class="align-middle"><button class="btn"><?=$data['janm']?></button></td>
                            <td class="align-middle"><button class="btn"><?=$data['febm']?></button></td>
                            <td class="align-middle"><button class="btn"><?=$data['marm']?></button></td>
                            <td class="align-middle"><button class="btn"><?=$data['aprm']?></button></td>
                            <td class="align-middle"><button class="btn"><?=$data['maym']?></button></td>
                            <td class="align-middle"><button class="btn"><?=$data['junm']?></button></td>
                            <td class="align-middle"><button class="btn"><?=$data['julm']?></button></td>
                            <td class="align-middle"><button class="btn"><?=$data['augm']?></button></td>
                            <td class="align-middle"><button class="btn"><?=$data['sepm']?></button></td>
                            <td class="align-middle"><button class="btn"><?=$data['octm']?></button></td>
                            <td class="align-middle"><button class="btn"><?=$data['novm']?></button></td>
                            <td class="align-middle"><button class="btn"><?=$data['decemberm']?></button></td>
                            <td class="align-middle"></td>
                        </tr>
                    <?php
                }
            ?>
        </tbody>
    </table>
    <?php 
        Page::modal('modalForPorts'); 
        Page::modal('modalForNavbar');
        mysqli_close($db);
    ?>
</body>



</html>