<?php
use App\Services\Page;
require_once('vendor/db.php');
include('functions/getDataByRues.php');

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

// опрос БД на наличие таблиц по месяцам и году

for($i = 0; $i < 12; $i++) {
    if(mysqli_query($db, "SELECT * FROM `". $month[$i]."`")) { // если есть таблица, пропускаем итерацию
        continue;
    } else { // если нету, создаем таблицу
        mysqli_query($db, "CREATE TABLE `".$month[$i]."` (`id_counter` INT(10) NOT NULL DEFAULT '0', `value` DECIMAL(10,3) NOT NULL DEFAULT '0', `date_input` DATE NOT NULL) COLLATE='utf8mb3_general_ci' ENGINE=MYISAM;");
    };
};

for($i = 0; $i < 12; $i++) {
    if(mysqli_query($db, "SELECT * FROM `". $monthArenda[$i]."`")) { // если есть таблица, пропускаем итерацию
        continue;
    } else { // если нету, создаем таблицу
        mysqli_query($db, "CREATE TABLE `".$monthArenda[$i]."` (`id_counter` INT(10) NOT NULL DEFAULT '0', `value` DECIMAL(10,3) NOT NULL DEFAULT '0', `pay` DECIMAL(10,3) NULL DEFAULT NULL, `date_input` DATE NOT NULL)");
    };
};


// коннект к БД с показаниями счетчиков

$counterConn = mysqli_connect('10.245.31.5', 'counter', '@1QAZwsx', 'ctell');

$table = 'counter_'.date('mY');
$counters = mysqli_query($db, "SELECT `id_counter` FROM `object_counter`");
$counters = mysqli_fetch_all($counters);

// опрос показаний счетчиков по имеющимся заводским номерам 
if(!$_SESSION['user']['counter']) {
    $_SESSION['user']['counter'] = true;
    for($i = 0; $i < count($counters); $i++) {
        $counterID = $counters[$i][0];

        $sn = mysqli_query($db, "SELECT `sn` FROM `object_counter` WHERE `id_counter` = '$counterID'");
        $sn = mysqli_fetch_assoc($sn);
        $sn = $sn['sn'];

        $date = date('Y-m-d');

        $cntData = mysqli_query($counterConn, "SELECT v0ind FROM bm_cnt_data INNER JOIN (SELECT c_id, MAX(id) AS maxid FROM bm_cnt_data WHERE c_id = (select c_id from bm_cnts where fact_num like '%$sn' LIMIT 1)) AS m where bm_cnt_data.id = m.maxid");
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
            mysqli_query($db, "INSERT INTO `$table`(`id_counter`, `value`, `date_input`, `arenda_cnt`, `arenda_pay`) VALUES ('$counterID', '$value', '$date', NULL, NULL)");
            mysqli_query($db, "UPDATE `object_counter` SET `online` = 1 WHERE `id_counter` = '$counterID'");
        }
        
    };
};
?>

<!DOCTYPE html>
<html lang="en">
<?php Page::part('head'); 
?>

<style>
    table > thead > tr > th,
    table > tbody > tr > td {
        font-size: small;
        text-align: center;
    }
    .object_name {
        text-align: left;
    }
    .id_object {
        font-weight: bold;
    }
    a {
        text-decoration: none;
    }
    .developer {
        font-size: small;
    }
    .device-area {
        resize: none;
    }
    .excel {
        font-size: 1rem;
        padding: 0;
        margin: 0;
        border: none;
    }
    .remark {
        max-width: 30rem;
    }
    .address {
        max-width: 9rem;
    }
    textarea {
        resize: none;
        height: 10rem;
    }
</style>

<body>
    <?php Page::part('navbar'); ?>
    <?php if (isset($_SESSION['user'])) {?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>№</th>
                <th>Название объекта</th>
                <th>Район</th>
                <th>Адрес</th>
                <th>Оборудование на объекте</th>
                <th>Арендодатель</th>
                <th>Монтированая емкость</th>
                <th>Задействованая емкость</th>
                <th>Расчетная мощность, кВт</th>
                <th>Расчетное потребление, кВт*ч</th>                
                <th>Счетчики</th>                
                <th>Примечание</th>
                <th>Правки</th>
                <th>
                    <button type="button" title="Фильтр" class="btn btn-outline-primary ms-3" data-bs-toggle="modal" data-bs-target="#filter">&#128269</button>
                </th>
            </tr>
        </thead> 
        <tbody>
            <?php        
                $datas = getDataByRues($_SESSION['user']['zues']);
                foreach ($datas as $key => $data) {
                    # code...
                    ?>
                        <tr>
                            <td class="align-middle id_object"><?= $data["id_object"] ?></td>
                            <td class="align-middle object_name"><?= $data["object_name"] ?></td>
                            <td class="align-middle"><?= $data["rues"] ?></td>
                            <td class="align-middle address"><?= $data["address"] ?></td>
                            <td class="align-middle text-center">
                                <?php
                                    if($data['devices']) {
                                        ?>
                                            <a class="btn btn-success" href="/ELECTRO/device?id=<?=$data['id_object']?>">&#128736</a>
                                        <?php
                                    } else {
                                        ?>
                                            <a class="btn btn-outline-secondary" href="/ELECTRO/device?id=<?=$data['id_object']?>">&#128736</a>
                                        <?php
                                    }
                                ?>                                
                            </td>
                            <td class="align-middle text-center">
                                <?php
                                    $id_object = $data['id_object'];
                                    $id_contract = mysqli_query($db, "SELECT `id_contract` FROM `object_contracts` WHERE `id_object` = '$id_object'");
                                    $id_contract = mysqli_fetch_row($id_contract);
                                    if(isset($id_contract[0])) {
                                        ?>
                                            <a href="/ELECTRO/arenda?idc=<?=$id_contract[0]?>&ido=<?=$data['id_object']?>&cda=<?=$data['code_adm']?>"><span class='btn btn-success'>&#10003</span></a>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addArenda" id-obj="<?=$data['id_object']?>" obj-name="<?=$data['object_name']?>">&#10007</button>
                                        <?php
                                    }
                                ?>                                
                            </td>
                            <td class="align-middle"><?= $data["mount"] ?></td>
                            <td class="align-middle"><?= $data["used"] ?></td>
                            <td class="align-middle"><?= $data["object_power"] ?></td>
                            <td class="align-middle"><?= $data["object_power"] * 24 * cal_days_in_month(CAL_GREGORIAN, date('m'), date('y'))?></td>                            
                            <td class="align-middle">
                                <?php
                                    if($data['cnt']) {
                                        ?>
                                            <a class="btn btn-success" href="/ELECTRO/counters?id=<?=$data['id_object']?>" onclick="showModalCounter()">&#9881</a>
                                        <?php
                                    } else {
                                        ?>
                                            <a class="btn btn-outline-secondary" href="/ELECTRO/counters?id=<?=$data['id_object']?>" onclick="showModalCounter()">&#9881</a>
                                        <?php
                                    }
                                ?>
                                
                            </td>          
                            <td class="align-middle remark">
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#remark" id="<?= $data['id_object'] ?>" remark="<?=$data['remark']?>" obj-name="<?=$data['object_name']?>" code_adm="<?=$data['code_adm']?>">&#128221</button>
                            </td>                  
                            <td colspan="2" class="align-middle">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateObject" data-bs-id="<?= $data['id_object'] ?>" data-bs-name="<?= $data['object_name'] ?>" data-bs-rues="<?= $data['rues']?>" data-bs-address="<?=$data['address']?>" data-bs-mount="<?=$data['mount']?>" data-bs-used="<?=$data['used']?>" data-bs-power="<?=$data['object_power']?>">&#9997</button>
                            </td>
                        </tr>
                    <?php
                }
            ?>
        </tbody>
        <tfoot class="sticky-bottom bg-success-subtle">
            <tr>
                <td class="text-center" colspan="13">Количество введенных объектов: <?=count($datas)?></td>
            </tr>
        </tfoot>
    </table>
    
    <?php } else { ?>
        <div class="container mt-4 text-center">
            <h1>Добро пожаловать в приложение ELECTRO</h1>
            <br>
            <p>Для пользования данным приложением Вам необходимо авторизироваться.</p>
            <p>Для этого пройдите по ссылке <a href="/ELECTRO/login"><i><u>"Войти"</u></i></a> и введите реквезиты доступа.</p>
            <p>В случаи отсутсвия реквезитов, обратитесь к администратору для предоставления прав доступа.</p>
            <br><br><br>
        </div>
        <div class="container mt-4 text-end developer">
            <p><i>инженер-программист Денисовский В.В.</i></p>
        </div>
    <?php } ?>

    <?php Page::part('objectModal');  Page::part('navbarModal');?>
</body>


</html>