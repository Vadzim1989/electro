<h2 class="text-center analis-name">Удельное потребление эл.энергии на монтированный порт</h2>
<table class="table table-striped device-table">
    <thead>
        <tr>
            <th>УЭС, ЗУЭС</th>
            <th>Название объекта</th>
            <th class="text-center">Потребление ЭЭ за <?=$date[1].$date[0]?></th>
            <th class="text-center">Задействованная емкость объекта</th>
            <th class="text-center">Потребление кВт.ч на зайдествованный порт за месяц</th>
            <th class="text-center">Удельное потребление</th>
            <th>
                <form action="./excel/electro" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="code_adm" value="<?=$code_adm?>">
                    <input type="hidden" name="object_name" value="<?=$object_name?>">
                    <input type="hidden" name="monthFrom" value="<?=$monthFrom?>">
                    <input type="hidden" name="monthTo" value="<?=$monthTo?>">
                    <button title="Excel" class="btn" type="submit">&#128196</button>
                </form>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($datas as $key => $data) {
                if(is_null($data['used']) || $data['used'] == 0) {
                    $usedkvtmonth = 0;
                    $usedkvt = 0;
                } else {
                    $usedkvtmonth = ($data['value_cnt'])/$data['used'];
                    $usedkvt = ($usedkvtmonth * 1000)/(24*cal_days_in_month(CAL_GREGORIAN, date('m'), date('y')));
                }
                ?>
                <tr>
                    <td><?=$data['rues']?></td>
                    <td><?=$data['object_name']?></td>
                    <td class="text-center"><?=$data['value_cnt']?></td>
                    <td class="text-center"><?=$data['used']?></td>
                    <td class="text-center"><?=round($usedkvtmonth,3)?></td>
                    <td colspan="2" class="text-center"><?=round($usedkvt,3)?></td>
                </tr>
                <?php
            }
        ?>
    </tbody>
</table>