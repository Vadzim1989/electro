<?php
use App\Services\Page;
use App\Services\Router;

if(!$_SESSION['user']) {
    Router::redirect('/');
}

require_once('vendor/db.php');

if(isset($_POST['landlord']) && isset($_POST['address'])) {
    unset($_POST['address']);
}

if(isset($_POST['object_name'])) {
    $search = $_POST['object_name'];
    $query = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.remark, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, c.`landlord`, obcnt.`id_object` AS `cnt`, odev.id_object as devices  FROM `object` LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE `object`.`object_name` LIKE '%$search%' ORDER BY `object`.`id_object`");    
} elseif(isset($_POST['landlord'])) {
    $search = $_POST['landlord'];
    $query = mysqli_query($db, "SELECT c.`id_contract`, c.`landlord`, c.`unp`, c.`landlord_address`, c.`object`, c.`equip_address`, c.`contract_num`, c.`contract_start`, c.`contract_end`, c.`landlord_area`, c.`wall`, c.`length`, c.`bav`, c.`byn`, c.`nds`, c.`pay_attribute`, c.`pay_date`, c.`comments`, c.`area`, c.`part`, oc.`id_object`, o.`object_name`, o.`code_adm`, ocal.name as rues, c.code_adm as code FROM `contracts` c LEFT JOIN `object_contracts` oc ON (c.`id_contract` = oc.`id_contract`) LEFT JOIN `object` o ON (oc.`id_object` = o.`id_object`) LEFT JOIN `object_code_adm_list` ocal ON (c.code_adm = ocal.code_adm) WHERE c.`landlord` LIKE '%$search%' ORDER BY c.`id_contract`");
} elseif(isset($_POST['address'])) {
    $search = $_POST['address'];
    $query = mysqli_query($db, "SELECT c.`id_contract`, c.`landlord`, c.`unp`, c.`landlord_address`, c.`object`, c.`equip_address`, c.`contract_num`, c.`contract_start`, c.`contract_end`, c.`landlord_area`, c.`wall`, c.`length`, c.`bav`, c.`byn`, c.`nds`, c.`pay_attribute`, c.`pay_date`, c.`comments`, c.`area`, c.`part`, oc.`id_object`, o.`object_name`, o.`code_adm`, ocal.name as rues, c.code_adm as code FROM `contracts` c LEFT JOIN `object_contracts` oc ON (c.`id_contract` = oc.`id_contract`) LEFT JOIN `object` o ON (oc.`id_object` = o.`id_object`) LEFT JOIN `object_code_adm_list` ocal ON (c.code_adm = ocal.code_adm) WHERE c.`equip_address` LIKE '%$search%' ORDER BY c.`id_contract`");
}

$datas = [];
while($row = mysqli_fetch_assoc($query)) {
    $datas[] = $row;
}


?>

<!DOCTYPE html>
<html lang="en">
<?php Page::part('head'); 
?>

<style>
    table > thead > tr > th {
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
    .developer,
    table > tbody > tr > td {
        font-size: small;
    }
</style>

<body>
    <?php 
    Page::part('navbar'); 
    if(isset($_POST['object_name'])) {
        include("views/components/tableSearchObjects.php");
        include("views/modal/modalForObject.php");
    } elseif(isset($_POST['landlord']) || isset($_POST['address'])) {
        include("views/components/tableSearchContracts.php");
    }
    include('views/modal/modalForNavbar.php'); 
    mysqli_close($db);    
    ?>
</body>


</html>