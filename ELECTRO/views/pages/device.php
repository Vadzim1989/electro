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
$datas = \R::getAll("SELECT * FROM `object_devices` WHERE `id_object` = '$id'");

$object = mysqli_query($db, "SELECT `object_name` FROM `object` WHERE `id_object` = '$id'");
$object = mysqli_fetch_assoc($object);

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
    .device-table {
        max-width: 100rem;
        margin: auto;
    }
</style>

<body>
    <?php Page::part('navbar'); ?>
    <h2 class="text-center">&#127969 <?=$object['object_name']?></h2>
    <table class="table table-striped device-table">
        <thead>
            <tr>
                <th>№</th>
                <th>Оборудование</th>
                <th>Установлено</th>
                <th>Используется</th>
                <th>Потребляемая мощность, Вт</th>
                <th>Время работы</th>
                <th>
                    <button type="button" title="Добавить оборудование" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDevice" id-obj="<?=$id?>" obj-nam="<?=$object['object_name']?>">&#10010</button>
                </th>
            </tr>
        </thead> 
        <tbody>
            <?php
                foreach ($datas as $key => $data) {
                    # code...
                    ?>
                        <tr>
                            <td class="align-middle id_counter"><?= $data["id_device"] ?></td>
                            <td class="align-middle name"><?= $data["device_name"] ?></td>
                            <td class="align-middle"><?= $data["device_mount"] ?></td>
                            <td class="align-middle"><?= $data["device_used"] ?></td>
                            <td class="align-middle"><?= $data["device_power"] ?></td>
                            <td class="align-middle"><?= $data["device_time"] ?></td>
                            <td class="align-middle">
                                <button type="button" title="Информация" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateDevice" id-obj="<?=$data['id_object']?>" id-dev="<?=$data['id_device']?>" dev-nam="<?=$data['device_name']?>" dev-mnt="<?=$data['device_mount']?>" dev-use="<?=$data['device_used']?>" dev-pw="<?=$data['device_power']?>" dev-tm="<?=$data['device_time']?>">&#9997</button>
                            </td>
                        </tr>
                    <?php
                }
            ?>
        </tbody>
    </table>
    <?php Page::part('deviceModal'); ?>
</body>



</html>