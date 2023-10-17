<?php
use App\Services\Page;
use App\Services\Router;
if(!$_SESSION['user']) {
    Router::redirect('/');
}
require_once('./vendor/db.php');
$id = $_GET["id"];

$datas = \R::getAll("SELECT DISTINCT `object`.`id_object`, `object`.remark, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, c.`landlord`, c.`id_contract`, obcnt.`id_object` AS `cnt`,  odev.device_name as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE `object`.`code_adm` = '$id' ORDER BY `object`.`id_object`");

switch($id){
    case 20:
        if($_SESSION['user']['zues'] != 'gomel' && $_SESSION['user']['zues'] != 'all') {
            Router::redirect('/');
        };
        break;
    case 30:
    case 33:
    case 79:
        if($_SESSION['user']['zues'] != 'gomelzues' && $_SESSION['user']['zues'] != 'all') {
            Router::redirect('/');
        };
        break;
    case 32:
    case 34:
    case 36:
    case 37:
    case 39:
        if($_SESSION['user']['zues'] != 'jlobin' && $_SESSION['user']['zues'] != 'all') {
            Router::redirect('/');
        };
        break;
    case 42:
    case 45:
    case 50:
    case 53:
    case 57:
        if($_SESSION['user']['zues'] != 'kalin' && $_SESSION['user']['zues'] != 'all') {
            Router::redirect('/');
        };
        break;
    case 51:
    case 54:
    case 55:
    case 56:
        if($_SESSION['user']['zues'] != 'mozir' && $_SESSION['user']['zues'] != 'all') {
            Router::redirect('/');
        };
        break;
    case 40:
    case 44:
    case 46:
    case 47:
        if($_SESSION['user']['zues'] != 'rech' && $_SESSION['user']['zues'] != 'all') {
            Router::redirect('/');
        };
        break;
    default:
        break;
}
?>

<!DOCTYPE html>
<html lang="en">
<?php Page::part('head'); 
?>

<style>
    .deleteButton {
        margin-right: 62%;
    }
    table > thead > tr > th {
        font-size: small;
    }
    table > tbody > tr > td {
        font-size: small;
    }
    textarea{
        resize: none;
        height: 10rem;
    }
</style>

<body>
    <?php Page::part('navbar'); ?>  
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
            </tr>
        </thead> 
        <tbody>
            <?php                
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
                                            <a class="btn btn-success" href="/ELECTRO/counters?id=<?=$data['id_object']?>">&#9881</a>
                                        <?php
                                    } else {
                                        ?>
                                            <a class="btn btn-outline-secondary" href="/ELECTRO/counters?id=<?=$data['id_object']?>">&#9881</a>
                                        <?php
                                    }
                                ?>
                                
                            </td>          
                            <td class="align-middle remark">
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#remark" id="<?= $data['id_object'] ?>" remark="<?=$data['remark']?>" obj-name="<?=$data['object_name']?>" code_adm="<?=$data['code_adm']?>">&#128221</button>
                            </td>                  
                            <td class="align-middle text-center">
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
    <?php Page::part('objectModal');  Page::part('navbarModal');?>
</body>



</html>