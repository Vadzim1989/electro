<table class="table table-striped">
        <thead>
                <tr>
                    <th rowspan="2" class="align-middle">
                        <form action="./excel/filterArenda" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="sort" value="<?=$sort?>">
                            <input type="hidden" name="data" value="<?=$choice?>">
                            <input type="hidden" name="contract" value="<?=$num?>">
                            <input type="hidden" name="area" value="<?=$area?>">
                            <input type="hidden" name="address" value="<?=$address?>">
                            <input type="hidden" name="code_adm" value="<?=$code_adm?>">
                            <button title="Excel" class="btn" type="submit">&#128196</button>
                        </form>    
                        Район
                    </th>
                    <th rowspan="2" class="align-middle">Принадлежность к объекту</th>
                    <th rowspan="2" class="align-middle">
                        <form class="d-flex" action="/search" method="post" role="search">
                            <input class="form-control me-2" name="landlord" type="search" placeholder="Арендодатель (поиск)" aria-label="Search">
                        </form>
                    </th>
                    <th rowspan="2" class="align-middle">УНП</th>
                    <th rowspan="2" class="align-middle">Контакты арендадателя</th>
                    <th rowspan="2" class="align-middle">Объект</th>
                    <th rowspan="2" class="align-middle">
                        <form class="d-flex" action="/search" method="post" role="search">
                            <input class="form-control me-2" name="address" type="search" placeholder="Адрес аренды (поиск)" aria-label="Search">
                        </form>
                    </th>
                    <th rowspan="2" class="align-middle">№ договора</th>
                    <th colspan="2">Дата</th>
                    <th rowspan="2" class="align-middle">
                        <a class="btn btn-primary me-2" title="Добавить договор" href="/arendaadd">&#10010</a>
                    </th>
                    <th rowspan="2" class="align-middle"><a class="btn btn-outline-primary" title="Сбросить фильтр" href="/contracts">&#10006</a></th>
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
                            <td class="align-middle text-center" colspan="2">
                                <a class="btn btn-outline-success" title="Подробнее" href="/arenda?idc=<?=$data['id_contract']?>&ido=<?=$data['id_object']?>&cda=<?=$data['code_adm']?>&code=<?=$data['code']?>">&#9997</a>
                            </td>
                        </tr>
                    <?php
                }
            ?>
        </tbody>
        <tfoot class="sticky-bottom bg-success-subtle" style="z-index: -1;">
            <tr>
                <td class="text-center" colspan="12"><?=count($datas)?> договоров аренды</td>
            </tr>
        </tfoot>
    </table>