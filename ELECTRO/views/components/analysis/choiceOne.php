<h2 class="text-center" style="background: #E3E3E3;">Удельное потребление эл.энергии на монтированный порт</h2>
<table class="table table-striped device-table">
    <thead>
        <tr>
            <th>УЭС, ЗУЭС</th>
            <th>Название объекта</th>
            <?php
                if($dateTo[0]==$dateFrom[0]) {
                    for($i = $indexF; $i <= $indexT + 1; $i++) {
                        if($i==12) {
                            ?>
                                <th>01<?=$dateFrom[0]+1?></th>
                            <?php
                            break;
                        }
                        $month = explode("_",$monthData[$i]);
                        ?>
                            <th><?=$month[1]?></th>
                        <?php                
                    };
                }elseif($dateTo[0]>$dateFrom[0]) {
                    for($i = $indexF; $i < 12; $i++) {
                        $month = explode("_",$monthData[$i]);
                        ?>
                            <th><?=$month[1]?></th>
                        <?php                  
                    };
                    for($i = 0; $i <= $indexT + 1; $i++) {
                        if($i==12) {
                            ?>
                                <th>01<?=$dateTo[0]+1?></th>
                            <?php
                            break;
                        }
                        $month = explode("_",$nextYear[$i]);
                        ?>
                            <th><?=$month[1]?></th>
                        <?php                
                    };
                } 
            ?>
            <th>Задействованная емкость объекта</th>
            <th>
                <form action="./excel/electro" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="code_adm" value="<?=$code_adm?>">
                    <input type="hidden" name="object_name" value="<?=$object_name?>">
                    <input type="hidden" name="monthFrom" value="<?=$monthFrom?>">
                    <input type="hidden" name="monthTo" value="<?=$monthTo?>">
                    <button class="btn" type="submit">&#128196</button>
                </form>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($datas as $key => $data) {
                ?>
                <tr>
                    <td><?=$data['rues']?></td>
                    <td><?=$data['object_name']?></td>
                <?php 
                    if($dateTo[0]==$dateFrom[0]) {
                        for($i = $indexF; $i <= $indexT + 1; $i++) {
                            if($i==12) {
                                ?>
                                    <td><?=$data["cnt".$i."value"]?></td>
                                <?php
                                break;
                            }
                            ?>
                                <td><?=$data["cnt".$i."value"]?></td>
                            <?php                
                        };
                    }elseif($dateTo[0]>$dateFrom[0]) {
                        for($i = $indexF; $i < 12; $i++) {
                            ?>
                                <td><?=$data["cnt".$i."value"]?></th>
                            <?php                  
                        };
                        for($i = 0; $i <= $indexT + 1; $i++) {
                            if($i==12) {
                                ?>
                                    <td><?=$data["cnt".$i."value"]?></td>
                                <?php
                                break;
                            }
                            ?>
                                <td><?=$data["cnt".$i."value"]?></td>
                            <?php                
                        };
                    }
                ?>
                    <td colspan="2"><?=$data['used']?></td>
                </tr>
                <?php
            }
        ?>
    </tbody>
</table>