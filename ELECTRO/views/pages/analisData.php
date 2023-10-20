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
        $date = $_POST['date'];
        $date = explode("-", $date);
        $sort = $_POST['sort'];
       
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
        for($i = $indexF - 1; $i <= $indexF; $i++) {
            if($i==12) {
                $month[] = 'counter_01'.($date[0]+1);
            } else {
                $month[] = $monthData[$i];
            }
        }

        $monthFrom = $month[0];
        $monthTo =$month[1];
        $last_day = $date[0]."-".$date[1]."-01";
        
        $query = mysqli_query($db,"SELECT DISTINCT obj.id_object, obj.object_name, obc.transform, obcal.name as rues, objm.used, (SUM(cnt2.value) - sum(cnt1.value))*obc.transform AS value_cnt, ((sum(cnt2.value) - sum(cnt1.value))/used) AS usedkvt, (((sum(cnt2.value) - sum(cnt1.value))/used)*1000/(24*DAY(LAST_DAY('$last_day')))) AS udel FROM `object_counter` obc LEFT JOIN `counter_type` ct ON (obc.counter_type = ct.counter_type) LEFT JOIN `object` obj ON(obj.id_object = obc.id_object) LEFT JOIN `$month[0]` cnt1 ON (cnt1.id_counter = obc.id_counter) LEFT JOIN `$month[1]` cnt2 ON (cnt2.id_counter = obc.id_counter) LEFT JOIN `object_code_adm_list` obcal ON (obj.code_adm = obcal.code_adm) LEFT JOIN `object_mount` objm ON (objm.id_object = obj.id_object) WHERE obj.object_name like '%$object_name%' AND obj.code_adm like '%$code_adm%' AND ct.counter_type = 1  group by 1,2,3,4,5 order by $sort");

        $queryData = [];
        while($row = mysqli_fetch_assoc($query)) {
            $queryData[] = $row;
        }

        $datas = [];
        foreach($queryData as $data) {
            if(is_null($data['value_cnt']) || $data['value_cnt'] == 0) {
                continue;
            }else{
                $datas[] = $data;
            }
        }

        foreach($datas as $key => $data) {
            if(is_null($data['udel']) || $data['udel'] == 0) {
                continue;
            }
            $arr = array('rues' => $data['rues'], 'object_name' => $data['object_name'], 'counter' => $data['value_cnt'], 'used' => $data['used'], 'usedKvt' => round($data['usedkvt'],3), 'udel' => round($data['udel'],3));
            ?>
                <script type="text/javascript">
                    arr.push(<?=json_encode($arr);?>)
                </script>
            <?php
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
        $sort = $_POST['sort'];

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
        for($i = $indexF - 1; $i <= $indexF; $i++) {
            if($i==12) {
                $month[] = 'counter_01'.($date[0]+1);
            } else {
                $month[] = $monthData[$i];
            }
        }

        $monthFrom = $month[0];
        $monthTo =$month[1];
        $monthArenda = "arenda_".$date[1].$date[0];

        $queryData = mysqli_query($db, "SELECT DISTINCT obj.id_object, obc.transform, obj.object_name, obcal.name as rues, (sum(cnt2.value) - sum(cnt1.value))*obc.transform AS value_cnt FROM `object_counter` obc LEFT JOIN `counter_type` ct ON (obc.counter_type = ct.counter_type) LEFT JOIN `object` obj ON(obj.id_object = obc.id_object) LEFT JOIN `$monthFrom` cnt1 ON (cnt1.id_counter = obc.id_counter) LEFT JOIN `$monthTo` cnt2 ON (cnt2.id_counter = obc.id_counter) LEFT JOIN `object_code_adm_list` obcal ON (obj.code_adm = obcal.code_adm) LEFT JOIN `object_mount` objm ON (objm.id_object = obj.id_object) WHERE obj.object_name like '%$object_name%' AND obj.code_adm like '%$code_adm%' AND ct.counter_type = 1 group by 1,2,3,4 order by $sort");

        $query = [];
        while($row = mysqli_fetch_assoc($queryData)) {
            $query[] = $row;
        }

        $datas = [];
        for($i=0; $i<count($query);$i++){
            $arenda = mysqli_query($db,"SELECT SUM(VALUE) as arenda FROM `$monthArenda` WHERE `id_counter` IN (SELECT `id_counter` FROM `object_counter_arenda` WHERE `id_object` = '".$query[$i]['id_object']."' AND `counter_type` = 1)");
            $arenda = mysqli_fetch_assoc($arenda);
            $arenda = $arenda['arenda'];
            if(is_null($arenda) || $arenda == 0) {
                continue;
            }elseif($query[$i]['value_cnt'] > 0) {
                $query[$i]['arenda'] = $arenda;
                $datas[] = $query[$i];
            }
        }      

        foreach($datas as $key => $data) {
            $div = $data['value_cnt'] - $data['arenda'];
            if($div) {
                $proc = ($data['value_cnt'] - $data['arenda'])/(($data['value_cnt'] + $data['arenda'])/2)*100;
            } else {
                $proc = 0;
            }
            $arr = array('rues' => $data['rues'], 'object_name' => $data['object_name'], 'counter' => $data['value_cnt'], 'arenda' => $data['arenda'], 'div' => $div, 'proc' => abs(round($proc,2)));
            ?>
            <script type="text/javascript">
                arr.push(<?=json_encode($arr)?>);
            </script>
            <?php
        }

    } elseif($_POST['choice'] == 3) {
        require('vendor/db.php');
        $sort = $_POST['sort'];
        $query = mysqli_query($db, "SELECT obcal.name as rues, o.`object_name`, c.`equip_address`, c.`landlord`, c.`contract_num`, c.`contract_start`, c.`contract_end`, c.`landlord_area`,  c.`byn` FROM `contracts` c LEFT JOIN `object_contracts` oc ON (c.`id_contract` = oc.`id_contract`) LEFT JOIN `object` o ON (oc.`id_object` = o.`id_object`) LEFT JOIN `object_code_adm_list` obcal ON (o.code_adm = obcal.code_adm) WHERE oc.id_object IS NOT NULL order by $sort");

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

