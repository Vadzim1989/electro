<?php 

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Services\Router;
use mysqli;

class Excel {

    public function objects() {
        
        $datas = \R::getAll("SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, c.`landlord`, c.`id_contract` FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) ORDER BY `object`.`id_object`");

        $spreadsheet = new Spreadsheet();
        
        // Подключение к активной таблице
        $sheet = $spreadsheet->getActiveSheet();

        // Объединяем ячейки от A1:F1
        $sheet->mergeCells('A1:J1');

        // Устанавливаем значение ячейке A1
        $sheet->setCellValue('A1', 'Информация по объектам');

        // Установка значений в шапку таблицы
        $sheet->setCellValue('A2', '№ объекта');
        $sheet->setCellValue('B2', 'Название объекта');
        $sheet->setCellValue('C2', 'Адрес');
        $sheet->setCellValue('D2', 'Регион');
        $sheet->setCellValue('E2', 'Монтировано');
        $sheet->setCellValue('F2', 'Задествовано');
        $sheet->setCellValue('G2', 'Рассчетная мощность');
        $sheet->setCellValue('H2', 'Рассчетное потребление');
        $sheet->setCellValue('I2', 'Оборудование');
        $sheet->setCellValue('J2', 'Зав.№ счетчиков');

        $i=3;

        foreach($datas as $key => $data) {
            $sheet->setCellValue('A'.$i, $data['id_object']);
            $sheet->setCellValue('B'.$i, $data['object_name']);
            $sheet->setCellValue('C'.$i, $data['address']);
            $sheet->setCellValue('D'.$i, $data['rues']);
            $sheet->setCellValue('E'.$i, $data['mount']);
            $sheet->setCellValue('F'.$i, $data['used']);
            $sheet->setCellValue('G'.$i, $data['object_power']);
            $sheet->setCellValue('H'.$i, $data["object_power"] * 24 * cal_days_in_month(CAL_GREGORIAN, date('m'), date('y')));

            $id =  $data['id_object'];

            $counters = \R::getAll("SELECT sn FROM object_counter WHERE id_object = '$id'");
            $cnt = '';
            foreach($counters as $key => $counter) {
                $cnt .= $counter['sn'] . "; ";
            }
            $sheet->setCellValue('J'.$i, $cnt);

            $devices = \R::getAll("SELECT `device_name` FROM object_devices WHERE id_object = '$id'");

            foreach($devices as $key => $device) {
                $sheet->setCellValue('I'.$i, $device['device_name']);
                $i++;       
            }        
            $i++;
        }

        // получение текущей даты, будет использоваться в имени файла
        $dt = date('Ymd');

        // создание объекта Xlsx
        $writer = new Xlsx($spreadsheet);

        // отправка файла в браузер
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=object_info$dt.xlsx");
        $writer->save('php://output');
    }

    public function objectByRues($data) {
    
        $id = $data['code_adm'];
        
        $datas = \R::getAll("SELECT DISTINCT `object`.`id_object`, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, c.`landlord`, c.`id_contract` FROM `object` LEFT JOIN `object_address` ON (`object_address`.id_object = `object`.id_object) LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) WHERE `object`.`code_adm` = '$id' ORDER BY `object`.`id_object`");

        $spreadsheet = new Spreadsheet();
        
        // Подключение к активной таблице
        $sheet = $spreadsheet->getActiveSheet();

        // Объединяем ячейки от A1:F1
        $sheet->mergeCells('A1:J1');

        // Устанавливаем значение ячейке A1
        $sheet->setCellValue('A1', 'Информация по объектам');

        // Установка значений в шапку таблицы
        $sheet->setCellValue('A2', '№ объекта');
        $sheet->setCellValue('B2', 'Название объекта');
        $sheet->setCellValue('C2', 'Адрес');
        $sheet->setCellValue('D2', 'Регион');
        $sheet->setCellValue('E2', 'Монтировано');
        $sheet->setCellValue('F2', 'Задествовано');
        $sheet->setCellValue('G2', 'Рассчетная мощность');
        $sheet->setCellValue('H2', 'Рассчетное потребление');
        $sheet->setCellValue('I2', 'Оборудование');
        $sheet->setCellValue('J2', 'Зав.№ счетчиков');

        $i=3;

        foreach($datas as $key => $data) {
            $sheet->setCellValue('A'.$i, $data['id_object']);
            $sheet->setCellValue('B'.$i, $data['object_name']);
            $sheet->setCellValue('C'.$i, $data['address']);
            $sheet->setCellValue('D'.$i, $data['rues']);
            $sheet->setCellValue('E'.$i, $data['mount']);
            $sheet->setCellValue('F'.$i, $data['used']);
            $sheet->setCellValue('G'.$i, $data['object_power']);
            $sheet->setCellValue('H'.$i, $data["object_power"] * 24 * cal_days_in_month(CAL_GREGORIAN, date('m'), date('y')));

            $id =  $data['id_object'];

            $counters = \R::getAll("SELECT sn FROM object_counter WHERE id_object = '$id'");
            $cnt = '';
            foreach($counters as $key => $counter) {
                $cnt .= $counter['sn'] . "; ";
            }
            $sheet->setCellValue('J'.$i, $cnt);

            $devices = \R::getAll("SELECT `device_name` FROM object_devices WHERE id_object = '$id'");

            foreach($devices as $key => $device) {
                $sheet->setCellValue('I'.$i, $device['device_name']);
                $i++;       
            }        
            $i++;
        }

        // получение текущей даты, будет использоваться в имени файла
        $dt = date('Ymd');

        // создание объекта Xlsx
        $writer = new Xlsx($spreadsheet);

        // отправка файла в браузер
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=object_info$dt.xlsx");
        $writer->save('php://output');
    }

    public function electro($data) {
        if($data['code_adm'] == 0) {
            $code_adm = '';
        } else {
            $code_adm = $data['code_adm'];
        }
        $object_name = $data['object_name'];
        $monthFrom = $data['monthFrom'];
        $monthTo = $data['monthTo'];
        $month = explode("_",$monthFrom);
        
        $datas = \R::getAll("SELECT DISTINCT obj.id_object, obj.object_name, obcal.name as rues, objm.used, ct.name, (sum(cnt2.value) - sum(cnt1.value)) AS value_cnt FROM `object_counter` obc LEFT JOIN `counter_type` ct ON (obc.counter_type = ct.counter_type) LEFT JOIN `object` obj ON(obj.id_object = obc.id_object) LEFT JOIN `$monthFrom` cnt1 ON (cnt1.id_counter = obc.id_counter) LEFT JOIN `$monthTo` cnt2 ON (cnt2.id_counter = obc.id_counter) LEFT JOIN `object_code_adm_list` obcal ON (obj.code_adm = obcal.code_adm) LEFT JOIN `object_mount` objm ON (objm.id_object = obj.id_object) WHERE obj.object_name like '%$object_name%' AND obj.code_adm like '%$code_adm%' AND ct.counter_type = 1 group by 1,2,3,4,5");

        $spreadsheet = new Spreadsheet();
        
        // Подключение к активной таблице
        $sheet = $spreadsheet->getActiveSheet();

        // Объединяем ячейки от A1:F1
        $sheet->mergeCells('A1:F1');

        // Устанавливаем значение ячейке A1
        $sheet->setCellValue('A1', 'Удельное потребление эл.энергии на монтированный порт');

        // Установка значений в шапку таблицы
        $sheet->setCellValue('A2', 'УЭС, ЗУЭС');
        $sheet->setCellValue('B2', 'Наименование объекта');
        $sheet->setCellValue('C2', "Потребление ЭЭ за ".$month[1]." кВт.ч");
        $sheet->setCellValue('D2', 'Задествованная емкость объекта (портов)');
        $sheet->setCellValue('E2', 'Потребление кВт.ч на задействованный порт за месяц');
        $sheet->setCellValue('F2', 'Удельное потребление');

        $i = 3;

        foreach($datas as $key => $data) {
            if(is_null($data['used']) || $data['used'] == 0) {
                $usedkvtmonth = 0;
                $usedkvt = 0;
            } else {
                $usedkvtmonth = ($data['value_cnt'])/$data['used'];
                $usedkvt = ($usedkvtmonth * 1000)/(24*cal_days_in_month(CAL_GREGORIAN, date('m'), date('y')));
            }
            
            $sheet->setCellValue('A'.$i, $data['rues']);
            $sheet->setCellValue('B'.$i, $data['object_name']);
            $sheet->setCellValue('C'.$i, $data['value_cnt']);
            $sheet->setCellValue('D'.$i, $data['used']);
            $sheet->setCellValue('E'.$i, $usedkvtmonth);
            $sheet->setCellValue('F'.$i, $usedkvt);
            $i++;
        }

        // получение текущей даты, будет использоваться в имени файла
        $dt = date('Ymd');

        // создание объекта Xlsx
        $writer = new Xlsx($spreadsheet);
        // отправка файла в браузер
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=analis_electro_$dt.xlsx");
        $writer->save('php://output');        
    }

    public function analis($data) {
        if($data['code_adm'] == 0) {
            $code_adm = '';
        } else {
            $code_adm = $data['code_adm'];
        }
        $object_name = $data['object_name'];
        $monthFrom = $data['monthFrom'];
        $monthTo = $data['monthTo'];
        $monthArenda = $data['monthArenda'];
        $month = explode("_",$monthFrom);

        $query = \R::getAll("SELECT DISTINCT obj.id_object, obj.object_name, obcal.name as rues, (sum(cnt2.value) - sum(cnt1.value)) AS value_cnt, arnd1.value as arenda FROM `object_counter` obc LEFT JOIN `counter_type` ct ON (obc.counter_type = ct.counter_type) LEFT JOIN `object` obj ON(obj.id_object = obc.id_object) LEFT JOIN `$monthFrom` cnt1 ON (cnt1.id_counter = obc.id_counter) LEFT JOIN `$monthTo` cnt2 ON (cnt2.id_counter = obc.id_counter) LEFT JOIN `object_counter_arenda` oba ON (oba.id_object = obj.id_object) LEFT JOIN `$monthArenda` arnd1 ON (arnd1.id_counter = oba.id_counter)  LEFT JOIN `object_code_adm_list` obcal ON (obj.code_adm = obcal.code_adm) LEFT JOIN `object_mount` objm ON (objm.id_object = obj.id_object) WHERE obj.object_name like '%$object_name%' AND obj.code_adm like '%$code_adm%' AND oba.counter_type = 1 AND ct.counter_type = 1 group by 1,2,3,5");

        $datas = [];
        for($i=0; $i<count($query);$i++){
            if($query[$i]['value_cnt'] > $query[$i]['arenda'] || $query[$i]['value_cnt'] < $query[$i]['arenda']) {
                $datas[] = $query[$i];
            }
        }

        $spreadsheet = new Spreadsheet();
        
        // Подключение к активной таблице
        $sheet = $spreadsheet->getActiveSheet();

        // Объединяем ячейки от A1:F1
        $sheet->mergeCells('A1:F1');

        // Устанавливаем значение ячейке A1
        $sheet->setCellValue('A1', 'Расхождение показаний по электроэнергии');

        // Установка значений в шапку таблицы
        $sheet->setCellValue('A2', 'УЭС, ЗУЭС');
        $sheet->setCellValue('B2', 'Наименование объекта');
        $sheet->setCellValue('C2', "Показания по счетчику ЦТЭ за ".$month[1]." кВт.ч");
        $sheet->setCellValue('D2', "Показания по счет-фактуре за ".$month[1]." кВт.ч");
        $sheet->setCellValue('E2', 'Разница между показаниями');
        $sheet->setCellValue('F2', '% расхождения');

        $i = 3;

        foreach($datas as $key => $data) {  
            $counter = $data['value_cnt'];
            $arenda = $data['arenda'];
            $div = $counter - $arenda;
            if($div) {
                $proc = ($counter - $arenda)/(($counter+$arenda)/2)*100;
            } else {
                $proc = 0;
            }
              
            $sheet->setCellValue('A'.$i, $data['rues']);
            $sheet->setCellValue('B'.$i, $data['object_name']);
            $sheet->setCellValue('C'.$i, $data['value_cnt']);
            $sheet->setCellValue('D'.$i, $data['arenda']);
            $sheet->setCellValue('E'.$i, $div);
            $sheet->setCellValue('F'.$i, abs(round($proc,2)));
            $i++;
        }

        // получение текущей даты, будет использоваться в имени файла
        $dt = date('Ymd');

        // создание объекта Xlsx
        $writer = new Xlsx($spreadsheet);
        // отправка файла в браузер
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=analis_conflict_$dt.xlsx");
        $writer->save('php://output');  
    }

    public function analisArenda() {
        $datas = \R::getAll("SELECT obcal.name as rues, o.`object_name`, c.`equip_address`, c.`landlord`, c.`contract_num`, c.`contract_start`, c.`contract_end`, c.`landlord_area`,  c.`byn` FROM `contracts` c LEFT JOIN `object_contracts` oc ON (c.`id_contract` = oc.`id_contract`) LEFT JOIN `object` o ON (oc.`id_object` = o.`id_object`) LEFT JOIN `object_code_adm_list` obcal ON (o.code_adm = obcal.code_adm) WHERE oc.id_object IS NOT NULL");

        // print_r($datas);
        $spreadsheet = new Spreadsheet();
        
        // Подключение к активной таблице
        $sheet = $spreadsheet->getActiveSheet();

        // Объединяем ячейки от A1:F1
        $sheet->mergeCells('A1:I1');

        // Устанавливаем значение ячейке A1
        $sheet->setCellValue('A1', 'Арендуемые объекты');

        // Установка значений в шапку таблицы
        $sheet->setCellValue('A2', 'УЭС, ЗУЭС');
        $sheet->setCellValue('B2', 'Наименование объекта');
        $sheet->setCellValue('C2', "Адрес объекта аренды");
        $sheet->setCellValue('D2', "Арендодатель");
        $sheet->setCellValue('E2', 'Номер договора');
        $sheet->setCellValue('F2', 'Дата начала действия договора');
        $sheet->setCellValue('G2', 'Дата окончания действия договора');
        $sheet->setCellValue('H2', 'Площадь (кв.м.)');
        $sheet->setCellValue('I2', 'Арендная плата (руб.)');

        $i = 3;

        foreach($datas as $key => $data) {
            $sheet->setCellValue('A'.$i, $data['rues']);
            $sheet->setCellValue('B'.$i, $data['object_name']);
            $sheet->setCellValue('C'.$i, $data['equip_address']);
            $sheet->setCellValue('D'.$i, $data['landlord']);
            $sheet->setCellValue('E'.$i, $data['contract_num']);
            $sheet->setCellValue('F'.$i, $data['contract_start']);
            $sheet->setCellValue('G'.$i, $data['contract_end']);
            $sheet->setCellValue('H'.$i, $data['landlord_area']);
            $sheet->setCellValue('I'.$i, $data['byn']);
            $i++;
        }

        // получение текущей даты, будет использоваться в имени файла
        $dt = date('Ymd');

        // создание объекта Xlsx
        $writer = new Xlsx($spreadsheet);
        // отправка файла в браузер
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=analis_arenda_$dt.xlsx");
        $writer->save('php://output');
    }
}