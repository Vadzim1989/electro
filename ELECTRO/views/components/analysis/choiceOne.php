<h2 class="text-center analis-name">Удельное потребление эл.энергии на монтированный порт</h2>
<table class="table table-striped device-table">
    <thead>
        <tr>
            <th id="rues_sort" class="align-middle">УЭС, ЗУЭС</th>
            <th id="object_name_sort" class="align-middle">Название объекта</th>
            <?php
                for($i = 0; $i < count($monthForTable); $i++) {
                    ?>
                        <th id="counter" class="text-center align-middle">Потребление за <?=$monthForTable[$i]?></th>
                    <?php
                }
            ?>
            <th id="used" class="text-center align-middle">Задействованная емкость объекта</th>
            <th id="usedKvt" class="text-center align-middle">Потребление кВт.ч на зайдествованный порт</th>
            <th id="udel" class="text-center align-middle">Удельное потребление</th>
            <th class="align-middle">
                <form action="./excel/electro" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="code_adm" value="<?=$code_adm?>">
                    <input type="hidden" name="object_name" value="<?=$object_name?>">
                    <input type="hidden" name="dateFrom" value="<?=$_POST['monthFrom']?>">
                    <input type="hidden" name="dateTo" value="<?=$_POST['monthTo']?>">
                    <input type="hidden" name="years" value="<?=$years?>">
                    <button title="Excel" class="btn excel-btn" type="submit">&#128196</button>
                </form>
            </th>
        </tr>
    </thead>
    <tbody id='table-body'>
        <?php
            foreach($arr as $key => $data) {
                ?>
                <tr>
                    <td><?=$data['rues']?></td>
                    <td><?=$data['object_name']?></td>
                    <?php
                        for($i = 0; $i < count($monthForTable); $i++) {
                            ?>
                                <td class="text-center"><?=$data["cnt".$i]?></td>
                            <?php
                        }
                    ?>
                    <td class="text-center"><?=$data['used']?></td>
                    <td class="text-center"><?=round($data['usedKvt'],3)?></td>
                    <td colspan="2" class="text-center"><?=round($data['udel'],3)?></td>
                </tr>
                <?php
            }
        ?>
    </tbody>
</table>