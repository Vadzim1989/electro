<?php
use App\Services\Page;
use App\Services\Router;
if(!$_SESSION['user']) {
    Router::redirect('/');
}
require_once('vendor/db.php');
if(isset($_POST['filter_arenda'])) {
    $num = $_POST['contract_num'] ? $_POST['contract_num'] : '';
    $address = $_POST['equip_address'] ? $_POST['equip_address'] : '';
    $area = $_POST['landlord_area'] ? $_POST['landlord_area'] : '';
    $sort = $_POST['sort'];

    $arendas = mysqli_query($db, "SELECT * FROM contracts WHERE (contract_num like '%$num%' or contract_num like '$num') and (equip_address like '%$address%' or equip_address like '$address') and (landlord_area like '%$area%' or landlord_area like '$area') order by $sort");

    $arenda = [];
    while($row = mysqli_fetch_assoc($arendas)) {
        $arenda[] = $row;
    }
} elseif(isset($_POST['filter_object'])) {
    $name = isset($_POST['object_name']) ? $_POST['object_name'] : '';
    $code_adm = $_POST['code_adm'];
    $contract = isset($_POST['contract_num']) ? $_POST['contract_num'] : '';
    $area = isset($_POST['area']) ? $_POST['area'] : '';
    $landlord = isset($_POST['landlord']) ? $_POST['landlord'] : '';
    $sort = $_POST['sort'];
    
    $obj = isset($_POST['object_filter']) ? $_POST['object_filter'] : '';
    $dev = isset($_POST['device_filter']) ? $_POST['device_filter'] : '';
    $cnt = isset($_POST['counter_filter']) ? $_POST['counter_filter'] : '';

    if(!$contract || !$area || !$landlord) {
        if($obj) {
            if($dev && $cnt) {
                $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.device_name as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE (`object`.id_object not in (select id_object from `object_mount`) or `object`.id_object not in (select id_object from `object_power`)) and `object`.id_object not in (select id_object from `object_counter`) and `object`.id_object not in (select id_object from `object_devices`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' ORDER BY $sort");
            }elseif($dev && !$cnt) {
                $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.device_name as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE (`object`.id_object not in (select id_object from `object_mount`) or `object`.id_object not in (select id_object from `object_power`)) and `object`.id_object not in (select id_object from `object_devices`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' ORDER BY $sort");
            }elseif($cnt && !$dev) {
                $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.device_name as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE (`object`.id_object not in (select id_object from `object_mount`) or `object`.id_object not in (select id_object from `object_power`)) and `object`.id_object not in (select id_object from `object_counter`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' ORDER BY $sort");
            }else {
                $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.device_name as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE (`object`.id_object not in (select id_object from `object_mount`) or `object`.id_object not in (select id_object from `object_power`)) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' ORDER BY $sort");
            }        
        }elseif($dev) {
            if($cnt) {
                $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.device_name as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE `object`.id_object not in (select id_object from `object_devices`) and `object`.id_object not in (select id_object from `object_counter`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' ORDER BY $sort");
            }else {
                $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.device_name as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE `object`.id_object not in (select id_object from `object_devices`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' ORDER BY $sort");
            }
        }elseif($cnt) {
            $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.device_name as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE `object`.id_object not in (select id_object from `object_counter`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' ORDER BY $sort");
        }else {
            $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.device_name as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' ORDER BY $sort");
        }
    }else{
        if($obj) {
            if($dev && $cnt) {
                $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.device_name as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE (`object`.id_object not in (select id_object from `object_mount`) or `object`.id_object not in (select id_object from `object_power`)) and `object`.id_object not in (select id_object from `object_counter`) and `object`.id_object not in (select id_object from `object_devices`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' AND c.contract_num like '%$contract%' AND c.landlord_area LIKE '%$area%' AND c.landlord LIKE '%$landlord%' ORDER BY $sort");
            }elseif($dev && !$cnt) {
                $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.device_name as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE (`object`.id_object not in (select id_object from `object_mount`) or `object`.id_object not in (select id_object from `object_power`)) and `object`.id_object not in (select id_object from `object_devices`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' AND c.contract_num like '%$contract%' AND c.landlord_area LIKE '%$area%' AND c.landlord LIKE '%$landlord%' ORDER BY $sort");
            }elseif($cnt && !$dev) {
                $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.device_name as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE (`object`.id_object not in (select id_object from `object_mount`) or `object`.id_object not in (select id_object from `object_power`)) and `object`.id_object not in (select id_object from `object_counter`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' AND c.contract_num like '%$contract%' AND c.landlord_area LIKE '%$area%' AND c.landlord LIKE '%$landlord%' ORDER BY $sort");
            }else {
                $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.device_name as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE (`object`.id_object not in (select id_object from `object_mount`) or `object`.id_object not in (select id_object from `object_power`)) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' AND c.contract_num like '%$contract%' AND c.landlord_area LIKE '%$area%' AND c.landlord LIKE '%$landlord%' ORDER BY $sort");
            }        
        }elseif($dev) {
            if($cnt) {
                $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.device_name as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE `object`.id_object not in (select id_object from `object_devices`) and `object`.id_object not in (select id_object from `object_counter`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' AND c.contract_num like '%$contract%' AND c.landlord_area LIKE '%$area%' AND c.landlord LIKE '%$landlord%' ORDER BY $sort");
            }else {
                $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.device_name as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE `object`.id_object not in (select id_object from `object_devices`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' AND c.contract_num like '%$contract%' AND c.landlord_area LIKE '%$area%' AND c.landlord LIKE '%$landlord%' ORDER BY $sort");
            }
        }elseif($cnt) {
            $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.device_name as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE `object`.id_object not in (select id_object from `object_counter`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' AND c.contract_num like '%$contract%' AND c.landlord_area LIKE '%$area%' AND c.landlord LIKE '%$landlord%' ORDER BY $sort");
        }else {
            $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.device_name as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' AND c.contract_num like '%$contract%' AND c.landlord_area LIKE '%$area%' AND c.landlord LIKE '%$landlord%' ORDER BY $sort");
        }
    }
    
    $object = [];
    while($row = mysqli_fetch_assoc($objects)) {
        $object[] = $row;
    }
} elseif(isset($_POST['filter_counter'])) {
    $year = $_POST['year'];
    $id = $_POST['id_object'];

    $jan = "counter_01".$year;
    $feb = "counter_02".$year;
    $mar = "counter_03".$year;
    $apr = "counter_04".$year;
    $may = "counter_05".$year;
    $jun = "counter_06".$year;
    $jul = "counter_07".$year;
    $aug = "counter_08".$year;
    $sep = "counter_09".$year;
    $oct = "counter_10".$year;
    $nov = "counter_11".$year;
    $dec = "counter_12".$year;

    $janArenda = "arenda_01".$year;
    $febArenda = "arenda_02".$year;
    $marArenda = "arenda_03".$year;
    $aprArenda = "arenda_04".$year;
    $mayArenda = "arenda_05".$year;
    $junArenda = "arenda_06".$year;
    $julArenda = "arenda_07".$year;
    $augArenda = "arenda_08".$year;
    $sepArenda = "arenda_09".$year;
    $octArenda = "arenda_10".$year;
    $novArenda = "arenda_11".$year;
    $decArenda = "arenda_12".$year;


    $datas = \R::getAll("SELECT obc.id_counter, obc.online, obc.sn, obc.counter_type, ct.name, jan.value AS jan, f.value AS feb, mar.value AS mar, apr.value AS apr, may.value AS may, jun.value AS jun, jul.value AS jul, aug.value AS aug, s.value AS sep, o.value AS oct, n.value AS nov, d.value AS december FROM `object_counter` obc LEFT JOIN `counter_type` ct ON (obc.counter_type = ct.counter_type) LEFT JOIN `$jan` jan ON (jan.id_counter = obc.id_counter) LEFT JOIN `$feb` f ON (f.id_counter = obc.id_counter) LEFT JOIN `$mar` mar ON (mar.id_counter = obc.id_counter) LEFT JOIN `$apr` apr ON (apr.id_counter = obc.id_counter) LEFT JOIN `$may` may ON (may.id_counter = obc.id_counter) LEFT JOIN `$jun` jun ON (jun.id_counter = obc.id_counter) LEFT JOIN `$jul` jul ON (jul.id_counter = obc.id_counter) LEFT JOIN `$aug` aug ON (aug.id_counter = obc.id_counter) LEFT JOIN `$sep` s ON (s.id_counter = obc.id_counter) LEFT JOIN `$oct` o ON (o.id_counter = obc.id_counter) LEFT JOIN `$nov` n ON (n.id_counter = obc.id_counter) LEFT JOIN `$dec` d ON (d.id_counter = obc.id_counter) WHERE obc.id_object = '$id'");

    $arenda = mysqli_query($db,"SELECT DISTINCT obc.counter_type, obc.id_counter, ct.name, jan.value AS jan, f.value AS feb, mar.value AS mar, apr.value AS apr, may.value AS may, jun.value AS jun, jul.value AS jul, aug.value AS aug, s.value AS sep, o.value AS oct, n.value AS nov, d.value AS december, jan.pay as jan_pay, f.pay as feb_pay, mar.pay as mar_pay, apr.pay as apr_pay, may.pay as may_pay, jun.pay as jun_pay, jul.pay as jul_pay, aug.pay as aug_pay, s.pay as sep_pay, o.pay as oct_pay, n.pay as nov_pay, d.pay as december_pay  FROM `object_counter_arenda` obc LEFT JOIN `counter_type` ct ON (obc.counter_type = ct.counter_type) LEFT JOIN `$janArenda` jan ON (jan.id_counter = obc.id_counter) LEFT JOIN `$febArenda` f ON (f.id_counter = obc.id_counter) LEFT JOIN `$marArenda` mar ON (mar.id_counter = obc.id_counter) LEFT JOIN `$aprArenda` apr ON (apr.id_counter = obc.id_counter) LEFT JOIN `$mayArenda` may ON (may.id_counter = obc.id_counter) LEFT JOIN `$junArenda` jun ON (jun.id_counter = obc.id_counter) LEFT JOIN `$julArenda` jul ON (jul.id_counter = obc.id_counter) LEFT JOIN `$augArenda` aug ON (aug.id_counter = obc.id_counter) LEFT JOIN `$sepArenda` s ON (s.id_counter = obc.id_counter) LEFT JOIN `$octArenda` o ON (o.id_counter = obc.id_counter) LEFT JOIN `$novArenda` n ON (n.id_counter = obc.id_counter) LEFT JOIN `$decArenda` d ON (d.id_counter = obc.id_counter) WHERE obc.id_object = '$id'");

    $arendas = [];
    if($arendas) {
        while($row = mysqli_fetch_assoc($arenda)) {
            $arendas[] = $row;
        }
    }    
}

?>
<!DOCTYPE html>
<html lang="en">
<?php 
    Page::part('head');
    Page::part('navbar');
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
</style>
<body>
<?php
    if(isset($_POST['filter_arenda'])) {
        require_once('/OSPanel/domains/localhost/ELECTRO/views/components/tables/filterArenda.php');
        Page::part('contractModal'); 
    }elseif(isset($_POST['filter_object'])){
        require_once('/OSPanel/domains/localhost/ELECTRO/views/components/tables/filterObject.php');
        Page::part('objectModal');  
        Page::part('navbarModal');
    }elseif(isset($_POST['filter_counter'])) {
        require_once('/OSPanel/domains/localhost/ELECTRO/views/components/tables/filterCounter.php');
        Page::part('counterModal');
    }
?>
</body>
</html>