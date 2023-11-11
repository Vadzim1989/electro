<?php
    class ExcelImport {

        public function electro($data) {
            require('vendor/db.php');
            require_once("app/Controllers/Excel.php");

            $object_name = $data['object_name'];
            $code_adm = $data['code_adm'];
            $dateFrom = $data['dateFrom'];
            $dateTo = $data['dateTo'];
            $years = $data['years'];

            $dateFrom = explode("-", $dateFrom);
            $dateTo = explode("-", $dateTo);
            
            $dataMonths = [];
            for($i = $dateFrom[0]; $i <= $dateFrom[0] + $years; $i++) {
                for($j = 1; $j < 13; $j++) {
                    if($j < 10) {
                        $dataMonths[] = "counter_0".$j.$i; 
                    }else {
                        $dataMonths[] = "counter_".$j.$i;
                    }
                }
            }
            $month = [];
            $monthForTable = [];
            $tables = "";
            $rows = "";        
            $temp = "";

            $indexMonthFrom = array_search("counter_".$dateFrom[1].$dateFrom[0], $dataMonths);
            $indexMonthTo = array_search("counter_".$dateTo[1].$dateTo[0], $dataMonths);
            for($i = $indexMonthFrom; $i <= $indexMonthTo + 1; $i++) {
                $month[] = $dataMonths[$i];
            }
            for($i = 0; $i < count($month); $i++) {
                $tables .= " LEFT JOIN `".$month[$i]."` cnt".$i." ON (cnt".$i.".id_counter = obc.id_counter)";
            }            
            for($i = 0; $i < count($month) - 1; $i++) {
                $rows .= ", (SUM(cnt".($i+1).".value) - (SUM(cnt".$i.".value))) as cnt".$i."";
                $tempMonth = $month[$i];
                $tempMonth = explode('_', $tempMonth);
                $monthForTable[] = $tempMonth[1];
            }

            $query = mysqli_query($db,"SELECT DISTINCT obj.id_object, obj.object_name, obcal.name as rues, objm.used $rows FROM `object_counter` obc LEFT JOIN `counter_type` ct ON (obc.counter_type = ct.counter_type) LEFT JOIN `object` obj ON(obj.id_object = obc.id_object) $tables LEFT JOIN `object_code_adm_list` obcal ON (obj.code_adm = obcal.code_adm) LEFT JOIN `object_mount` objm ON (objm.id_object = obj.id_object) WHERE obj.object_name like '%$object_name%' AND obj.code_adm like '%$code_adm%' AND ct.counter_type = 1  group by 1,2,3,4 order by obcal.name");
            $queryData = [];
            while($row = mysqli_fetch_assoc($query)) {
                $queryData[] = $row;
            }
            $datas = [];

            foreach($queryData as $data) {
                if(is_null($data['used']) || $data['used'] == 0) {
                    continue;
                }else{
                    $datas[] = $data;                  
                }
            }

            $rows = array("УЭС,ЗУЭС","Наименование объекта","Задествованная емкость объекта (портов)","Потребление кВт.ч на задействованный порт за месяц","Удельное потребление");
            for($i = 0; $i < count($monthForTable); $i++) {
                array_push($rows,"Потребление за ".$monthForTable[$i]);
            }

            $filename = array("","","Удельное потребление эл.энергии на монтированный порт","","");            
            $excel = new ExportDataExcel('browser');
            $excel->filename="analis_electro_".date('dmY').".xls";
            $excel->initialize();
            $excel->addRow($filename);
            $excel->addRow($rows);
            $i=3;

            $arr = [];

            for($i = 0; $i < count($datas); $i++) {
                for($j = 0; $j < count($month) - 1; $j++) {
                    if(!is_null($datas[$i]['cnt'.$j]) || $datas[$i]['cnt'.$j] != 0 || $datas[$i]['cnt'.$j] > 0) {
                        $temp = $datas[$i]['cnt'.$j];
                    }else{
                        $temp = 1;
                    }
                }
                if($temp == 1 || $temp < 0) {
                    continue;
                }
                $arr[$i] = ['rues' => $datas[$i]['rues'], 'object_name' => $datas[$i]['object_name'], 'used' => $datas[$i]['used'], 'usedKvt' => $temp/$datas[$i]['used'], 'udel' => ($temp/$datas[$i]['used']*1000)/(24*cal_days_in_month(CAL_GREGORIAN, $dateTo[1], $dateTo[0]))];
                for($j = 0; $j < count($month) - 1; $j++) {
                    $arr[$i]['cnt'.$j] = $datas[$i]["cnt".$j];
                }
                $excel->addRow($arr[$i]);
            }      
            mysqli_close($db);
            $excel->finalize();
        }

        public function analis($data) {
            require('vendor/db.php'); 
            require_once("app/Controllers/Excel.php");
            
            if($data['code_adm'] == 0) {
                $code_adm = '';
            } else {
                $code_adm = $data['code_adm'];
            }
            $object_name = $data['object_name'];
            $dateFrom = $data['dateFrom'];
            $dateTo = $data['dateTo'];
            $years = $data['years'];

            $dateFrom = explode("-", $dateFrom);
            $dateTo = explode("-", $dateTo);

            $start = $dateFrom[0] - 1;
            $dataMonths = [];
            for($i = $start; $i <= $dateFrom[0] + $years; $i++) {
                for($j = 1; $j < 13; $j++) {
                    if($j < 10) {
                        $dataMonths[] = "counter_0".$j.$i; 
                    }else {
                        $dataMonths[] = "counter_".$j.$i;
                    }
                }
            }
            $dataMonthArenda = [];
            for($i = $start; $i <= $dateFrom[0] + $years; $i++) {
                for($j = 1; $j < 13; $j++) {
                    if($j < 10) {
                        $dataMonthArenda[] = "arenda_0".$j.$i; 
                    }else {
                        $dataMonthArenda[] = "arenda_".$j.$i;
                    }
                }
            }
    
            $month = [];
            $monthArenda = [];
            $monthForTable = [];
            $tables = "";
            $tablesArenda = '';
            $rows = "";          
            $rowsArenda = ''; 
    
            $indexMonthFrom = array_search("counter_".$dateFrom[1].$dateFrom[0], $dataMonths);
            $indexMonthTo = array_search("counter_".$dateTo[1].$dateTo[0], $dataMonths);
            for($i = $indexMonthFrom - 1; $i <= $indexMonthTo; $i++) {
                $month[] = $dataMonths[$i];
            }
            for($i = 0; $i < count($month); $i++) {
                $tables .= " LEFT JOIN `".$month[$i]."` cnt".$i." ON (cnt".$i.".id_counter = obc.id_counter)";
            }            
            for($i = 0; $i < count($month) - 1; $i++) {
                $rows .= ", (SUM(cnt".($i+1).".value) - (SUM(cnt".$i.".value))) as cnt".$i."";            
            }
            for($i = 1; $i < count($month); $i++) {
                $tempMonth = $month[$i];
                $tempMonth = explode('_', $tempMonth);
                $monthForTable[] = $tempMonth[1];
            }
    
            $indexMonthFromArenda = array_search("arenda_".$dateFrom[1].$dateFrom[0], $dataMonthArenda);
            $indexMonthToArenda = array_search("arenda_".$dateTo[1].$dateTo[0], $dataMonthArenda); 
            
            for($i = $indexMonthFromArenda - 1; $i <= $indexMonthToArenda; $i++) {
                $monthArenda[] = $dataMonthArenda[$i];
            }
            
            
            for($i = 0; $i < count($monthArenda); $i++) {
                $tablesArenda .= " LEFT JOIN `".$monthArenda[$i]."` cnt".$i." ON (cnt".$i.".id_counter = obc.id_counter)";
            } 
            
            for($i = 0; $i < count($monthArenda) - 1; $i++) {
                $rowsArenda .= ", SUM(cnt".($i).".value) as cnt".$i."";                        
            }
            $query = mysqli_query($db, "SELECT DISTINCT obj.id_object, obj.object_name, obcal.name as rues $rows FROM `object_counter` obc LEFT JOIN `counter_type` ct ON (obc.counter_type = ct.counter_type) LEFT JOIN `object` obj ON(obj.id_object = obc.id_object) $tables LEFT JOIN `object_code_adm_list` obcal ON (obj.code_adm = obcal.code_adm) LEFT JOIN `object_mount` objm ON (objm.id_object = obj.id_object) WHERE obj.object_name like '%$object_name%' AND obj.code_adm like '%$code_adm%' AND ct.counter_type = 1 group by 1,2,3 order by obcal.name");        
    
            while($row = mysqli_fetch_assoc($query)) {
                $queryData[] = $row;           
            }
        
            $datas = [];
            
            for($i=0; $i<count($queryData);$i++){
                $arenda = mysqli_query($db, "SELECT DISTINCT obc.id_object $rowsArenda FROM `object_counter_arenda` obc $tablesArenda WHERE obc.id_object = '".$queryData[$i]['id_object']."' AND `counter_type` = 1");
                $arenda = mysqli_fetch_assoc($arenda);
                
                for($j = 0; $j < count($monthArenda) - 1; $j++) {
                    $queryData[$i]['arn'.$j] = $arenda['cnt'.$j];
                }
            }
            
            $arr = [];
            for($i = 0; $i < count($queryData); $i++) {
                $arr[$i] = array('rues' => $queryData[$i]['rues'], 'object_name' => $queryData[$i]['object_name']);
                for($j = 0; $j < count($monthArenda) - 1; $j++) {
                    if(!is_null($queryData[$i]['cnt'.$j]) || !is_null($queryData[$i]['arn'.$j])) {
                        $arr[$i]['cnt'.$j] = $queryData[$i]['cnt'.$j]; 
                        $arr[$i]['arn'.$j] = $queryData[$i]['arn'.$j]; 
                        $arr[$i]['div'.$j] = $queryData[$i]['cnt'.$j] - $queryData[$i]['arn'.$j];
                        if($arr[$i]['div'.$j]) {
                            $arr[$i]['proc'.$j] = abs(round(($queryData[$i]['cnt'.$j] - $queryData[$i]['arn'.$j])/(($queryData[$i]['cnt'.$j] + $queryData[$i]['arn'.$j])/2)*100,2));
                        } else {
                            $arr[$i]['proc'.$j] = 0;
                        }
                    }else {
                        $arr[$i]['cnt'.$j] = 0; 
                        $arr[$i]['arn'.$j] = 0; 
                        $arr[$i]['div'.$j] = 0;
                        $arr[$i]['proc'.$j] = 0;
                    }
                }
            }
            
            
            for($i = 0; $i < count($arr); $i++) {
                $count = 0;
                for($j = 0; $j < count($monthArenda) - 1; $j++) {
                    if($arr[$i]['arn'.$j] > 0) {
                        $count++;
                    }
                }
                if($count > 0) {
                    $datas[] = $arr[$i];
                }
            }

           
            $filename = array("","","Расхождение показаний по электроэнергии","","");
            $rows = array("УЭС,ЗУЭС","Наименование объекта");
            for($i = 0; $i < count($monthForTable); $i++) {
                array_push($rows, "ЦТЭ ".$monthForTable[$i], "СФ ".$monthForTable[$i], "Раз.", "%");
            }
            $excel = new ExportDataExcel('browser');
            $excel->filename="analis_conflict_".date('dmY').".xls";
            $excel->initialize();
            $excel->addRow($filename);
            $excel->addRow($rows);

            $arrExcell = [];
            for($i = 0; $i < count($datas); $i++) {
                $arrExcell[$i] = ['rues' => $datas[$i]['rues'],'object_name' => $datas[$i]['object_name']];
                for($j = 0; $j < count($month) - 1; $j++) {
                    $arrExcell[$i]['cnt'.$j] = $datas[$i]['cnt'.$j];
                    $arrExcell[$i]['arn'.$j] = $datas[$i]['arn'.$j];
                    $arrExcell[$i]['div'.$j] = $datas[$i]['div'.$j];
                    $arrExcell[$i]['proc'.$j] = $datas[$i]['proc'.$j];
                }
                $excel->addRow($arrExcell[$i]);
            }
            mysqli_close($db);
            $excel->finalize();            
        }

        public function analisArenda() {
            require('vendor/db.php'); 
            require_once("app/Controllers/Excel.php");

            $query = mysqli_query($db,"SELECT obcal.name as rues, o.`object_name`, c.`equip_address`, c.`landlord`, c.`contract_num`, c.`contract_start`, c.`contract_end`, c.`landlord_area`,  c.`byn` FROM `contracts` c LEFT JOIN `object_contracts` oc ON (c.`id_contract` = oc.`id_contract`) LEFT JOIN `object` o ON (oc.`id_object` = o.`id_object`) LEFT JOIN `object_code_adm_list` obcal ON (o.code_adm = obcal.code_adm) WHERE oc.id_object IS NOT NULL order by obcal.name");

            $datas = [];
            while($row = mysqli_fetch_assoc($query)) {
                $datas[] = $row;
            }

            $filename = array("","","Арендуемые объекты","","");
            $rows = array("УЭС,ЗУЭС","Наименование объекта","Адрес объекта аренды","Арендодатель","Номер договора","Дата начала действия договора","Дата окончания действия договора","Площадь (кв.м.)","Арендная плата (руб.)");
            $excel = new ExportDataExcel('browser');
            $excel->filename="analis_arenda_".date('dmY').".xls";
            $excel->initialize();
            $excel->addRow($filename);
            $excel->addRow($rows);

            foreach($datas as $data) {
                $row = array($data['rues'],$data['object_name'],$data['equip_address'],$data['landlord'],$data['contract_num'],$data['contract_start'],$data['contract_end'],$data['landlord_area'],$data['byn']);
                $excel->addRow($row);
            }
            mysqli_close($db);
            $excel->finalize();
        }

        public function object($data) {
            require('vendor/db.php'); 
            require_once("app/Controllers/Excel.php");
            print_r($data);
            $name = $data['object_name'];
            $code_adm = $data['code_adm'];
            $sort = $data['sort'];
            $contract = $data['contract'] ? $data['contract'] : '';
            $area = $data['area'] ? $data['area'] : '';
            $landlord = $data['landlord'] ? $data['landlord'] : '';

            $obj = $data['obj'];
            $dev = $data['dev'];
            $cnt = $data['cnt'];


            if(!$contract && !$area && !$landlord) {
                if($obj) {
                    if($dev && $cnt) {
                        $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power` FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE (`object`.id_object not in (select id_object from `object_mount`) or `object`.id_object not in (select id_object from `object_power`)) and `object`.id_object not in (select id_object from `object_counter`) and `object`.id_object not in (select id_object from `object_devices`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' ORDER BY $sort");
                    }elseif($dev && !$cnt) {
                        $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power` FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE (`object`.id_object not in (select id_object from `object_mount`) or `object`.id_object not in (select id_object from `object_power`)) and `object`.id_object not in (select id_object from `object_devices`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' ORDER BY $sort");
                    }elseif($cnt && !$dev) {
                        $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE (`object`.id_object not in (select id_object from `object_mount`) or `object`.id_object not in (select id_object from `object_power`)) and `object`.id_object not in (select id_object from `object_counter`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' ORDER BY $sort");
                    }else {
                        $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE (`object`.id_object not in (select id_object from `object_mount`) or `object`.id_object not in (select id_object from `object_power`)) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' ORDER BY $sort");
                    }        
                }elseif($dev) {
                    if($cnt) {
                        $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE `object`.id_object not in (select id_object from `object_devices`) and `object`.id_object not in (select id_object from `object_counter`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' ORDER BY $sort");
                    }else {
                        $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE `object`.id_object not in (select id_object from `object_devices`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' ORDER BY $sort");
                    }
                }elseif($cnt) {
                    $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE `object`.id_object not in (select id_object from `object_counter`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' ORDER BY $sort");
                }else {
                    $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' ORDER BY $sort");
                }
            }else{
                if($obj) {
                    if($dev && $cnt) {
                        $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE (`object`.id_object not in (select id_object from `object_mount`) or `object`.id_object not in (select id_object from `object_power`)) and `object`.id_object not in (select id_object from `object_counter`) and `object`.id_object not in (select id_object from `object_devices`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' AND c.contract_num like '%$contract%' AND c.landlord_area LIKE '%$area%' AND c.landlord LIKE '%$landlord%' ORDER BY $sort");
                    }elseif($dev && !$cnt) {
                        $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE (`object`.id_object not in (select id_object from `object_mount`) or `object`.id_object not in (select id_object from `object_power`)) and `object`.id_object not in (select id_object from `object_devices`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' AND c.contract_num like '%$contract%' AND c.landlord_area LIKE '%$area%' AND c.landlord LIKE '%$landlord%' ORDER BY $sort");
                    }elseif($cnt && !$dev) {
                        $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE (`object`.id_object not in (select id_object from `object_mount`) or `object`.id_object not in (select id_object from `object_power`)) and `object`.id_object not in (select id_object from `object_counter`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' AND c.contract_num like '%$contract%' AND c.landlord_area LIKE '%$area%' AND c.landlord LIKE '%$landlord%' ORDER BY $sort");
                    }else {
                        $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE (`object`.id_object not in (select id_object from `object_mount`) or `object`.id_object not in (select id_object from `object_power`)) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' AND c.contract_num like '%$contract%' AND c.landlord_area LIKE '%$area%' AND c.landlord LIKE '%$landlord%' ORDER BY $sort");
                    }        
                }elseif($dev) {
                    if($cnt) {
                        $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`  FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE `object`.id_object not in (select id_object from `object_devices`) and `object`.id_object not in (select id_object from `object_counter`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' AND c.contract_num like '%$contract%' AND c.landlord_area LIKE '%$area%' AND c.landlord LIKE '%$landlord%' ORDER BY $sort");
                    }else {
                        $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power` FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE `object`.id_object not in (select id_object from `object_devices`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' AND c.contract_num like '%$contract%' AND c.landlord_area LIKE '%$area%' AND c.landlord LIKE '%$landlord%' ORDER BY $sort");
                    }
                }elseif($cnt) {
                    $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power` FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE `object`.id_object not in (select id_object from `object_counter`) and `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' AND c.contract_num like '%$contract%' AND c.landlord_area LIKE '%$area%' AND c.landlord LIKE '%$landlord%' ORDER BY $sort");
                }else {
                    $objects = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power` FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) WHERE `object`.`object_name` like '%$name%' and `object`.code_adm like '%$code_adm%' AND c.contract_num like '%$contract%' AND c.landlord_area LIKE '%$area%' AND c.landlord LIKE '%$landlord%' ORDER BY $sort");
                }
            }
            

            $datas = [];
            while($row = mysqli_fetch_assoc($objects)) {
                $datas[] = $row;
            }

            $filename = array("","","Фильтр по объектам","","");
            $rows = array("ID","УЭС,ЗУЭС","Наименование объекта","Монтировано","Задействовано","Мощность");
            $excel = new ExportDataExcel('browser');
            $excel->filename="filter_object_".date('dmY').".xls";
            $excel->initialize();
            $excel->addRow($filename);
            $excel->addRow($rows);

            foreach($datas as $data) {
                $row = array($data['id_object'],$data['rues'],$data['object_name'],$data['mount'],$data['used'],$data['object_power']);
                $excel->addRow($row);
            }
            mysqli_close($db);
            $excel->finalize();  
        }

        public function filterArenda($data) {
            require('vendor/db.php'); 
            require_once("app/Controllers/Excel.php");

            $code_adm = $data['code_adm'];
            $num = $data['contract'] ? $data['contract'] : '';
            $address = $data['address'] ? $data['address'] : '';
            $area = $data['area'] ? $data['area'] : '';
            $sort = $data['sort'];

            $choice = $data['data'];

            if($choice) {
                if($code_adm) {
                    $query = mysqli_query($db,"SELECT c.`id_contract`, c.`landlord`, c.`unp`, c.`landlord_address`, c.`object`, c.`equip_address`, c.`contract_num`, c.`contract_start`, c.`contract_end`, c.`landlord_area`, c.`wall`, c.`length`, c.`bav`, c.`byn`, c.`nds`, c.`pay_attribute`, c.`pay_date`, c.`comments`, c.`area`, c.`part`, oc.`id_object`, o.`object_name`, o.`code_adm`, ocal.name as rues, c.code_adm as code FROM `contracts` c LEFT JOIN `object_contracts` oc ON (c.`id_contract` = oc.`id_contract`) LEFT JOIN `object` o ON (oc.`id_object` = o.`id_object`) LEFT JOIN `object_code_adm_list` ocal ON (c.code_adm = ocal.code_adm) WHERE (contract_num like '%$num%' or contract_num like '$num') and (equip_address like '%$address%' or equip_address like '$address') and (landlord_area like '%$area%' or landlord_area like '$area') and oc.`id_object` is null and c.code_adm like '%$code_adm%' order by $sort");
                }else{
                    $query = mysqli_query($db,"SELECT c.`id_contract`, c.`landlord`, c.`unp`, c.`landlord_address`, c.`object`, c.`equip_address`, c.`contract_num`, c.`contract_start`, c.`contract_end`, c.`landlord_area`, c.`wall`, c.`length`, c.`bav`, c.`byn`, c.`nds`, c.`pay_attribute`, c.`pay_date`, c.`comments`, c.`area`, c.`part`, oc.`id_object`, o.`object_name`, o.`code_adm`, ocal.name as rues, c.code_adm as code FROM `contracts` c LEFT JOIN `object_contracts` oc ON (c.`id_contract` = oc.`id_contract`) LEFT JOIN `object` o ON (oc.`id_object` = o.`id_object`) LEFT JOIN `object_code_adm_list` ocal ON (c.code_adm = ocal.code_adm) WHERE (contract_num like '%$num%' or contract_num like '$num') and (equip_address like '%$address%' or equip_address like '$address') and (landlord_area like '%$area%' or landlord_area like '$area') and oc.`id_object` is null order by $sort");
                }                
            } else {
                if($code_adm) {
                    $query = mysqli_query($db,"SELECT c.`id_contract`, c.`landlord`, c.`unp`, c.`landlord_address`, c.`object`, c.`equip_address`, c.`contract_num`, c.`contract_start`, c.`contract_end`, c.`landlord_area`, c.`wall`, c.`length`, c.`bav`, c.`byn`, c.`nds`, c.`pay_attribute`, c.`pay_date`, c.`comments`, c.`area`, c.`part`, oc.`id_object`, o.`object_name`, o.`code_adm`, ocal.name as rues, c.code_adm as code FROM `contracts` c LEFT JOIN `object_contracts` oc ON (c.`id_contract` = oc.`id_contract`) LEFT JOIN `object` o ON (oc.`id_object` = o.`id_object`) LEFT JOIN `object_code_adm_list` ocal ON (c.code_adm = ocal.code_adm) WHERE (contract_num like '%$num%' or contract_num like '$num') and (equip_address like '%$address%' or equip_address like '$address') and (landlord_area like '%$area%' or landlord_area like '$area') and c.code_adm like '%$code_adm%' order by $sort");
                }else{
                    $query = mysqli_query($db,"SELECT c.`id_contract`, c.`landlord`, c.`unp`, c.`landlord_address`, c.`object`, c.`equip_address`, c.`contract_num`, c.`contract_start`, c.`contract_end`, c.`landlord_area`, c.`wall`, c.`length`, c.`bav`, c.`byn`, c.`nds`, c.`pay_attribute`, c.`pay_date`, c.`comments`, c.`area`, c.`part`, oc.`id_object`, o.`object_name`, o.`code_adm`, ocal.name as rues, c.code_adm as code FROM `contracts` c LEFT JOIN `object_contracts` oc ON (c.`id_contract` = oc.`id_contract`) LEFT JOIN `object` o ON (oc.`id_object` = o.`id_object`) LEFT JOIN `object_code_adm_list` ocal ON (c.code_adm = ocal.code_adm) WHERE (contract_num like '%$num%' or contract_num like '$num') and (equip_address like '%$address%' or equip_address like '$address') and (landlord_area like '%$area%' or landlord_area like '$area') order by $sort");
                }                
            }

            $datas = [];
            while($row = mysqli_fetch_assoc($query)) {
                $datas[] = $row;
            }

            $filename = array("","","Фильтр по арендуемым объектам");
            $rows = array("УЭС,ЗУЭС","Наименование объекта", "Арендодатель", "№ договора", "Адрес", "Площадь");
            $excel = new ExportDataExcel('browser');
            $excel->filename="filter_arenda_".date('dmY').".xls";
            $excel->initialize();
            $excel->addRow($filename);
            $excel->addRow($rows);

            foreach($datas as $data) {
                $row = array($data['rues'],$data['object_name'],$data['landlord'], $data['contract_num'], $data['equip_address'], $data['landlord_area']);
                $excel->addRow($row);
            }
            mysqli_close($db);
            $excel->finalize(); 
        }

        public function objectsExcel($data) {
            
            require('vendor/db.php');
            require_once("app/Controllers/Excel.php");

            $code_adm = isset($data['code_adm']) ? $data['code_adm'] : ''; 

            if(!$code_adm) {
                $query = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.remark, `object`.`object_name`, oa.`address`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power` FROM `object` LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) ORDER BY `object`.`id_object`");
            }else {
                $query = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.remark, `object`.`object_name`, oa.`address`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power` FROM `object` LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) WHERE `object`.`code_adm` like '%$code_adm%' ORDER BY `object`.`id_object`");
            }

            $datas = [];
            while($row = mysqli_fetch_assoc($query)) {
                $datas[] = $row;
            }

            $filename = array("","","","Информация по объектам","","","","");
            $rows = array("УЭС,ЗУЭС","Наименование объекта", "Адрес", "Монтировано", "Задействовано", "Мощность", "Оборудование", "Примечание");
            $excel = new ExportDataExcel('browser');
            $excel->filename="objects_info_".date('dmY').".xls";
            $excel->initialize();
            $excel->addRow($filename);
            $excel->addRow($rows);

            foreach($datas as $data) {
                $devices = mysqli_query($db, "SELECT `device_name` FROM `object_devices` WHERE `id_object` = '".$data['id_object']."'");
                $device = '';
                while($row = mysqli_fetch_assoc($devices)) {
                    $device .= "".$row['device_name']."; \n";
                }
                $row = array($data['rues'], $data['object_name'], $data['address'], $data['mount'], $data['used'], $data['object_power'], $device, $data['remark']);
                $excel->addRow($row);

            }

            mysqli_close($db);
            $excel->finalize(); 
        }

        public function warm($data) {
            require('vendor/db.php');
            require_once("app/Controllers/Excel.php");

            $object_name = $data['object_name'];
            $code_adm = $data['code_adm'];
            $dateFrom = $data['dateFrom'];
            $dateTo = $data['dateTo'];
            $years = $data['years'];

            $dateFrom = explode("-", $dateFrom);
            $dateTo = explode("-", $dateTo);

            $dataMonths = [];
            for($i = $dateFrom[0]; $i <= $dateFrom[0] + $years; $i++) {
                for($j = 1; $j < 13; $j++) {
                    if($j < 10) {
                        $dataMonths[] = "counter_0".$j.$i; 
                    }else {
                        $dataMonths[] = "counter_".$j.$i;
                    }
                }
            }
            $month = [];
            $monthForTable = [];
            $tables = "";
            $rows = "";
            $temp = "";
    
            $indexMonthFrom = array_search("counter_".$dateFrom[1].$dateFrom[0], $dataMonths);
            $indexMonthTo = array_search("counter_".$dateTo[1].$dateTo[0], $dataMonths);
            for($i = $indexMonthFrom; $i <= $indexMonthTo + 1; $i++) {
                $month[] = $dataMonths[$i];
            }
            for($i = 0; $i < count($month); $i++) {
                $tables .= " LEFT JOIN `".$month[$i]."` cnt".$i." ON (cnt".$i.".id_counter = obc.id_counter)";
            }            
            for($i = 0; $i < count($month) - 1; $i++) {
                $rows .= ", (SUM(cnt".($i+1).".value) - (SUM(cnt".$i.".value))) as cnt".$i."";
                $tempMonth = $month[$i];
                $tempMonth = explode('_', $tempMonth);
                $monthForTable[] = $tempMonth[1];
            }
            
            $query = mysqli_query($db,"SELECT DISTINCT obj.id_object, obj.object_name, obj.area, obcal.name as rues, oc.id_object as arenda $rows FROM `object_counter` obc LEFT JOIN `counter_type` ct ON (obc.counter_type = ct.counter_type) LEFT JOIN `object` obj ON(obj.id_object = obc.id_object) $tables LEFT JOIN `object_code_adm_list` obcal ON (obj.code_adm = obcal.code_adm) LEFT JOIN `object_contracts` oc ON (obj.id_object = oc.id_object) WHERE obj.object_name like '%$object_name%' AND obj.code_adm like '%$code_adm%' AND ct.counter_type = 2  group by 1,2,3,4,5 order by obcal.name");
    
            $queryData = [];
            while($row = mysqli_fetch_assoc($query)) {
                $queryData[] = $row;
            }
            $datas = [];
            foreach($queryData as $key => $data) {
                if(is_null($data['area']) || $data['area'] == 0) {
                    continue;
                }else{
                    $datas[] = $data;  
                }
            }

            $rows = array("УЭС,ЗУЭС","Наименование объекта","Принадлежность помещения","Площадь","Потребление Гкал на кв.м.");
            for($i = 0; $i < count($monthForTable); $i++) {
                array_push($rows,"Потребление за ".$monthForTable[$i]);
            }
    
            $arr = [];
            $filename = array("","","Удельное потребление теп.энергии на кв.м. занимаемой площади","","");            
            $excel = new ExportDataExcel('browser');
            $excel->filename="analis_warm_".date('dmY').".xls";
            $excel->initialize();
            $excel->addRow($filename);
            $excel->addRow($rows);
            $i=3;

            for($i = 0; $i < count($datas); $i++) {
                for($j = 0; $j < count($month) - 1; $j++) {
                    if(!is_null($datas[$i]['cnt'.$j]) || $datas[$i]['cnt'.$j] != 0) {
                        $temp = $datas[$i]['cnt'.$j];
                    }else{
                        $temp = 1;
                    }
                }
                if($temp == 1 || $temp < 0) {
                    continue;
                }
                $arr[$i] = ['rues' => $datas[$i]['rues'], 'object_name' => $datas[$i]['object_name'], 'arendaObj' => $datas[$i]['arenda'], 'areaObj' => $datas[$i]['area'], 'udel' => $temp/$datas[$i]['area']];
                for($j = 0; $j < count($month) - 1; $j++) {
                    $arr[$i]['cnt'.$j] = $datas[$i]["cnt".$j];
                }    
                $excel->addRow($arr[$i]);    
            }
            mysqli_close($db);
            $excel->finalize();
        }
    }
?>