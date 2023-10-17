<table class="table table-striped">
    <thead>
            <tr>
                <th>Арендадатель</th>
                <th>УНП</th>
                <th>Контакты арендадателя</th>
                <th>Объект</th>
                <th>Арендуемая площадь</th>
                <th>Площадь помещения</th>
                <th>№ договора</th>
                <th>Дата заключения</th>
                <th>Дата окончания</th>
                <th><a class="btn btn-primary me-2" title="Добавить договор" href="/ELECTRO/arendaadd">&#10010</a></th>
                <th><a class="btn btn-outline-primary me-2" title="Сбросить фильтр" href="/ELECTRO/contracts">&#10006</a></th>
            </tr>
    </thead> 
    <tbody>
        <?php
            foreach ($arenda as $key => $data) {
                # code...
                ?>
                    <tr>
                        <td class="align-middle"><?= $data["landlord"] ?></td>
                        <td class="align-middle"><?= $data["unp"] ?></td>
                        <td class="align-middle"><?= $data["landlord_address"] ?></td>
                        <td class="align-middle"><?= $data["object"] ?></td>
                        <td class="align-middle"><?= $data["equip_address"] ?></td>
                        <td class="align-middle"><?= $data["landlord_area"] ?></td>
                        <td class="align-middle"><?= $data["contract_num"] ?></td>
                        <td class="align-middle"><?= $data["contract_start"] ?></td>
                        <td class="align-middle"><?= $data["contract_end"] ?></td>
                        <td class="align-middle" colspan="2">
                            <a class="btn btn-outline-success" title="Подробнее" href="/ELECTRO/arenda?idc=<?=$data['id_contract']?>&ido=&cda=">&#9997</a>
                        </td>
                    </tr>
                <?php
            }
        ?>
    </tbody>
    <tfoot class="sticky-bottom bg-success-subtle">
        <tr>
            <td class="text-center" colspan="11"><?=count($arenda)?> договоров аренды</td>
        </tr>
    </tfoot>
</table>