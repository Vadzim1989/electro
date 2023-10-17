<?php
use App\Services\Page;
use App\Services\Router;
$search_name = $_POST['search'];
if(!$_SESSION['user']) {
    Router::redirect('/');
}
include('functions/getSearchByRues.php')
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
    .id_object {
        font-weight: bold;
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
    <table class="table table-striped">
        <thead>
            <tr>
                <th>№</th>
                <th>Название объекта</th>
                <th>Район</th>
                <th>Адрес</th>
                <th>Оборудование на объекте</th>
                <th>Арендодатель</th>
                <th>Монтированая емкость</th>
                <th>Задействованая емкость</th>
                <th>Расчетная мощность, кВт</th>
                <th>Расчетное потребление, кВт*ч</th>
                <th>Счетчики</th>
                <th>Правки</th>
            </tr>
        </thead> 
        <tbody>
            <?php
                $datas = getSearchByRues($_SESSION['user']['zues'], $search_name);
                foreach ($datas as $key => $data) {
                    # code...
                    ?>
                        <tr>
                            <td class="align-middle id_object"><?= $data["id_object"] ?></td>
                            <td class="align-middle object_name"><?= $data["object_name"] ?></td>
                            <td class="align-middle"><?= $data["rues"] ?></td>
                            <td class="align-middle"><?= $data["address"] ?></td>
                            <td class="align-middle text-center">
                                <?php
                                    if($data['devices']) {
                                        ?>
                                            <a class="btn btn-success" href="/ELECTRO/device?id=<?=$data['id_object']?>">&#128736</a>
                                        <?php
                                    } else {
                                        ?>
                                            <a class="btn btn-outline-secondary" href="/ELECTRO/device?id=<?=$data['id_object']?>">&#128736</a>
                                        <?php
                                    }
                                ?>                                
                            </td>
                            <td class="align-middle text-center">
                                <?php
                                    if($data['id_contract']) {
                                        ?>
                                            <a href="/ELECTRO/arenda?idc=<?=$data['id_contract']?>&ido=<?=$data['id_object']?>&cda=<?=$data['code_adm']?>"><span class='btn btn-success'>&#10003</span></a>
                                        <?php
                                    } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addArenda" id-obj="<?=$data['id_object']?>" obj-name="<?=$data['object_name']?>">&#10007</button>
                                        <?php
                                    }
                                ?>                                
                            </td>
                            <td class="align-middle"><?= $data["mount"] ?></td>
                            <td class="align-middle"><?= $data["used"] ?></td>
                            <td class="align-middle"><?= $data["object_power"] ?></td>
                            <td class="align-middle"><?= $data["object_power"] * 24 * cal_days_in_month(CAL_GREGORIAN, date('m'), date('y'))?></td>
                            <td class="align-middle">
                                <?php
                                    if($data['cnt']) {
                                        ?>
                                            <a class="btn btn-success" href="/ELECTRO/counters?id=<?=$data['id_object']?>">&#9881</a>
                                        <?php
                                    } else {
                                        ?>
                                            <a class="btn btn-outline-secondary" href="/ELECTRO/counters?id=<?=$data['id_object']?>">&#9881</a>
                                        <?php
                                    }
                                ?>
                                
                            </td>
                            <td class="align-middle"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateObject" data-bs-id="<?= $data['id_object'] ?>" data-bs-name="<?= $data['object_name'] ?>" data-bs-rues="<?= $data['rues']?>" data-bs-address="<?=$data['address']?>" data-bs-mount="<?=$data['mount']?>" data-bs-used="<?=$data['used']?>" data-bs-power="<?=$data['object_power']?>">&#9997</button></td>
                        </tr>
                    <?php
                }
            ?>
        </tbody>
        <tfoot class="sticky-bottom bg-success-subtle">
            <tr>
                <td class="text-center" colspan="12"><i><?=count($datas)?> объект(ов), по запросу:</i> "<b><?=$search_name?></b>"</td>
            </tr>
        </tfoot>
    </table>
    <?php Page::part('objectModal');  Page::part('navbarModal');?>
</body>



</html>