<?php
use App\Services\Page;
use App\Services\Router;
if(!$_SESSION['user']) {
    Router::redirect('/');
}
$id = $_GET["id"];
if(!$id) {
    $id = 20;
}

require_once('vendor/db.php');

$query = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.remark, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`,  obcnt.`id_object` AS `cnt`, odev.id_object as devices  FROM `object` LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE `object`.`code_adm` = '$id' ORDER BY `object`.`id_object`");

$datas = [];
while($row = mysqli_fetch_assoc($query)) {
    $datas[] = $row;
}

$usedPower = 0;
$usedForce = 0;
$code_adm = $datas[0]['rues'];

foreach($datas as $key => $data) {
    $usedPower += $data['object_power'];
    $usedForce += ($data['object_power'] * 24 * cal_days_in_month(CAL_GREGORIAN, date('m'), date('y')));
}
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
    .deleteButton {
        margin-right: 62%;
    }
    .object_name {
        text-align: left;
    }
</style>

<body>
    <?php 
    Page::part('navbar'); 
    include("views/components/table.php");
    include("views/modal/modalForObject.php"); 
    include('views/modal/modalForNavbar.php');
    mysqli_close($db);
    ?>
</body>



</html>