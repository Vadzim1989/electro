<?php
use App\Services\Page;
use App\Services\Router;
if(!$_SESSION['user']) {
    Router::redirect('/');
}
require_once('vendor/db.php');

if(isset($_GET['filter_arenda'])) {
    $code_adm = $_GET['code_adm'] != 0 ? $_GET['code_adm'] : '';
    $num = $_GET['contract_num'] ? $_GET['contract_num'] : '';
    $address = $_GET['equip_address'] ? $_GET['equip_address'] : '';
    $area = $_GET['landlord_area'] ? $_GET['landlord_area'] : '';
    $sort = $_GET['sort'];
    $area = str_replace(',','.',$area);
    
    if(isset($_GET['data'])) {
        $choice = $_GET['data'];
    }else {
        $choice = '';
    }

    if(isset($_GET['data'])) {
        if($code_adm) {
            $arendas = mysqli_query($db, "SELECT c.`id_contract`, c.`landlord`, c.`unp`, c.`landlord_address`, c.`object`, c.`equip_address`, c.`contract_num`, c.`contract_start`, c.`contract_end`, c.`landlord_area`, c.`wall`, c.`length`, c.`bav`, c.`byn`, c.`nds`, c.`pay_attribute`, c.`pay_date`, c.`comments`, c.`area`, c.`part`, oc.`id_object`, o.`object_name`, o.`code_adm`, ocal.name as rues, c.code_adm as code FROM `contracts` c LEFT JOIN `object_contracts` oc ON (c.`id_contract` = oc.`id_contract`) LEFT JOIN `object` o ON (oc.`id_object` = o.`id_object`) LEFT JOIN `object_code_adm_list` ocal ON (c.code_adm = ocal.code_adm) WHERE (contract_num like '%$num%' or contract_num like '$num') and (equip_address like '%$address%' or equip_address like '$address') and (landlord_area like '%$area%' or landlord_area like '$area') and oc.`id_object` is null and c.code_adm like '%$code_adm%' order by $sort");
        }else {
            $arendas = mysqli_query($db, "SELECT c.`id_contract`, c.`landlord`, c.`unp`, c.`landlord_address`, c.`object`, c.`equip_address`, c.`contract_num`, c.`contract_start`, c.`contract_end`, c.`landlord_area`, c.`wall`, c.`length`, c.`bav`, c.`byn`, c.`nds`, c.`pay_attribute`, c.`pay_date`, c.`comments`, c.`area`, c.`part`, oc.`id_object`, o.`object_name`, o.`code_adm`, ocal.name as rues, c.code_adm as code FROM `contracts` c LEFT JOIN `object_contracts` oc ON (c.`id_contract` = oc.`id_contract`) LEFT JOIN `object` o ON (oc.`id_object` = o.`id_object`) LEFT JOIN `object_code_adm_list` ocal ON (c.code_adm = ocal.code_adm) WHERE (contract_num like '%$num%' or contract_num like '$num') and (equip_address like '%$address%' or equip_address like '$address') and (landlord_area like '%$area%' or landlord_area like '$area') and oc.`id_object` is null order by $sort");
        }        
    } else {
        if($code_adm) {
            $arendas = mysqli_query($db, "SELECT c.`id_contract`, c.`landlord`, c.`unp`, c.`landlord_address`, c.`object`, c.`equip_address`, c.`contract_num`, c.`contract_start`, c.`contract_end`, c.`landlord_area`, c.`wall`, c.`length`, c.`bav`, c.`byn`, c.`nds`, c.`pay_attribute`, c.`pay_date`, c.`comments`, c.`area`, c.`part`, oc.`id_object`, o.`object_name`, o.`code_adm`, ocal.name as rues, c.code_adm as code FROM `contracts` c LEFT JOIN `object_contracts` oc ON (c.`id_contract` = oc.`id_contract`) LEFT JOIN `object` o ON (oc.`id_object` = o.`id_object`) LEFT JOIN `object_code_adm_list` ocal ON (c.code_adm = ocal.code_adm) WHERE (contract_num like '%$num%' or contract_num like '$num') and (equip_address like '%$address%' or equip_address like '$address') and (landlord_area like '%$area%' or landlord_area like '$area') and c.code_adm like '%$code_adm%' order by $sort");
        }else {
            $arendas = mysqli_query($db, "SELECT c.`id_contract`, c.`landlord`, c.`unp`, c.`landlord_address`, c.`object`, c.`equip_address`, c.`contract_num`, c.`contract_start`, c.`contract_end`, c.`landlord_area`, c.`wall`, c.`length`, c.`bav`, c.`byn`, c.`nds`, c.`pay_attribute`, c.`pay_date`, c.`comments`, c.`area`, c.`part`, oc.`id_object`, o.`object_name`, o.`code_adm`, ocal.name as rues, c.code_adm as code FROM `contracts` c LEFT JOIN `object_contracts` oc ON (c.`id_contract` = oc.`id_contract`) LEFT JOIN `object` o ON (oc.`id_object` = o.`id_object`) LEFT JOIN `object_code_adm_list` ocal ON (c.code_adm = ocal.code_adm) WHERE (contract_num like '%$num%' or contract_num like '$num') and (equip_address like '%$address%' or equip_address like '$address') and (landlord_area like '%$area%' or landlord_area like '$area') order by $sort");
        }        
    }    

    $datas = [];
    while($row = mysqli_fetch_assoc($arendas)) {
        $datas[] = $row;
    }
    //Заебали!
} elseif(isset($_GET['filter_object'])) {
    $name = isset($_GET['object_name']) ? $_GET['object_name'] : '';
    $code_adm = $_GET['code_adm'] == 0 ? '' : $_GET['code_adm'];
    $sort = $_GET['sort'];
    
    $contract = isset($_GET['contract_num']) ? $_GET['contract_num'] : '';
    $area = isset($_GET['area']) ? $_GET['area'] : '';
    $landlord = isset($_GET['landlord']) ? $_GET['landlord'] : '';
    $area = str_replace(',','.',$area);

    $obj = isset($_GET['object_filter']) ? $_GET['object_filter'] : '';
    $dev = isset($_GET['device_filter']) ? $_GET['device_filter'] : '';
    $cnt = isset($_GET['counter_filter']) ? $_GET['counter_filter'] : '';
    
    if(!$contract && !$area && !$landlord) {
        if($obj) {
            if($dev && $cnt) {
                $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.id_object as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE (`object`.id_object not in (select id_object from `object_mount`) or `object`.id_object not in (select id_object from `object_power`)) and `object`.id_object not in (select id_object from `object_counter`) and `object`.id_object not in (select id_object from `object_devices`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' ORDER BY $sort");
            }elseif($dev && !$cnt) {
                $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.id_object as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE (`object`.id_object not in (select id_object from `object_mount`) or `object`.id_object not in (select id_object from `object_power`)) and `object`.id_object not in (select id_object from `object_devices`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' ORDER BY $sort");
            }elseif($cnt && !$dev) {
                $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.id_object as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE (`object`.id_object not in (select id_object from `object_mount`) or `object`.id_object not in (select id_object from `object_power`)) and `object`.id_object not in (select id_object from `object_counter`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' ORDER BY $sort");
            }else {
                $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.id_object as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE (`object`.id_object not in (select id_object from `object_mount`) or `object`.id_object not in (select id_object from `object_power`)) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' ORDER BY $sort");
            }        
        }elseif($dev) {
            if($cnt) {
                $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.id_object as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE `object`.id_object not in (select id_object from `object_devices`) and `object`.id_object not in (select id_object from `object_counter`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' ORDER BY $sort");
            }else {
                $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.id_object as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE `object`.id_object not in (select id_object from `object_devices`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' ORDER BY $sort");
            }
        }elseif($cnt) {
            $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.id_object as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE `object`.id_object not in (select id_object from `object_counter`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' ORDER BY $sort");
        }else {
            $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.id_object as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' ORDER BY $sort");
        }
    }else{
        if($obj) {
            if($dev && $cnt) {
                $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.id_object as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE (`object`.id_object not in (select id_object from `object_mount`) or `object`.id_object not in (select id_object from `object_power`)) and `object`.id_object not in (select id_object from `object_counter`) and `object`.id_object not in (select id_object from `object_devices`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' AND c.contract_num like '%$contract%' AND c.landlord_area LIKE '%$area%' AND c.landlord LIKE '%$landlord%' ORDER BY $sort");
            }elseif($dev && !$cnt) {
                $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.id_object as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE (`object`.id_object not in (select id_object from `object_mount`) or `object`.id_object not in (select id_object from `object_power`)) and `object`.id_object not in (select id_object from `object_devices`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' AND c.contract_num like '%$contract%' AND c.landlord_area LIKE '%$area%' AND c.landlord LIKE '%$landlord%' ORDER BY $sort");
            }elseif($cnt && !$dev) {
                $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.id_object as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE (`object`.id_object not in (select id_object from `object_mount`) or `object`.id_object not in (select id_object from `object_power`)) and `object`.id_object not in (select id_object from `object_counter`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' AND c.contract_num like '%$contract%' AND c.landlord_area LIKE '%$area%' AND c.landlord LIKE '%$landlord%' ORDER BY $sort");
            }else {
                $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.id_object as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE (`object`.id_object not in (select id_object from `object_mount`) or `object`.id_object not in (select id_object from `object_power`)) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' AND c.contract_num like '%$contract%' AND c.landlord_area LIKE '%$area%' AND c.landlord LIKE '%$landlord%' ORDER BY $sort");
            }        
        }elseif($dev) {
            if($cnt) {
                $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.id_object as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE `object`.id_object not in (select id_object from `object_devices`) and `object`.id_object not in (select id_object from `object_counter`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' AND c.contract_num like '%$contract%' AND c.landlord_area LIKE '%$area%' AND c.landlord LIKE '%$landlord%' ORDER BY $sort");
            }else {
                $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.id_object as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE `object`.id_object not in (select id_object from `object_devices`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' AND c.contract_num like '%$contract%' AND c.landlord_area LIKE '%$area%' AND c.landlord LIKE '%$landlord%' ORDER BY $sort");
            }
        }elseif($cnt) {
            $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.id_object as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE `object`.id_object not in (select id_object from `object_counter`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' AND c.contract_num like '%$contract%' AND c.landlord_area LIKE '%$area%' AND c.landlord LIKE '%$landlord%' ORDER BY $sort");
        }else {
            $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`,  odev.id_object as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' AND c.contract_num like '%$contract%' AND c.landlord_area LIKE '%$area%' AND c.landlord LIKE '%$landlord%' ORDER BY $sort");
        }
    }

    $datas = [];
    while($row = mysqli_fetch_assoc($objects)) {
        $datas[] = $row;
    }
} elseif(isset($_GET['filter_counter'])) {
    $year = $_GET['year'];
    $id = $_GET['id_object'];

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


    $query = mysqli_query($db, "SELECT obc.id_counter, obc.online, obc.sn, obc.counter_type, ct.name, jan.value AS jan, f.value AS feb, mar.value AS mar, apr.value AS apr, may.value AS may, jun.value AS jun, jul.value AS jul, aug.value AS aug, s.value AS sep, o.value AS oct, n.value AS nov, d.value AS december FROM `object_counter` obc LEFT JOIN `counter_type` ct ON (obc.counter_type = ct.counter_type) LEFT JOIN `$jan` jan ON (jan.id_counter = obc.id_counter) LEFT JOIN `$feb` f ON (f.id_counter = obc.id_counter) LEFT JOIN `$mar` mar ON (mar.id_counter = obc.id_counter) LEFT JOIN `$apr` apr ON (apr.id_counter = obc.id_counter) LEFT JOIN `$may` may ON (may.id_counter = obc.id_counter) LEFT JOIN `$jun` jun ON (jun.id_counter = obc.id_counter) LEFT JOIN `$jul` jul ON (jul.id_counter = obc.id_counter) LEFT JOIN `$aug` aug ON (aug.id_counter = obc.id_counter) LEFT JOIN `$sep` s ON (s.id_counter = obc.id_counter) LEFT JOIN `$oct` o ON (o.id_counter = obc.id_counter) LEFT JOIN `$nov` n ON (n.id_counter = obc.id_counter) LEFT JOIN `$dec` d ON (d.id_counter = obc.id_counter) WHERE obc.id_object = '$id'");

    $datas = [];
    if($query) {
        while($row = mysqli_fetch_assoc($query)) {
            $datas[] = $row;
        }
    } 

    $arenda = mysqli_query($db,"SELECT DISTINCT obc.counter_type, obc.id_counter, ct.name, jan.value AS jan, f.value AS feb, mar.value AS mar, apr.value AS apr, may.value AS may, jun.value AS jun, jul.value AS jul, aug.value AS aug, s.value AS sep, o.value AS oct, n.value AS nov, d.value AS december, jan.pay as jan_pay, f.pay as feb_pay, mar.pay as mar_pay, apr.pay as apr_pay, may.pay as may_pay, jun.pay as jun_pay, jul.pay as jul_pay, aug.pay as aug_pay, s.pay as sep_pay, o.pay as oct_pay, n.pay as nov_pay, d.pay as december_pay  FROM `object_counter_arenda` obc LEFT JOIN `counter_type` ct ON (obc.counter_type = ct.counter_type) LEFT JOIN `$janArenda` jan ON (jan.id_counter = obc.id_counter) LEFT JOIN `$febArenda` f ON (f.id_counter = obc.id_counter) LEFT JOIN `$marArenda` mar ON (mar.id_counter = obc.id_counter) LEFT JOIN `$aprArenda` apr ON (apr.id_counter = obc.id_counter) LEFT JOIN `$mayArenda` may ON (may.id_counter = obc.id_counter) LEFT JOIN `$junArenda` jun ON (jun.id_counter = obc.id_counter) LEFT JOIN `$julArenda` jul ON (jul.id_counter = obc.id_counter) LEFT JOIN `$augArenda` aug ON (aug.id_counter = obc.id_counter) LEFT JOIN `$sepArenda` s ON (s.id_counter = obc.id_counter) LEFT JOIN `$octArenda` o ON (o.id_counter = obc.id_counter) LEFT JOIN `$novArenda` n ON (n.id_counter = obc.id_counter) LEFT JOIN `$decArenda` d ON (d.id_counter = obc.id_counter) WHERE obc.id_object = '$id'");

    $arendas = [];
    if($arendas) {
        while($row = mysqli_fetch_assoc($arenda)) {
            $arendas[] = $row;
        }
    }    
} elseif(isset($_GET['filter_arendaList'])) {
    $id_object = $_GET['id'];

    $arendas = mysqli_query($db, "SELECT c.`id_contract`, c.`landlord`, c.`unp`, c.`landlord_address`, c.`object`, c.`equip_address`, c.`contract_num`, c.`contract_start`, c.`contract_end`, c.`landlord_area`, c.`wall`, c.`length`, c.`bav`, c.`byn`, c.`nds`, c.`pay_attribute`, c.`pay_date`, c.`comments`, c.`area`, c.`part`, oc.`id_object`, o.`object_name`, o.`code_adm`, ocal.name as rues, c.code_adm as code FROM `contracts` c LEFT JOIN `object_contracts` oc ON (c.`id_contract` = oc.`id_contract`) LEFT JOIN `object` o ON (oc.`id_object` = o.`id_object`) LEFT JOIN `object_code_adm_list` ocal ON (c.code_adm = ocal.code_adm) WHERE o.id_object = '$id_object'");

    $datas = [];
    while($row = mysqli_fetch_assoc($arendas)) {
        $datas[] = $row;
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
    if(isset($_GET['filter_arenda'])) {
        require_once('views/components/filters/filterArenda.php');
        include('views/modal/modalForContracts.php');
    }elseif(isset($_GET['filter_object'])){
        require_once('views/components/filters/filterObject.php');
        include('views/modal/modalForObject.php');
    }elseif(isset($_GET['filter_counter'])) {
        require_once('views/components/filters/filterCounter.php');
        include('views/modal/modalForCounters.php');
    }elseif(isset($_GET['filter_arendaList'])) {
        require_once('views/components/filters/filterArenda.php');
        include('views/modal/modalForContracts.php');
    }
    include('views/modal/modalForNavbar.php');
    mysqli_close($db);
?>
</body>
</html>