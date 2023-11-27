<table class="table table-striped">
<thead>
        <tr>
            <th class="align-middle">
                <form action="./excel/object" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="code_adm" value="<?=$code_adm?>">
                    <input type="hidden" name="object_name" value="<?=$name?>">
                    <input type="hidden" name="sort" value="<?=$sort?>">
                    <input type="hidden" name="contract" value="<?=$contract?>">
                    <input type="hidden" name="area" value="<?=$area?>">
                    <input type="hidden" name="landlord" value="<?=$landlord?>">
                    <input type="hidden" name="obj" value="<?=$obj?>">
                    <input type="hidden" name="dev" value="<?=$dev?>">
                    <input type="hidden" name="cnt" value="<?=$cnt?>">
                    <button title="Excel" class="btn" type="submit">&#128196</button>
                </form>
                №
            </th>
            <th class="align-middle">
                <form class="d-flex" action="/search" method="post" role="search">
                    <input class="form-control me-2" name="object_name" type="search" placeholder="Название объекта (поиск)" aria-label="Search">
                </form>
            </th>
            <th class="align-middle">Район</th>
            <th class="align-middle">Адрес</th>
            <th class="align-middle">Арендодатель</th>
            <th class="align-middle">Оборудование</th>
            <th class="align-middle">Емкость</th>
            <th class="align-middle">Расчетная мощность, кВт</th>
            <th class="align-middle">Расчетное потребление, кВт*ч (месячное)</th>
            <th class="align-middle">Счетчики</th>
            <th class="align-middle">Примечание</th>
            <th class="align-middle">
                <button type="button" title="Добавить объект" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addObject" code-adm="<?=$code_adm?>">&#10010</button>
            </th>
            <th class="align-middle"><a class="btn btn-outline-primary" title="Сбросить фильтр" href="/" onclick="load()">&#10006</a></th>
        </tr>
    </thead> 
    <tbody>
        <?php
            foreach ($datas as $key => $data) {
                # code...
                ?>
                    <tr>
                        <td class="align-middle id_object"><?= $data['id_object'] ?></td>
                        <td class="align-middle object_name"><?= $data['object_name'] ?></td>
                        <td class="align-middle object_rues"><?= $data['rues'] ?></td>
                        <td class="align-middle object_address"><?= $data['address'] ?></td>
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
                                        <a class="btn btn-success" title="Оборудование" href="/device?id=<?=$data['id_object']?>">&#128736</a>
                                    <?php
                                } else {
                                    ?>
                                        <a class="btn btn-outline-secondary" title="Оборудование" href="/device?id=<?=$data['id_object']?>">&#128736</a>
                                    <?php
                                }
                            ?>                                
                        </td>                            
                        <td class="align-middle"><a class="btn mount_icon" href="./mount?id=<?=$data['id_object']?>">&#128736</a></td>
                        <td class="align-middle"><?= isset($data['object_power']) ? round($data['object_power'],3) : 0 ?></td>
                        <td class="align-middle"><?= round((($data['object_power'] * 24 * cal_days_in_month(CAL_GREGORIAN, date('m'), date('y')))),3)?></td>
                        <td class="align-middle">
                            <?php
                                if($data['cnt']) {
                                    ?>
                                        <a class="btn btn-success" title="Счетчики" href="/counters?id=<?=$data['id_object']?>">&#9881</a>
                                    <?php
                                } else {
                                    ?>
                                        <a class="btn btn-outline-secondary" title="Счетчики" href="/counters?id=<?=$data['id_object']?>">&#9881</a>
                                    <?php
                                }
                            ?>
                            
                        </td>
                        <td class="align-middle remark">
                            <?php
                                if($data['remark']){
                                    ?>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#remark" id="<?= $data['id_object'] ?>" remark="<?=$data['remark']?>" obj-name="<?=$data['object_name']?>" code_adm="<?=$data['code_adm']?>">&#128221</button>
                                    <?php
                                }else{
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#remark" id="<?= $data['id_object'] ?>" remark="<?=$data['remark']?>" obj-name="<?=$data['object_name']?>" code_adm="<?=$data['code_adm']?>">&#128221</button>
                                    <?php
                                }
                            ?>                                
                        </td>
                        <td colspan="2" class="align-middle">
                            <button type="button" title="Информация" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#updateObject" data-bs-id="<?= $data['id_object'] ?>" data-bs-name="<?= $data['object_name'] ?>" data-bs-rues="<?= $data['rues']?>" data-bs-address="<?=$data['address']?>" data-bs-mount="<?=$data['mount']?>" data-bs-used="<?=$data['used']?>" data-bs-power="<?=$data['object_power']?>">&#9997</button>
                        </td>
                    </tr>
                <?php
            }
        ?>
    </tbody>
    <tfoot class="sticky-bottom bg-success-subtle" style="z-index: -1;">
        <tr>
            <td class="text-center" colspan="14">Количество введенных объектов: <?=count($datas)?></td>
        </tr>
    </tfoot>
</table>  