<h2 class="text-center analis-name">Расхождение показаний по электроэнергии</h2>
<table class="table table-striped device-table">
    <thead>
        <tr>
            <th id="rues_sort" class="align-middle">УЭС, ЗУЭС</th>
            <th id="object_name_sort" class="align-middle">Название объекта</th>
            <th id="counter" class="text-center align-middle">Потребление по счетчику ЦТЭ за <?=$date[1].$date[0]?>" кВт.ч</th>
            <th id="arenda" class="text-center align-middle">Потребление по счет-фактуре за <?=$date[1].$date[0]?>" кВт.ч</th>
            <th id="div" class="text-center align-middle">Разница между потреблениями</th>
            <th id="proc" class="text-center align-middle">% расхождения</th>
            <th>
                <form action="./excel/analis" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="code_adm" value="<?=$code_adm?>">
                    <input type="hidden" name="object_name" value="<?=$object_name?>">
                    <input type="hidden" name="monthFrom" value="<?=$monthFrom?>">
                    <input type="hidden" name="monthTo" value="<?=$monthTo?>">
                    <input type="hidden" name="monthArenda" value="<?=$monthArenda?>">
                    <button title="Excel" class="btn excel-btn" type="submit">&#128196</button>
                </form>
            </th>
        </tr>
    </thead>
    <tbody id='table-body'>        
        <?php
        /*
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
        */
        ?>
    </tbody>
</table>
<script type="text/javascript">
    function buildTable(data) {
        let table = document.getElementById('table-body')
        table.innerHTML = '';
        for (let i = 0; i < data.length; i++) {
            let rues = data[i].rues;
            let object_name = data[i].object_name;
            let counter = data[i].counter;
            let arenda = data[i].arenda;
            let div = data[i].div;
            let proc = data[i].proc;
            let row = `
                <tr>
                    <td>${rues}</td>
                    <td>${object_name}</td>
                    <td class="text-center">${counter}</td>
                    <td class="text-center">${arenda}</td>
                    <td class="text-center">${div.toFixed(2)}</td>
                    <td class="text-center" colspan='2'>${+proc}</td>
                <tr/>
                `;
            table.innerHTML += row;
        }
    }

    buildTable(arr);
</script>