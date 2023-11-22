<?php

use App\Services\Page;
use App\Services\Router;
if(!$_SESSION['user']) {
    Router::redirect('/');
}
require_once('vendor/db.php');
$query = mysqli_query($db, "SELECT c.`id_contract`, c.`landlord`, c.`unp`, c.`landlord_address`, c.`object`, c.`equip_address`, c.`contract_num`, c.`contract_start`, c.`contract_end`, c.`landlord_area`, c.`wall`, c.`length`, c.`bav`, c.`byn`, c.`nds`, c.`pay_attribute`, c.`pay_date`, c.`comments`, c.`area`, c.`part`, oc.`id_object`, o.`object_name`, o.`code_adm` FROM `contracts` c LEFT JOIN `object_contracts` oc ON (c.`id_contract` = oc.`id_contract`) LEFT JOIN `object` o ON (oc.`id_object` = o.`id_object`)");
$datas = [];
while($row = mysqli_fetch_assoc($query)) {
    $datas[] = $row;
}
mysqli_close($db);
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
    table > tbody > tr > td {
        font-size: small;
    }
</style>

<body>
    <?php Page::part('navbar'); ?>
    <table class="table table-striped">
        <thead>
                <tr>
                    <th rowspan="2" class="align-middle">Принадлежность к объекту</th>
                    <th rowspan="2" class="align-middle">
                        <form class="d-flex" action="./search" method="get" role="search">
                            <input class="form-control me-2" name="landlord" type="search" placeholder="Арендодатель (поиск)" aria-label="Search">
                        </form>
                    </th>
                    <th rowspan="2" class="align-middle">УНП</th>
                    <th rowspan="2" class="align-middle">Контакты арендадателя</th>
                    <th rowspan="2" class="align-middle">Объект</th>
                    <th rowspan="2" class="align-middle">
                        <form class="d-flex" action="./search" method="get" role="search">
                            <input class="form-control me-2" name="address" type="search" placeholder="Адрес аренды (поиск)" aria-label="Search">
                        </form>
                    </th>
                    <th rowspan="2" class="align-middle">№ договора</th>
                    <th colspan="2">Дата</th>
                    <th rowspan="2" class="align-middle">
                        <a class="btn btn-primary me-2" title="Добавить договор" href="/arendaadd">&#10010</a>
                    </th>
                    <th rowspan="2" class="align-middle">
                        <button type="button" title="Фильтр" class="btn btn-outline-primary ms-3" data-bs-toggle="modal" data-bs-target="#filter">&#128269</button>
                    </th>
                </tr>
                <tr>
                    <th>заключения</th>
                    <th>окончания</th>
                </tr>
        </thead> 
        <tbody>
            <?php
                foreach ($datas as $key => $data) {
                    # code...
                    ?>
                        <tr>
                            <td class="align-middle text-center"><?= $data["object_name"] ?></td>
                            <td class="align-middle"><?= $data["landlord"] ?></td>
                            <td class="align-middle fw-bold"><?= $data["unp"] ?></td>
                            <td class="align-middle"><?= $data["landlord_address"] ?></td>
                            <td class="align-middle text-center"><?= $data["object"] ?></td>
                            <td class="align-middle text-center"><?= $data["equip_address"] ?></td>
                            <td class="align-middle text-center"><?= $data["contract_num"] ?></td>
                            <td class="align-middle text-center"><?= $data["contract_start"] ?></td>
                            <td class="align-middle text-center"><?= $data["contract_end"] ?></td>
                            <td class="align-middle text-center" colspan="2">
                                <a class="btn btn-outline-success" title="Подробнее" href="./arenda?idc=<?=$data['id_contract']?>&ido=<?=$data['id_object']?>&cda=<?=$data['code_adm']?>">&#9997</a>
                            </td>
                        </tr>
                    <?php
                }
            ?>
        </tbody>
        <tfoot id="footer" class="sticky-bottom bg-success-subtle">
            <tr>
                <td class="text-center" colspan="11"><?=count($datas)?> договоров аренды</td>
            </tr>
        </tfoot>
    </table>
    <?php
        include('views/modal/modalForNavbar.php');
        include('views/modal/modalForContracts.php');
    ?>
</body>

</html>