<table class="table table-striped">
    <thead>
            <tr>
                <th rowspan="2" class="align-middle">Район</th>
                <th rowspan="2" class="align-middle">Принадлежность к объекту</th>
                <th rowspan="2" class="align-middle">
                    <form class="d-flex" action="./search" method="get" role="search">
                        <input class="form-control me-2" name="landlord" type="search" placeholder="<?php if(isset($_GET['landlord'])) echo $search?>" aria-label="Search">
                    </form>
                </th>
                <th rowspan="2" class="align-middle">УНП</th>
                <th rowspan="2" class="align-middle">Контакты арендадателя</th>
                <th rowspan="2" class="align-middle">Объект</th>
                <th rowspan="2" class="align-middle">
                    <form class="d-flex" action="./search" method="get" role="search">
                        <input class="form-control me-2" name="address" type="search" placeholder="<?php if(isset($_GET['address'])) echo $search?>" aria-label="Search">
                    </form>
                </th>
                <th rowspan="2" class="align-middle">№ договора</th>
                <th colspan="2">Дата</th>
                <th rowspan="2" class="align-middle">
                    <a class="btn btn-primary me-2" title="Добавить договор" href="/arendaadd">&#10010</a>
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
                        <td class="align-middle arenda-code-adm"><?= $data["rues"] ?></td>
                        <td class="align-middle"><?= $data["object_name"] ?></td>
                        <td class="align-middle"><?= $data["landlord"] ?></td>
                        <td class="align-middle fw-bold"><?= $data["unp"] ?></td>
                        <td class="align-middle"><?= $data["landlord_address"] ?></td>
                        <td class="align-middle text-center"><?= $data["object"] ?></td>
                        <td class="align-middle text-center"><?= $data["equip_address"] ?></td>
                        <td class="align-middle text-center"><?= $data["contract_num"] ?></td>
                        <td class="align-middle text-center"><?= $data["contract_start"] ?></td>
                        <td class="align-middle text-center"><?= $data["contract_end"] ?></td>
                        <td class="align-middle">
                            <a class="btn btn-outline-success" title="Подробнее" href="./arenda?idc=<?=$data['id_contract']?>&ido=<?=$data['id_object']?>&cda=<?=$data['code_adm']?>">&#9997</a>
                        </td>
                    </tr>
                <?php
            }
        ?>
    </tbody>
    <tfoot class="sticky-bottom bg-success-subtle" style="z-index: -1;">
    <tr>
            <td class="text-center" colspan="12"><i><?=count($datas)?> договор(ов), по запросу:</i> "<b><?=$search?></b>"</td>
        </tr>
    </tfoot>
</table>