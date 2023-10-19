<h2 class="text-center analis-name">Расхождение показаний по электроэнергии</h2>
<table class="table table-striped device-table">
    <thead>
        <tr>
            <th>УЭС, ЗУЭС</th>
            <th>Название объекта</th>
            <th class="text-center">Потребление по счетчику ЦТЭ за <?=$date[1].$date[0]?>" кВт.ч</th>
            <th class="text-center">Потребление по счет-фактуре за <?=$date[1].$date[0]?>" кВт.ч</th>
            <th class="text-center">Разница между потреблениями</th>
            <th class="text-center">% расхождения</th>
            <th>
                <form action="./excel/analis" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="code_adm" value="<?=$code_adm?>">
                    <input type="hidden" name="object_name" value="<?=$object_name?>">
                    <input type="hidden" name="monthFrom" value="<?=$monthFrom?>">
                    <input type="hidden" name="monthTo" value="<?=$monthTo?>">
                    <input type="hidden" name="monthArenda" value="<?=$monthArenda?>">
                    <button title="Excel" class="btn" type="submit">&#128196</button>
                </form>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($datas as $key => $data) {
                $counter = $data['value_cnt'];
                $arenda = $data['arenda'];
                $div = $counter - $arenda;
                if($div) {
                    $proc = ($counter - $arenda)/(($counter+$arenda)/2)*100;
                } else {
                    $proc = 0;
                }
                ?>
                <tr>
                    <td><?=$data['rues']?></td>
                    <td><?=$data['object_name']?></td>
                    <td class="text-center"><?=$counter?></td>
                    <td class="text-center"><?=$arenda?></td>
                    <td class="text-center"><?=$div?></td>
                    <td colspan="2" class="text-center"><?=abs(round($proc,2))?></td>
                </tr>
                <?php
            }
        ?>
    </tbody>
</table>