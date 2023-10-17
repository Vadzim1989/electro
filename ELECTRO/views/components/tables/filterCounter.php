<?php                
    $object = mysqli_query($db, "SELECT `object_name` FROM `object` WHERE `id_object` = '$id'");
    $object = mysqli_fetch_assoc($object);
?>
<h2 class="text-center">&#127969 <?=$object['object_name']?></h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>№</th>
            <th>Тип счетчика</th>
            <th>№ заводской</th>
            <th>Январь <?=$year;?></th>
            <th></th>
            <th>Февраль <?=$year;?></th>
            <th></th>
            <th>Март <?=$year;?></th>
            <th></th>
            <th>Апрель <?=$year;?></th>
            <th></th>
            <th>Май <?=$year;?></th>
            <th></th>
            <th>Июнь <?=$year;?></th>
            <th></th>
            <th>Июль <?=$year;?></th>
            <th></th>
            <th>Август <?=$year;?></th>
            <th></th>
            <th>Сентябрь <?=$year;?></th>
            <th></th>
            <th>Октябрь <?=$year;?></th>
            <th></th>
            <th>Ноябрь <?=$year;?></th>
            <th></th>
            <th>Декабрь <?=$year;?></th>
            <th>
                <button type="button" title="Добавить счетчик" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCounter" id-object="<?=$id?>" obj-name="<?=$object['object_name']?>">&#10010</button>
            </th>
            <th><a class="btn btn-outline-primary me-2" title="Сбросить фильтр" href="/ELECTRO/counters?id=<?=$id?>">&#10006</a></th>
        </tr>
    </thead> 
    <tbody>
        <?php
            foreach ($datas as $key => $data) {
                # code...
                ?>
                    <tr>
                        <td class="align-middle id_counter"><?= $data["id_counter"] ?></td>
                        <td class="align-middle name"><?= $data["name"] ?></td>
                        <td class="align-middle"><?= $data["sn"] ?></td>
                        <td class="align-middle">
                            <?php
                                if($data["jan"]) {
                                    ?>
                                        <button type="button" class="<?php if($data['online']) echo 'btn btn-outline-success'; else echo 'btn btn-outline-secondary' ?>" data-bs-toggle="modal" data-bs-target="#addCounterData" month="январь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['jan']?>" obj="<?=$id?>" cnt-table="<?=$jan?>"><?=$data['jan']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterData" month="январь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['jan']?>" obj="<?=$id?>" cnt-table="<?=$jan?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data['feb']-$data['jan'] < 0) {
                                    echo "0";
                                } else {
                                    echo round($data['feb']-$data['jan'],2);
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["feb"]) {
                                    ?>
                                        <button type="button" class="<?php if($data['online']) echo 'btn btn-outline-success'; else echo 'btn btn-outline-secondary' ?>" data-bs-toggle="modal" data-bs-target="#addCounterData" month="февраль" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['feb']?>" obj="<?=$id?>" cnt-table="<?=$feb?>"><?=$data['feb']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterData" month="февраль" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['feb']?>" obj="<?=$id?>" cnt-table="<?=$feb?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>                
                        <td class="align-middle">
                            <?php
                                if($data['mar']-$data['feb'] < 0) {
                                    echo "0";
                                } else {
                                    echo round($data['mar']-$data['feb'],2);
                                }
                            ?>
                        </td>            
                        <td class="align-middle">
                            <?php
                                if($data["mar"]) {
                                    ?>
                                        <button type="button" class="<?php if($data['online']) echo 'btn btn-outline-success'; else echo 'btn btn-outline-secondary' ?>" data-bs-toggle="modal" data-bs-target="#addCounterData" month="март" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['mar']?>" obj="<?=$id?>" cnt-table="<?=$mar?>"><?=$data['mar']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterData" month="март" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['mar']?>" obj="<?=$id?>" cnt-table="<?=$mar?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data['apr']-$data['feb'] < 0) {
                                    echo "0";
                                } else {
                                    echo round($data['apr']-$data['feb'],2);
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["apr"]) {
                                    ?>
                                        <button type="button" class="<?php if($data['online']) echo 'btn btn-outline-success'; else echo 'btn btn-outline-secondary' ?>" data-bs-toggle="modal" data-bs-target="#addCounterData" month="апрель" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['apr']?>" obj="<?=$id?>" cnt-table="<?=$apr?>"><?=$data['apr']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterData" month="апрель" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['apr']?>" obj="<?=$id?>" cnt-table="<?=$apr?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data['may']-$data['apr'] < 0) {
                                    echo "0";
                                } else {
                                    echo round($data['may']-$data['apr'],2);
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["may"]) {
                                    ?>
                                        <button type="button" class="<?php if($data['online']) echo 'btn btn-outline-success'; else echo 'btn btn-outline-secondary' ?>" data-bs-toggle="modal" data-bs-target="#addCounterData" month="май" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['may']?>" obj="<?=$id?>" cnt-table="<?=$may?>"><?=$data['may']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterData" month="май" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['may']?>" obj="<?=$id?>" cnt-table="<?=$may?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data['jun']-$data['may'] < 0) {
                                    echo "0";
                                } else {
                                    echo round($data['jun']-$data['may'],2);
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["jun"]) {
                                    ?>
                                        <button type="button" class="<?php if($data['online']) echo 'btn btn-outline-success'; else echo 'btn btn-outline-secondary' ?>" data-bs-toggle="modal" data-bs-target="#addCounterData" month="июнь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['jun']?>" obj="<?=$id?>" cnt-table="<?=$jun?>"><?=$data['jun']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterData" month="июнь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['jun']?>" obj="<?=$id?>" cnt-table="<?=$jun?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data['jul']-$data['jun'] < 0) {
                                    echo "0";
                                } else {
                                    echo round($data['jul']-$data['jun'],2);
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["jul"]) {
                                    ?>
                                        <button type="button" class="<?php if($data['online']) echo 'btn btn-outline-success'; else echo 'btn btn-outline-secondary' ?>" data-bs-toggle="modal" data-bs-target="#addCounterData" month="июль" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['jul']?>" obj="<?=$id?>" cnt-table="<?=$jul?>"><?=$data['jul']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterData" month="июль" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['jul']?>" obj="<?=$id?>" cnt-table="<?=$jul?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data['aug']-$data['jul'] < 0) {
                                    echo "0";
                                } else {
                                    echo round($data['aug']-$data['jul'],2);
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["aug"]) {
                                    ?>
                                        <button type="button" class="<?php if($data['online']) echo 'btn btn-outline-success'; else echo 'btn btn-outline-secondary' ?>" data-bs-toggle="modal" data-bs-target="#addCounterData" month="август" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['aug']?>" obj="<?=$id?>" cnt-table="<?=$aug?>"><?=$data['aug']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterData" month="август" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['aug']?>" obj="<?=$id?>" cnt-table="<?=$aug?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data['sep']-$data['aug'] < 0) {
                                    echo "0";
                                } else {
                                    echo round($data['sep']-$data['aug'],2);
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["sep"]) {
                                    ?>
                                        <button type="button" class="<?php if($data['online']) echo 'btn btn-outline-success'; else echo 'btn btn-outline-secondary' ?>" data-bs-toggle="modal" data-bs-target="#addCounterData" month="сентябрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['sep']?>" obj="<?=$id?>" cnt-table="<?=$sep?>"><?=$data['sep']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterData" month="сентябрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['sep']?>" obj="<?=$id?>" cnt-table="<?=$sep?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data['oct']-$data['sep'] < 0) {
                                    echo "0";
                                } else {
                                    echo round($data['oct']-$data['sep'],2);
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["oct"]) {
                                    ?>
                                        <button type="button" class="<?php if($data['online']) echo 'btn btn-outline-success'; else echo 'btn btn-outline-secondary' ?>" data-bs-toggle="modal" data-bs-target="#addCounterData" month="октябрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['oct']?>" obj="<?=$id?>" cnt-table="<?=$oct?>"><?=$data['oct']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterData" month="октябрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['oct']?>" obj="<?=$id?>" cnt-table="<?=$oct?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data['nov']-$data['oct'] < 0) {
                                    echo "0";
                                } else {
                                    echo round($data['nov']-$data['oct'],2);
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["nov"]) {
                                    ?>
                                        <button type="button" class="<?php if($data['online']) echo 'btn btn-outline-success'; else echo 'btn btn-outline-secondary' ?>" data-bs-toggle="modal" data-bs-target="#addCounterData" month="ноябрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['nov']?>" obj="<?=$id?>" cnt-table="<?=$nov?>"><?=$data['nov']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterData" month="ноябрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['nov']?>" obj="<?=$id?>" cnt-table="<?=$nov?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data['december']-$data['nov'] < 0) {
                                    echo "0";
                                } else {
                                    echo round($data['december']-$data['nov'],2);
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["december"]) {
                                    ?>
                                        <button type="button" class="<?php if($data['online']) echo 'btn btn-outline-success'; else echo 'btn btn-outline-secondary' ?>" data-bs-toggle="modal" data-bs-target="#addCounterData" month="декабрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['december']?>" obj="<?=$id?>" cnt-table="<?=$dec?>"><?=$data['december']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterData" month="декабрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['december']?>" obj="<?=$id?>" cnt-table="<?=$dec?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td colspan="2" class="align-middle">
                            <button type="button" title="Информация" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateCounter" cnt-id="<?=$data['id_counter']?>" cnt-type="<?=$data['name']?>" cnt-sn="<?=$data['sn']?>" obj-id="<?=$id?>">&#9997</button>
                        </td>
                    </tr>
                <?php
            }
        ?>
    </tbody>
</table>
<h2 class="text-center">Данные по счет-фактуре арендодателя</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Показания</th>
            <th>Январь <?=$year;?></th>
            <th>Февраль <?=$year;?></th>
            <th>Март <?=$year;?></th>
            <th>Апрель <?=$year;?></th>
            <th>Май <?=$year;?></th>
            <th>Июнь <?=$year;?></th>
            <th>Июль <?=$year;?></th>
            <th>Август <?=$year;?></th>
            <th>Сентябрь <?=$year;?></th>
            <th>Октябрь <?=$year;?></th>
            <th>Ноябрь <?=$year;?></th>
            <th>Декабрь <?=$year;?></th>
            <th>
                <button type="button" title="Добавить показания" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCounterArenda" id-object="<?=$id?>" obj-name="<?=$object['object_name']?>">&#10010</button>
            </th>
        </tr>
    </thead> 
    <tbody>
        <?php
            foreach ($arendas as $key => $data) {
                # code...
                ?>
                    <tr>
                        <td class="align-middle name"><?= $data["name"] ?></td>
                        <td class="align-middle">
                            <?php
                                if($data["jan"]) {
                                    ?>
                                        <button type="button" class="btn btn-outline-primary arena-cnt" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="январь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['jan']?>" obj="<?=$id?>" cnt-table="<?=$janArenda?>" pay="<?=$data['jan_pay']?>"><?=$data['jan']?></button>
                                        <p class="text-center"><?=$data['jan_pay']?></p>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="январь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['jan']?>" obj="<?=$id?>" cnt-table="<?=$janArenda?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["feb"]) {
                                    ?>
                                        <button type="button" class="btn btn-outline-primary arena-cnt" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="февраль" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['feb']?>" obj="<?=$id?>" cnt-table="<?=$febArenda?>"><?=$data['feb']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="февраль" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['feb']?>" obj="<?=$id?>" cnt-table="<?=$febArenda?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>             
                        <td class="align-middle">
                            <?php
                                if($data["mar"]) {
                                    ?>
                                        <button type="button" class="btn btn-outline-primary arena-cnt" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="март" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['mar']?>" obj="<?=$id?>" cnt-table="<?=$marArenda?>"><?=$data['mar']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="март" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['mar']?>" obj="<?=$id?>" cnt-table="<?=$marArenda?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["apr"]) {
                                    ?>
                                        <button type="button" class="btn btn-outline-primary arena-cnt" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="апрель" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['apr']?>" obj="<?=$id?>" cnt-table="<?=$aprArenda?>"><?=$data['apr']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="апрель" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['apr']?>" obj="<?=$id?>" cnt-table="<?=$aprArenda?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["may"]) {
                                    ?>
                                        <button type="button" class="btn btn-outline-primary arena-cnt" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="май" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['may']?>" obj="<?=$id?>" cnt-table="<?=$mayArenda?>"><?=$data['may']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="май" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['may']?>" obj="<?=$id?>" cnt-table="<?=$mayArenda?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["jun"]) {
                                    ?>
                                        <button type="button" class="btn btn-outline-primary arena-cnt" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="июнь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['jun']?>" obj="<?=$id?>" cnt-table="<?=$junArenda?>"><?=$data['jun']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="июнь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['jun']?>" obj="<?=$id?>" cnt-table="<?=$junArenda?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["jul"]) {
                                    ?>
                                        <button type="button" class="btn btn-outline-primary arena-cnt" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="июль" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['jul']?>" obj="<?=$id?>" cnt-table="<?=$julArenda?>" pay="<?=$data['jul_pay']?>"><?=$data['jul']?></button>
                                        <p class="pay_index"><?=$data['jul_pay']?> р.</p>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="июль" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['jul']?>" obj="<?=$id?>" cnt-table="<?=$julArenda?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["aug"]) {
                                    ?>
                                        <button type="button" class="btn btn-outline-primary arena-cnt" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="август" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['aug']?>" obj="<?=$id?>" cnt-table="<?=$augArenda?>"><?=$data['aug']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="август" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['aug']?>" obj="<?=$id?>" cnt-table="<?=$augArenda?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["sep"]) {
                                    ?>
                                        <button type="button" class="btn btn-outline-primary arena-cnt" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="сентябрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['sep']?>" obj="<?=$id?>" cnt-table="<?=$sepArenda?>"><?=$data['sep']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="сентябрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['sep']?>" obj="<?=$id?>" cnt-table="<?=$sepArenda?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["oct"]) {
                                    ?>
                                        <button type="button" class="btn btn-outline-primary arena-cnt" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="октябрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['oct']?>" obj="<?=$id?>" cnt-table="<?=$octArenda?>"><?=$data['oct']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="октябрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['oct']?>" obj="<?=$id?>" cnt-table="<?=$octArenda?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["nov"]) {
                                    ?>
                                        <button type="button" class="btn btn-outline-primary arena-cnt" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="ноябрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['nov']?>" obj="<?=$id?>" cnt-table="<?=$novArenda?>"><?=$data['nov']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="ноябрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['nov']?>" obj="<?=$id?>" cnt-table="<?=$novArenda?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <?php
                                if($data["december"]) {
                                    ?>
                                        <button type="button" class="btn btn-outline-primary arena-cnt" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="декабрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['december']?>" obj="<?=$id?>" cnt-table="<?=$decArenda?>"><?=$data['december']?></button>
                                    <?php
                                } else {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCounterArendaData" month="декабрь" cnt-id="<?=$data['id_counter']?>" cnt-value="<?=$data['december']?>" obj="<?=$id?>" cnt-table="<?=$decArenda?>">&#10006</button>
                                    <?php
                                }
                            ?>
                        </td>
                        <td class="align-middle">
                            <form class="deleteForm" action="./counter/deleteArenda" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id_delete" value="<?=$data['id_counter']?>">
                                <input type="hidden" name="id_object_delete" value="<?=$id?>">
                                <button type="submit" class="btn btn-danger deleteButton">&#10006</button>
                            </form>
                        </td>
                    </tr>
                <?php
            }
        ?>
    </tbody>
</table>