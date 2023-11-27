<?php   
    $rues = mysqli_query($db, "SELECT obcal.name FROM `object_code_adm_list` obcal WHERE obcal.code_adm in (select code_adm from `object` where id_object = '$id')");
    $rues = mysqli_fetch_assoc($rues);
    
    $object = mysqli_query($db, "SELECT `object_name` FROM `object` WHERE `id_object` = '$id'");
    $object = mysqli_fetch_assoc($object);
?>
<h2 class="text-center"><?=$rues['name']?> - &#127969 <?=$object['object_name']?></h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Емкость</th>
            <th>Январь <?=date('Y');?></th>
            <th>Февраль <?=date('Y');?></th>
            <th>Март <?=date('Y');?></th>
            <th>Апрель <?=date('Y');?></th>
            <th>Май <?=date('Y');?></th>
            <th>Июнь <?=date('Y');?></th>
            <th>Июль <?=date('Y');?></th>
            <th>Август <?=date('Y');?></th>
            <th>Сентябрь <?=date('Y');?></th>
            <th>Октябрь <?=date('Y');?></th>
            <th>Ноябрь <?=date('Y');?></th>
            <th>Декабрь <?=date('Y');?></th>
            <th>
                <button type="button" title="Фильтр" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filter" id-object="<?=$id?>">&#128269</button>
            </th>
        </tr>
    </thead> 
    <tbody>
        <?php
            foreach ($datas as $key => $data) {
                # code...
                ?>
                    <tr>
                        <td class="align-middle">Задействовано</td>
                        <td class="align-middle">
                            <?php
                                if($data["janu"]) {
                                    ?>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="январь" used="<?=$data['janu']?>" mount="<?=$data['janm']?>" obj="<?=$id?>" table="<?=$jan?>"><?=$data['janu']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="январь" obj="<?=$id?>" table="<?=$jan?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["febu"]) {
                                    ?>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="февраль" used="<?=$data['febu']?>" mount="<?=$data['febm']?>" obj="<?=$id?>" table="<?=$feb?>"><?=$data['febu']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="февраль" obj="<?=$id?>" table="<?=$feb?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>            
                        <td class="align-middle">
                            <?php
                                if($data["maru"]) {
                                    ?>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="март" used="<?=$data['maru']?>" mount="<?=$data['marm']?>" obj="<?=$id?>" table="<?=$mar?>"><?=$data['maru']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="март" obj="<?=$id?>" table="<?=$mar?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["apru"]) {
                                    ?>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="апрель" used="<?=$data['apru']?>" mount="<?=$data['aprm']?>" obj="<?=$id?>" table="<?=$apr?>"><?=$data['apru']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="апрель" obj="<?=$id?>" table="<?=$apr?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["mayu"]) {
                                    ?>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="май" used="<?=$data['mayu']?>" mount="<?=$data['maym']?>" obj="<?=$id?>" table="<?=$may?>"><?=$data['mayu']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="май" obj="<?=$id?>" table="<?=$may?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["junu"]) {
                                    ?>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="июнь" used="<?=$data['junu']?>" mount="<?=$data['junm']?>" obj="<?=$id?>" table="<?=$jun?>"><?=$data['junu']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="июнь" obj="<?=$id?>" table="<?=$jun?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["julu"]) {
                                    ?>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="июль" used="<?=$data['julu']?>" mount="<?=$data['julm']?>" obj="<?=$id?>" table="<?=$jul?>"><?=$data['julu']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="июль" obj="<?=$id?>" table="<?=$jul?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["augu"]) {
                                    ?>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="август" used="<?=$data['augu']?>" mount="<?=$data['augm']?>" obj="<?=$id?>" table="<?=$aug?>"><?=$data['augu']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="август" obj="<?=$id?>" table="<?=$aug?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["sepu"]) {
                                    ?>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="сентябрь" used="<?=$data['sepu']?>" mount="<?=$data['sepm']?>" obj="<?=$id?>" table="<?=$sep?>"><?=$data['sepu']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="сентябрь" obj="<?=$id?>" table="<?=$sep?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["octu"]) {
                                    ?>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="октябрь" used="<?=$data['octu']?>" mount="<?=$data['octm']?>" obj="<?=$id?>" table="<?=$oct?>"><?=$data['octu']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="октябрь" obj="<?=$id?>" table="<?=$oct?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["novu"]) {
                                    ?>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="ноябрь" used="<?=$data['novu']?>" mount="<?=$data['novm']?>" obj="<?=$id?>" table="<?=$nov?>"><?=$data['novu']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="ноябрь" obj="<?=$id?>" table="<?=$nov?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["decemberu"]) {
                                    ?>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="декабрь" used="<?=$data['decemberu']?>" mount="<?=$data['decemberm']?>" obj="<?=$id?>" table="<?=$dec?>"><?=$data['decemberu']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addPortsInfo" month="декабрь" obj="<?=$id?>" table="<?=$dec?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                        </td>
                    </tr>
                    <tr>
                        <td class="align-middle">Монтировано</td>
                        <td class="align-middle"><button class="btn"><?=$data['janm']?></button></td>
                        <td class="align-middle"><button class="btn"><?=$data['febm']?></button></td>
                        <td class="align-middle"><button class="btn"><?=$data['marm']?></button></td>
                        <td class="align-middle"><button class="btn"><?=$data['aprm']?></button></td>
                        <td class="align-middle"><button class="btn"><?=$data['maym']?></button></td>
                        <td class="align-middle"><button class="btn"><?=$data['junm']?></button></td>
                        <td class="align-middle"><button class="btn"><?=$data['julm']?></button></td>
                        <td class="align-middle"><button class="btn"><?=$data['augm']?></button></td>
                        <td class="align-middle"><button class="btn"><?=$data['sepm']?></button></td>
                        <td class="align-middle"><button class="btn"><?=$data['octm']?></button></td>
                        <td class="align-middle"><button class="btn"><?=$data['novm']?></button></td>
                        <td class="align-middle"><button class="btn"><?=$data['decemberm']?></button></td>
                        <td class="align-middle"></td>
                    </tr>
                <?php
            }
        ?>
    </tbody>
</table>
