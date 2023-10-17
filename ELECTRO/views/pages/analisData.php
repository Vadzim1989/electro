<?php
    use App\Services\Page;
    use App\Services\Router;
    if(!$_SESSION['user']) {
        Router::redirect('/');
    }
    if($_POST['choice'] == 1) {
        require('vendor/db.php');
        if($_POST['code_adm'] == 0) {
            $code_adm = '';
        } else {
            $code_adm = $_POST['code_adm'];
        }
        $object_name = $_POST['object_name'];
        $dateFrom = $_POST['dateFrom'];
        $dateFrom = explode("-", $dateFrom);
        $dateTo = $_POST['dateTo'];
        $dateTo = explode("-", $dateTo);
       
        $monthData = [
            'counter_01'.$dateFrom[0],
            'counter_02'.$dateFrom[0],
            'counter_03'.$dateFrom[0],
            'counter_04'.$dateFrom[0],
            'counter_05'.$dateFrom[0],
            'counter_06'.$dateFrom[0],
            'counter_07'.$dateFrom[0],
            'counter_08'.$dateFrom[0],
            'counter_09'.$dateFrom[0],
            'counter_10'.$dateFrom[0],
            'counter_11'.$dateFrom[0],
            'counter_12'.$dateFrom[0]
        ];

        $indexF = array_search("counter_".$dateFrom[1].$dateFrom[0], $monthData);
        $indexT = array_search("counter_".$dateTo[1].$dateTo[0], $monthData);

        if($dateTo[0]>$dateFrom[0]) {
            $nextYear = [
                'counter_01'.$dateTo[0],
                'counter_02'.$dateTo[0],
                'counter_03'.$dateTo[0],
                'counter_04'.$dateTo[0],
                'counter_05'.$dateTo[0],
                'counter_06'.$dateTo[0],
                'counter_07'.$dateTo[0],
                'counter_08'.$dateTo[0],
                'counter_09'.$dateTo[0],
                'counter_10'.$dateTo[0],
                'counter_11'.$dateTo[0],
                'counter_12'.$dateTo[0]
            ];
            $indexT = array_search("counter_".$dateTo[1].$dateTo[0], $nextYear);
        }


        $values = ' ';
        $tables = ' ';

        if($dateTo[0]==$dateFrom[0]) {
            for($i = $indexF; $i <= $indexT + 1; $i++) {
                if($i==12) {
                    $values .= ",cnt".$i.".value as cnt".$i."value";
                    $tables .= "LEFT JOIN `counter_01".($dateTo[0]+1)." as cnt".$i." ON (cnt".$i.".id_counter = obc.id_counter) ";
                    break;
                }
                $values .= ",cnt".$i.".value as cnt".$i."value";
                $tables .= "LEFT JOIN `".$monthData[$i]."` as cnt".$i." ON (cnt".$i.".id_counter = obc.id_counter) ";                
            };
        }elseif($dateTo[0]>$dateFrom[0]) {
            for($i = $indexF; $i < 12; $i++) {
                $values .= ",cnt".$i.".value as cnt".$i."value";
                $tables .= "LEFT JOIN `".$monthData[$i]."` as cnt".$i." ON (cnt".$i.".id_counter = obc.id_counter) ";                
            };
            for($i = 0; $i <= $indexT + 1; $i++) {
                if($i==12) {
                    $values .= ",cnt".$i.".value as cnt".$i."value";
                    $tables .= "LEFT JOIN `counter_01".($dateTo[0]+1)." as cnt".$i." ON (cnt".$i.".id_counter = obc.id_counter) ";
                    break;
                }
                $values .= ",cnt".$i.".value as cnt".$i."value";
                $tables .= "LEFT JOIN `".$nextYear[$i]."` as cnt".$i." ON (cnt".$i.".id_counter = obc.id_counter) ";
            }
        }
        
        $query = mysqli_query($db,"SELECT DISTINCT obj.id_object, obj.object_name, obcal.name as rues, objm.used, ct.name".$values." FROM `object_counter` obc LEFT JOIN `counter_type` ct ON (obc.counter_type = ct.counter_type) LEFT JOIN `object` obj ON(obj.id_object = obc.id_object) ".$tables." LEFT JOIN `object_code_adm_list` obcal ON (obj.code_adm = obcal.code_adm) LEFT JOIN `object_mount` objm ON (objm.id_object = obj.id_object) WHERE obj.object_name like '%$object_name%' AND obj.code_adm like '%$code_adm%' AND ct.counter_type = 1");

        $datas = [];
        while($row = mysqli_fetch_assoc($query)) {
            $datas[] = $row;
        }
        

    } elseif($_POST['choice'] == 2) {
        require('vendor/db.php'); 
        if($_POST['code_adm'] == 0) {
            $code_adm = '';
        } else {
            $code_adm = $_POST['code_adm'];
        }
        $object_name = $_POST['object_name'];
        $date = $_POST['date'];
        $date = explode("-", $date);

        $monthData = [
            'counter_01'.$date[0],
            'counter_02'.$date[0],
            'counter_03'.$date[0],
            'counter_04'.$date[0],
            'counter_05'.$date[0],
            'counter_06'.$date[0],
            'counter_07'.$date[0],
            'counter_08'.$date[0],
            'counter_09'.$date[0],
            'counter_10'.$date[0],
            'counter_11'.$date[0],
            'counter_12'.$date[0]
        ];

        $indexF = array_search("counter_".$date[1].$date[0], $monthData);

        $month = [];
        for($i = $indexF; $i <= $indexF + 1; $i++) {
            if($i==12) {
                $month[] = 'counter_01'.($date[0]+1);
            } else {
                $month[] = $monthData[$i];
            }
        }

        $monthFrom = $month[0];
        $monthTo =$month[1];
        $monthArenda = "arenda_".$date[1].$date[0];

        $queryData = mysqli_query($db, "SELECT DISTINCT obj.id_object, obj.object_name, obcal.name as rues, (sum(cnt2.value) - sum(cnt1.value)) AS value_cnt, arnd1.value as arenda FROM `object_counter` obc LEFT JOIN `counter_type` ct ON (obc.counter_type = ct.counter_type) LEFT JOIN `object` obj ON(obj.id_object = obc.id_object) LEFT JOIN `$monthFrom` cnt1 ON (cnt1.id_counter = obc.id_counter) LEFT JOIN `$monthTo` cnt2 ON (cnt2.id_counter = obc.id_counter) LEFT JOIN `object_counter_arenda` oba ON (oba.id_object = obj.id_object) LEFT JOIN `$monthArenda` arnd1 ON (arnd1.id_counter = oba.id_counter)  LEFT JOIN `object_code_adm_list` obcal ON (obj.code_adm = obcal.code_adm) LEFT JOIN `object_mount` objm ON (objm.id_object = obj.id_object) WHERE obj.object_name like '%$object_name%' AND obj.code_adm like '%$code_adm%' AND oba.counter_type = 1 AND ct.counter_type = 1 group by 1,2,3,5");

        $query = [];
        while($row = mysqli_fetch_assoc($queryData)) {
            $query[] = $row;
        }

        $datas = [];
        for($i=0; $i<count($query);$i++){
            if($query[$i]['value_cnt'] > $query[$i]['arenda'] || $query[$i]['value_cnt'] < $query[$i]['arenda']) {
                $datas[] = $query[$i];
            }
        }
    } elseif($_POST['choice'] == 3) {
        require('vendor/db.php');
        $query = mysqli_query($db, "SELECT obcal.name as rues, o.`object_name`, c.`equip_address`, c.`landlord`, c.`contract_num`, c.`contract_start`, c.`contract_end`, c.`landlord_area`,  c.`byn` FROM `contracts` c LEFT JOIN `object_contracts` oc ON (c.`id_contract` = oc.`id_contract`) LEFT JOIN `object` o ON (oc.`id_object` = o.`id_object`) LEFT JOIN `object_code_adm_list` obcal ON (o.code_adm = obcal.code_adm) WHERE oc.id_object IS NOT NULL");

        $datas = [];
        while($row = mysqli_fetch_assoc($query)) {
            $datas[] = $row;
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<?php Page::part('head'); ?>


<style>
    table > thead > tr > th,
    table > tbody > tr > td {
        font-size: small;
        text-align: center;
    }
    .device-table {
        max-width: 100rem;
        margin: auto;
    }
</style>

<body>
    <?php 
        Page::part('navbar'); 
        if($_POST['choice']==1) {
            require_once("views/components/analysis/choiceOne.php");
        }elseif($_POST['choice']==2) {
            require_once("views/components/analysis/choiceTwo.php");
        }elseif($_POST['choice']==3) {
            require_once("views/components/analysis/choiceThree.php");
        }
    ?>    
</body>
</html>