<script type="text/javascript">
    let arr = [];
</script>
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
        $dateFrom = isset($_POST['monthFrom']) ? $_POST['monthFrom'] : $_POST['monthTo'];
        $dateTo = isset($_POST['monthTo']) ? $_POST['monthTo'] : $_POST['monthFrom'];
        $dateFrom = explode('-', $dateFrom);
        $dateTo = explode('-', $dateTo);

        if(!$_POST['monthFrom']) {
            $dateFrom = $dateTo;
        }elseif(!$_POST['monthTo']){
            $dateTo = $dateFrom;
        }


        $sort = $_POST['sort'];

        if($sort == 'u') {
            $sortArr = 'u';
            $sort = 'obj.object_name';
        }elseif($sort == 'ud') {
            $sortArr = 'ud';
            $sort = 'obj.object_name desc';
        }

        $years = ($dateTo[0] - $dateFrom[0]) + 1;
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
        $month = [];
        $monthForTable = [];
        $tables = "";
        $rows = "";        
        $temp = "";

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
        $last_day = $dateTo[0]."-".$dateTo[1]."-01";
        $query = mysqli_query($db,"SELECT DISTINCT obj.id_object, obj.object_name, obcal.name as rues, objm.used $rows FROM `object_counter` obc LEFT JOIN `counter_type` ct ON (obc.counter_type = ct.counter_type) LEFT JOIN `object` obj ON(obj.id_object = obc.id_object) $tables LEFT JOIN `object_code_adm_list` obcal ON (obj.code_adm = obcal.code_adm) LEFT JOIN `object_mount` objm ON (objm.id_object = obj.id_object) WHERE obj.object_name like '%$object_name%' AND obj.code_adm like '%$code_adm%' AND ct.counter_type = 1  group by 1,2,3,4 order by $sort");
        $queryData = [];
        while($row = mysqli_fetch_assoc($query)) {
            $queryData[] = $row;
        }

        $datas = [];

        foreach($queryData as $key => $data) {
            if(is_null($data['used']) || $data['used'] == 0) {
                continue;
            }else{
                $datas[] = $data;                  
            }
        }
        
        $arr = [];

        for($i = 0; $i < count($datas); $i++) {
            $count = 0;
            $temp = 0;
            for($j = 0; $j < count($month) - 1; $j++) {
                if(!is_null($datas[$i]['cnt'.$j]) || $datas[$i]['cnt'.$j] != 0) {
                    $temp += $datas[$i]['cnt'.$j];
                    $count++;
                }
            }
            if($temp <= 1 || is_null($temp)) {
                continue;
            }
            $temp = $temp/$count;
            $arr[$i] = ['rues' => $datas[$i]['rues'], 'object_name' => $datas[$i]['object_name'], 'used' => $datas[$i]['used'], 'usedKvt' => $temp/$datas[$i]['used'], 'udel' => ($temp/$datas[$i]['used']*1000)/(24*cal_days_in_month(CAL_GREGORIAN, $dateTo[1], $dateTo[0]))];
            for($j = 0; $j < count($month) - 1; $j++) {
                $arr[$i]['cnt'.$j] = $datas[$i]["cnt".$j];
            }
        }

        if(isset($sortArr)) {
            switch($sortArr) {
                case 'u':
                    usort($arr, function($a, $b) {
                        return ($a['udel'] - $b['udel']);
                    });
                    break;
                case 'ud':
                    usort($arr, function($a, $b) {
                        return $b['udel'] - $a['udel'];
                    });
                    break;
            }
        }   

    } elseif($_POST['choice'] == 2) {
        require('vendor/db.php'); 
        if($_POST['code_adm'] == 0) {
            $code_adm = '';
        } else {
            $code_adm = $_POST['code_adm'];
        }

        $object_name = $_POST['object_name'];
        $dateFrom = isset($_POST['monthFrom']) ? $_POST['monthFrom'] : $_POST['monthTo'];
        $dateTo = isset($_POST['monthTo']) ? $_POST['monthTo'] : $_POST['monthFrom'];
        $dateFrom = explode('-', $dateFrom);
        $dateTo = explode('-', $dateTo);

        if(!$_POST['monthFrom']) {
            $dateFrom = $dateTo;
        }elseif(!$_POST['monthTo']){
            $dateTo = $dateFrom;
        }


        $sort = $_POST['sort'];

        if($sort == 'u') {
            $sortArr = 'u';
            $sort = 'obj.object_name';
        }elseif($sort == 'ud') {
            $sortArr = 'ud';
            $sort = 'obj.object_name desc';
        }

        $years = ($dateTo[0] - $dateFrom[0]) + 1;
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
        $temp = "";

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
        $query = mysqli_query($db, "SELECT DISTINCT obj.id_object, obj.object_name, obcal.name as rues $rows FROM `object_counter` obc LEFT JOIN `counter_type` ct ON (obc.counter_type = ct.counter_type) LEFT JOIN `object` obj ON(obj.id_object = obc.id_object) $tables LEFT JOIN `object_code_adm_list` obcal ON (obj.code_adm = obcal.code_adm) LEFT JOIN `object_mount` objm ON (objm.id_object = obj.id_object) WHERE obj.object_name like '%$object_name%' AND obj.code_adm like '%$code_adm%' AND ct.counter_type = 1 group by 1,2,3 order by $sort");        

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
            $proc = 0;

            for($j = 0; $j < count($monthArenda) - 1; $j++) {
                if($arr[$i]['arn'.$j] > 0) {
                    $count++;
                    $proc = $arr[$i]['proc'.$j];
                }
            }
            
            if($count > 0) {
                $arr[$i]['proc'] = $proc;
                $datas[] = $arr[$i];
            }
        }

        if(isset($sortArr)) {
            switch($sortArr) {
                case 'u':
                    usort($datas, function($a, $b) {
                        return ($a['proc'] - $b['proc']);
                    });
                    break;
                case 'ud':
                    usort($datas, function($a, $b) {
                        return $b['proc'] - $a['proc'];
                    });
                    break;
            }
        } 

    } elseif($_POST['choice'] == 3) {
        require('vendor/db.php');
        $sort = $_POST['sort'];
        $query = mysqli_query($db, "SELECT obcal.name as rues, o.`object_name`, c.`equip_address`, c.`landlord`, c.`contract_num`, c.`contract_start`, c.`contract_end`, c.`landlord_area`,  c.`byn` FROM `contracts` c LEFT JOIN `object_contracts` oc ON (c.`id_contract` = oc.`id_contract`) LEFT JOIN `object` o ON (oc.`id_object` = o.`id_object`) LEFT JOIN `object_code_adm_list` obcal ON (o.code_adm = obcal.code_adm) WHERE oc.id_object IS NOT NULL order by $sort");

        $datas = [];
        while($row = mysqli_fetch_assoc($query)) {
            $datas[] = $row;
        }
    } elseif($_POST['choice'] == 4) {
        require('vendor/db.php');
        if($_POST['code_adm'] == 0) {
            $code_adm = '';
        } else {
            $code_adm = $_POST['code_adm'];
        }
        $object_name = $_POST['object_name'];
        $dateFrom = $_POST['monthFrom'];
        $dateTo = $_POST['monthTo'];

        $dateFrom = explode('-', $dateFrom);
        $dateTo = explode('-', $dateTo);

        if(!$_POST['monthFrom']) {
            $dateFrom = $dateTo;
        }elseif(!$_POST['monthTo']){
            $dateTo = $dateFrom;
        }
        $sort = $_POST['sort'];

        if($sort == 'u') {
            $sortArr = 'u';
            $sort = 'obj.object_name';
        }elseif($sort == 'ud') {
            $sortArr = 'ud';
            $sort = 'obj.object_name desc';
        }

        $years = $dateTo[0] - $dateFrom[0];
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
        
        $query = mysqli_query($db,"SELECT DISTINCT obj.id_object, obj.object_name, obj.area, obcal.name as rues, oc.id_object as arenda $rows FROM `object_counter` obc LEFT JOIN `counter_type` ct ON (obc.counter_type = ct.counter_type) LEFT JOIN `object` obj ON(obj.id_object = obc.id_object) $tables LEFT JOIN `object_code_adm_list` obcal ON (obj.code_adm = obcal.code_adm) LEFT JOIN `object_contracts` oc ON (obj.id_object = oc.id_object) WHERE obj.object_name like '%$object_name%' AND obj.code_adm like '%$code_adm%' AND ct.counter_type = 2  group by 1,2,3,4,5 order by $sort");

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

        $arr = [];

        for($i = 0; $i < count($datas); $i++) {
            $count = 0;
            $temp = 0;
            for($j = 0; $j < count($month) - 1; $j++) {
                if(!is_null($datas[$i]['cnt'.$j]) || $datas[$i]['cnt'.$j] != 0) {
                    $temp += $datas[$i]['cnt'.$j];
                    $count++;
                }
            }
            if($temp <= 1 || is_null($temp)) {
                continue;
            }
            $temp = $temp/$count;
            $temp = $temp/$count;
            $arr[$i] = ['rues' => $datas[$i]['rues'], 'object_name' => $datas[$i]['object_name'], 'arendaObj' => $datas[$i]['arenda'], 'areaObj' => $datas[$i]['area'], 'udel' => $temp/$datas[$i]['area']];
            for($j = 0; $j < count($month) - 1; $j++) {
                $arr[$i]['cnt'.$j] = $datas[$i]["cnt".$j];
            }        
        }

        if(isset($sortArr)) {
            switch($sortArr) {
                case 'u':
                    usort($arr, function($a, $b) {
                        return ($a['udel'] - $b['udel']);
                    });
                    break;
                case 'ud':
                    usort($arr, function($a, $b) {
                        return $b['udel'] - $a['udel'];
                    });
                    break;
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<?php Page::part('head'); ?>
<style>
    .analis-name {
        margin-bottom: 0;
        background-color: #E3E3E3;
    }
    .shadow_not_news {
        display: none;
    }
    #rues_sort:hover,
    #object_name_sort:hover,
    #counter:hover,
    #udel:hover,
    #arenda:hover,
    #div:hover,
    #proc:hover,
    #used:hover,
    #usedKvt:hover {
        cursor: pointer;
        color: green;
    }
    .excel-btn {
        margin-top: .5rem;
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
        }elseif($_POST['choice']==4) {
            require_once("views/components/analysis/choiceFour.php");
        }
        mysqli_close($db);
    ?>    
</body>
<script type="text/javascript">
    // Порядок сортировки
    let ordASC = 1;
    // Сортируемое поле
    let ordField = '';

    /**
     * Функция возвращает полное имя 
     * */
    function getRues(object) {
        return object.rues;
    }
    function getFullName(object) {
        return object.object_name;
    }

    /**
     * Функции сортировки для таблицы
     */
    function sorterRues(a, b) {
        return getRues(a).localeCompare(getRues(b)) * ordASC;
    }
    function sorterName(a, b) {
        return getFullName(a).localeCompare(getFullName(b)) * ordASC;
    }

    /**
     * Функция сортировки для таблицы
     */
    function sortString(a, b) {
        return (b[this.orderBy] - a[this.orderBy]) * ordASC;
    }

    function selectOrd(id) {
        if (id === ordField) {
            ordASC *= -1;
        } else {
            ordField = id;
            ordASC = 1;
        }
    }

    function order(e) {
        if (e.target && e.target.id) {
            switch (e.target.id) {
                case 'rues_sort':
                    selectOrd(e.target.id);
                    arr = arr.sort(sorterRues);               
                    break;
                case 'object_name_sort':
                    selectOrd(e.target.id);
                    arr = arr.sort(sorterName);                  
                    break;
                default:
                    selectOrd(e.target.id);
                    const sortBnd = sortString.bind({orderBy: e.target.id});
                    arr = arr.sort(sortBnd);                   
            }
            buildTable(arr);
        }
    }

    const header = document.getElementsByTagName('th');
    for (let i = 0; i < header.length; i++) {
        header[i].addEventListener('click', order);
    }
</script>
</html>

