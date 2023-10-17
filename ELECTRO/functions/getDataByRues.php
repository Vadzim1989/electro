<?php
function getDataByCodeadm($code) {
    $data = \R::getAll("SELECT DISTINCT `object`.`id_object`, `object`.remark, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, c.`landlord`, c.`id_contract`, obcnt.`id_object` AS `cnt`,  odev.device_name as devices  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE `object`.`code_adm` IN ($code) ORDER BY `object`.`id_object`");
    return $data;
}

function getDataByRues($data) {
    if($data == 'all') {
        $datas = \R::getAll('SELECT DISTINCT `object`.`id_object`,`object`.remark, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, c.`landlord`, obcnt.`id_object` AS `cnt`, odev.id_object as devices  FROM `object` LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) ORDER BY `object`.`id_object`');
    } elseif($data == 'gomelzues') {
        $datas = getDataByCodeadm('30,33,79');
    } elseif($data == 'jlobin') {
        $datas = getDataByCodeadm('32,34,36,37,39');
    } elseif($data == 'gomel') {
        $datas = getDataByCodeadm(20);
    } elseif($data == 'kalin') {
        $datas = getDataByCodeadm('42,45,50,53,57');
    } elseif($data == 'mozir') {
        $datas = getDataByCodeadm('51,54,55,56');
    } elseif($data == 'rech') {
        $datas = getDataByCodeadm('40,44,46,47');
    }
    return $datas;
}