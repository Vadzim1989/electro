<?php

use App\Services\Page;
use App\Services\Router;
if(!$_SESSION['user']) {
    Router::redirect('/');
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
    table > tbody > tr > td {
        font-size: small;
    }
    a {
        margin-left: 1.5rem;
    }
</style>

<body>
    <?php Page::part('navbar'); ?>
    <table class="table table-striped">
        <thead>
                <tr>
                    <th>Принадлежность к объекту</th>
                    <th>Арендадатель</th>
                    <th>УНП</th>
                    <th>Контакты арендадателя</th>
                    <th>Объект</th>
                    <th>Арендуемая площадь</th>
                    <th>№ договора</th>
                    <th>Дата заключения</th>
                    <th>Дата окончания</th>
                    <th><a class="btn btn-primary me-2" title="Добавить договор" href="/ELECTRO/arendaadd">&#10010</a></th>
                    <th><button type="button" title="Фильтр" class="btn btn-outline-primary ms-3" data-bs-toggle="modal" data-bs-target="#filter">&#128269</button></th>
                </tr>
        </thead> 
        <tbody>
            <?php
                $datas = \R::getAll("SELECT c.`id_contract`, c.`landlord`, c.`unp`, c.`landlord_address`, c.`object`, c.`equip_address`, c.`contract_num`, c.`contract_start`, c.`contract_end`, c.`landlord_area`, c.`wall`, c.`length`, c.`bav`, c.`byn`, c.`nds`, c.`pay_attribute`, c.`pay_date`, c.`comments`, c.`area`, c.`part`, oc.`id_object`, o.`object_name`, o.`code_adm` FROM `contracts` c LEFT JOIN `object_contracts` oc ON (c.`id_contract` = oc.`id_contract`) LEFT JOIN `object` o ON (oc.`id_object` = o.`id_object`)");
                foreach ($datas as $key => $data) {
                    # code...
                    ?>
                        <tr>
                            <td class="align-middle"><?= $data["object_name"] ?></td>
                            <td class="align-middle"><?= $data["landlord"] ?></td>
                            <td class="align-middle"><?= $data["unp"] ?></td>
                            <td class="align-middle"><?= $data["landlord_address"] ?></td>
                            <td class="align-middle"><?= $data["object"] ?></td>
                            <td class="align-middle"><?= $data["equip_address"] ?></td>
                            <td class="align-middle"><?= $data["contract_num"] ?></td>
                            <td class="align-middle"><?= $data["contract_start"] ?></td>
                            <td class="align-middle"><?= $data["contract_end"] ?></td>
                            <td class="align-middle" colspan="2">
                                <a class="btn btn-outline-success" title="Подробнее" href="/ELECTRO/arenda?idc=<?=$data['id_contract']?>&ido=<?=$data['id_object']?>&cda=<?=$data['code_adm']?>">&#9997</a>
                            </td>
                        </tr>
                    <?php
                    sleep(0.6);
                }
            ?>
        </tbody>
        <tfoot class="sticky-bottom bg-success-subtle">
            <tr>
                <td class="text-center" colspan="11"><?=count($datas)?> договоров аренды</td>
            </tr>
        </tfoot>
    </table>

    <?php Page::part('contractModal'); ?>
</body>



</html>