<h2 class="text-center analis-name">Расхождение показаний по электроэнергии</h2>
<table class="table table-striped table-bordered device-table">
    <thead>
        <tr>
            <th id="rues_sort" class="align-middle" <?php if(count($monthForTable) > 5) echo ("style='font-size: .75rem;'")?>>УЭС, ЗУЭС</th>
            <th id="object_name_sort" class="align-middle" <?php if(count($monthForTable) > 5) echo ("style='font-size: .75rem;'")?>>Название объекта</th>
            <th id="counter" class="text-center align-middle">показания по ЦТЭ</th>
            <th id="counter" class="text-center align-middle">показания по СФ</th>
            <th id="counter" class="text-center align-middle">Разница</th>
            <th id="counter" class="text-center align-middle">%-рассхождения</th>
            <th>
                <form action="./excel/analis" method="post" enctype="multipart/form-data">
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
            for($i = 0; $i < count($datas); $i++) {
                ?>
                <tr>
                    <td><?=$datas[$i]['rues']?></td>
                    <td class="object_name"><?=$datas[$i]['object_name']?></td>
                    <td class="text-center align-middle"><?=$datas[$i]['cnt']?></td>
                    <td class="text-center align-middle"><?=$datas[$i]['arn']?></td>
                    <td class="text-center align-middle"><?=round($datas[$i]['div'],2)?></td>
                    <td colspan="2" class="text-center align-middle"><?=$datas[$i]['proc']?></td>
                </tr>
                <?php
            }
        ?>
    </tbody>
</table>
