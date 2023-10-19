<table class="table table-striped">
        <thead>
            <tr>
                <th rowspan="2" class="align-middle">№</th>
                <th rowspan="2" class="align-middle">
                    <form class="d-flex" action="/search" method="post" role="search">
                        <input class="form-control me-2" name="object_name" type="search" placeholder="<?=$search?>" aria-label="Search">
                    </form>
                </th>
                <th rowspan="2" class="align-middle">Район</th>
                <th rowspan="2" class="align-middle">Адрес</th>
                <th rowspan="2" class="align-middle">Арендодатель</th>
                <th rowspan="2" class="align-middle">Оборудование</th>
                <th colspan="2">Емкость</th>
                <th rowspan="2" class="align-middle">Расчетная мощность, кВт</th>
                <th rowspan="2" class="align-middle">Расчетное потребление, кВт*ч</th>
                <th rowspan="2" class="align-middle">Счетчики</th>
                <th rowspan="2" class="align-middle">Примечание</th>
                <th rowspan="2" class="align-middle">Правки</th>
            </tr>
            <tr>
                <th>монтировано</th>
                <th>задействовано</th>
            </tr>
        </thead> 
        <tbody>
            <?php
                if(!$datas) {
                    ?>
                        <tr>
                            <td colspan="11"><h2>Объект не обнаружен. Проверьте правильность введенного запроса.</h2></td>
                        </tr>
                    <?php
                } else {
                    foreach ($datas as $key => $data) {
                        # code...
                        ?>
                            <tr>
                                <td class="align-middle id_object"><?= $data["id_object"] ?></td>
                                <td class="align-middle object_name"><?= $data["object_name"] ?></td>
                                <td class="align-middle text-center"><?= $data["rues"] ?></td>
                                <td class="align-middle text-center"><?= $data["address"] ?></td>
                                <td class="align-middle text-center">
                                    <?php
                                        $id_object = $data['id_object'];
                                        $id_contract = mysqli_query($db, "SELECT `id_contract` FROM `object_contracts` WHERE `id_object` = '$id_object'");
                                        $id_contract = mysqli_fetch_row($id_contract);
                                        if(isset($id_contract[0])) {
                                            ?>
                                                <a href="/arenda?idc=<?=$id_contract[0]?>&ido=<?=$data['id_object']?>&cda=<?=$data['code_adm']?>"><span class='btn btn-success'>&#128220</span></a>
                                            <?php
                                        } else {
                                            ?>
                                                <a href="/contracts"><span class='btn btn-outline-secondary'>&#10133</span></a>
                                                <!-- <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addArenda" id-obj="<?=$data['id_object']?>" obj-name="<?=$data['object_name']?>">&#128220</button> -->
                                            <?php
                                        }
                                    ?>
                                    
                                </td>
                                <td class="align-middle text-center">
                                    <?php
                                        if($data['devices']) {
                                            ?>
                                                <a class="btn btn-success" href="/device?id=<?=$data['id_object']?>">&#128736</a>
                                            <?php
                                        } else {
                                            ?>
                                                <a class="btn btn-outline-secondary" href="/device?id=<?=$data['id_object']?>">&#128736</a>
                                            <?php
                                        }
                                    ?>                                
                                </td>                                
                                <td class="align-middle text-center"><?= $data["mount"] ?></td>
                                <td class="align-middle text-center"><?= $data["used"] ?></td>
                                <td class="align-middle text-center"><?= round($data['object_power'],3) ?></td>
                                <td class="align-middle text-center"><?= round((($data['object_power'] * 24 * cal_days_in_month(CAL_GREGORIAN, date('m'), date('y')))),3)?></td>
                                <td class="align-middle text-center">
                                    <?php
                                        if($data['cnt']) {
                                            ?>
                                                <a class="btn btn-success" href="/counters?id=<?=$data['id_object']?>" onclick="showModalCounter()">&#9881</a>
                                            <?php
                                        } else {
                                            ?>
                                                <a class="btn btn-outline-secondary" href="/counters?id=<?=$data['id_object']?>" onclick="showModalCounter()">&#9881</a>
                                            <?php
                                        }
                                    ?>
                                    
                                </td>
                                <td class="align-middle text-center">
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#remark" id="<?= $data['id_object'] ?>" remark="<?=$data['remark']?>" obj-name="<?=$data['object_name']?>" code_adm="<?=$data['code_adm']?>">&#128221</button>
                                </td> 
                                <td class="align-middle text-center">
                                    <button type="button" title="Информация" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#updateObject" data-bs-id="<?= $data['id_object'] ?>" data-bs-name="<?= $data['object_name'] ?>" data-bs-rues="<?= $data['rues']?>" data-bs-address="<?=$data['address']?>" data-bs-mount="<?=$data['mount']?>" data-bs-used="<?=$data['used']?>" data-bs-power="<?=$data['object_power']?>">&#9997</button>
                                </td>
                            </tr>
                        <?php
                    }
                }                
            ?>
        </tbody>
        <tfoot class="sticky-bottom bg-success-subtle" style="z-index: -1;">
        <tr>
                <td class="text-center" colspan="13"><i><?=count($datas)?> объект(ов), по запросу:</i> "<b><?=$search?></b>"</td>
            </tr>
        </tfoot>
    </table>