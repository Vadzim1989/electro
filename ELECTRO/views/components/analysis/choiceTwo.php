<h2 class="text-center" style="background: #E3E3E3;">Расхождение показаний по электроэнергии</h2>
<table class="table table-striped device-table">
    <thead>
        <tr>
            <th>УЭС, ЗУЭС</th>
            <th>Название объекта</th>
            <th>Показания по счетчику ЦТЭ за <?=$date[1].$date[0]?>" кВт.ч</th>
            <th>Показания по счет-фактуре за <?=$date[1].$date[0]?>" кВт.ч</th>
            <th>Разница между показаниями</th>
            <th>% расхождения</th>
            <th>
                <form action="./excel/analis" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="code_adm" value="<?=$code_adm?>">
                    <input type="hidden" name="object_name" value="<?=$object_name?>">
                    <input type="hidden" name="monthFrom" value="<?=$monthFrom?>">
                    <input type="hidden" name="monthTo" value="<?=$monthTo?>">
                    <input type="hidden" name="monthArenda" value="<?=$monthArenda?>">
                    <button class="btn" type="submit">&#128196</button>
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
                    <td><?=$data['value_cnt']?></td>
                    <td><?=$data['arenda']?></td>
                    <td><?=$div?></td>
                    <td colspan="2"><?=abs(round($proc,2))?></td>
                </tr>
                <?php
            }
        ?>
    </tbody>
</table>