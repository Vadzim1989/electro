<h2 class="text-center analis-name">Расхождение показаний по электроэнергии</h2>
<table class="table table-striped table-bordered device-table">
    <thead>
        <tr>
            <th id="rues_sort" class="align-middle" <?php if(count($monthForTable) > 5) echo ("style='font-size: .75rem;'")?>>УЭС, ЗУЭС</th>
            <th id="object_name_sort" class="align-middle" <?php if(count($monthForTable) > 5) echo ("style='font-size: .75rem;'")?>>Название объекта</th>
            <?php
                for($i = 0; $i < count($monthForTable); $i++) {
                    ?>
                        <th id="counter" class="text-center align-middle" <?php if(count($monthForTable) > 5) echo ("style='font-size: .75rem;'")?>>ЦТЭ <?=$monthForTable[$i]?></th>
                        <th id="counter" class="text-center align-middle" <?php if(count($monthForTable) > 5) echo ("style='font-size: .75rem;'")?>>СФ <?=$monthForTable[$i]?></th>
                        <th id="counter" class="text-center align-middle" <?php if(count($monthForTable) > 5) echo ("style='font-size: .75rem;'")?>>Раз.</th>
                        <th id="counter" class="text-center align-middle">&#8240</th>
                    <?php
                }
            ?>
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
                    <td <?php if(count($monthForTable) > 5) echo ("style='font-size: .8rem;'")?>><?=$datas[$i]['rues']?></td>
                    <td class="object_name" <?php if(count($monthForTable) > 5) echo ("style='font-size: .8rem;'")?>><?=$datas[$i]['object_name']?></td>
                    <?php
                        for($j = 0; $j < count($monthForTable) - 1; $j++) {
                            ?>
                                <td class="text-center align-middle"><?php if($datas[$i]['cnt'.$j]) {echo (round($datas[$i]['cnt'.$j],2));} else echo ""?></td>
                                <td class="text-center align-middle"><?php if($datas[$i]['arn'.$j]) {echo (round($datas[$i]['arn'.$j],2));} else echo "" ?></td>
                                <td class="text-center align-middle"><?php if($datas[$i]['div'.$j]) {echo (round($datas[$i]['div'.$j],2));} else echo "" ?></td>
                                <td class="text-center align-middle"><?php if($datas[$i]['proc'.$j]) {echo (round($datas[$i]['proc'.$j],2));} else echo "" ?></td>
                            <?php
                        }
                        for($j = count($monthForTable) - 1; $j < count($monthForTable); $j++) {
                            ?>
                                <td class="text-center align-middle"><?php if($datas[$i]['cnt'.$j]) {echo (round($datas[$i]['cnt'.$j],2));} else echo ""?></td>
                                <td class="text-center align-middle"><?php if($datas[$i]['arn'.$j]) {echo (round($datas[$i]['arn'.$j],2));} else echo "" ?></td>
                                <td class="text-center align-middle"><?php if($datas[$i]['div'.$j]) {echo (round($datas[$i]['div'.$j],2));} else echo "" ?></td>
                                <td colspan="2" class="text-center align-middle"><?php if($datas[$i]['proc'.$j]) {echo (round($datas[$i]['proc'.$j],2));} else echo "" ?></td>
                            <?php
                        }
                    ?>
                </tr>
                <?php
            }
        ?>
    </tbody>
</table>