<?php
use App\Services\Page;

require_once('vendor/db.php');

$query = mysqli_query($db, "SELECT DISTINCT `object`.`id_object`, `object`.remark, `object`.`object_name`, oa.`address`, `object`.`code_adm`, ocal.`name` as rues, om.`mount`, om.`used`, op.`object_power`, obcnt.`id_object` AS `cnt`, odev.id_object as devices  FROM `object` LEFT JOIN `object_code_adm_list` ocal ON (ocal.code_adm = `object`.code_adm) LEFT JOIN `object_mount` om ON (om.id_object = `object`.id_object) LEFT JOIN `object_address` oa ON (oa.id_object = `object`.id_object) LEFT JOIN `object_power` op ON (op.id_object = `object`.id_object) LEFT JOIN `object_contracts` ocont ON (ocont.id_object = `object`.id_object) LEFT JOIN `contracts` c ON (c.id_contract = ocont.id_contract) LEFT JOIN `object_counter` obcnt ON (`object`.`id_object` = obcnt.id_object) LEFT JOIN `object_devices` odev ON (`object`.`id_object` = odev.id_object) ORDER BY `object`.`id_object`");

$datas = [];
while($row = mysqli_fetch_assoc($query)) {
    $datas[] = $row;
}

$usedPower = 0;
$usedForce = 0;

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
    .object_name {
        text-align: left;
    }
    a {
        text-decoration: none;
    }
    .developer {
        font-size: small;
    }
</style>

<body>
    <?php Page::part('navbar'); ?>
    
    <?php 
    if (isset($_SESSION['user'])) 
    {
        include("views/components/table.php");
    } 
    else 
    { ?>
        <div class="container mt-4 text-center text-wrap">
            <h1>Автоматизированная система учета потребления тепло- и электроэнергии</h1>
            <br>
            <p>Для пользования данным приложением Вам необходимо авторизироваться.</p>
            <p>Для этого пройдите по ссылке <a href="/login"><i><u>"Войти"</u></i></a> и введите реквизиты доступа.</p>
            <p>В случае отсутствия реквизитов, обратитесь к администратору для предоставления прав доступа.</p>
            <br><br><br>
        </div>
        <div class="container mt-4 text-end developer">
            <p><i>инженер-программист Денисовский В.В.</i></p>
        </div>
    <?php 
    } 
    ?>    
    <?php 
        include("views/modal/modalForObject.php"); 
        include('views/modal/modalForNavbar.php');
        mysqli_close($db);
    ?>
</body>
                            

</html>