<h2 class="text-center analis-name">Удельное потребление эл.энергии на монтированный порт</h2>
<table class="table table-striped device-table">
    <thead>
        <tr>
            <th id="rues_sort" class="align-middle">УЭС, ЗУЭС</th>
            <th id="object_name_sort" class="align-middle">Название объекта</th>
            <th id="counter" class="text-center align-middle">Потребление ЭЭ за <?=$date[1].$date[0]?></th>
            <th id="used" class="text-center align-middle">Задействованная емкость объекта</th>
            <th id="usedKvt" class="text-center align-middle">Потребление кВт.ч на зайдествованный порт за месяц</th>
            <th id="udel" class="text-center align-middle">Удельное потребление</th>
            <th class="align-middle">
                <form action="./excel/electro" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="code_adm" value="<?=$code_adm?>">
                    <input type="hidden" name="object_name" value="<?=$object_name?>">
                    <input type="hidden" name="monthFrom" value="<?=$monthFrom?>">
                    <input type="hidden" name="monthTo" value="<?=$monthTo?>">
                    <button title="Excel" class="btn excel-btn" type="submit">&#128196</button>
                </form>
            </th>
        </tr>
    </thead>
    <tbody id='table-body'>
        <?php
        /*
            foreach($datas as $key => $data) {
                if(is_null($data['udel']) || $data['udel'] == 0) {
                    continue;
                }
                ?>
                <tr>
                    <td><?=$data['rues']?></td>
                    <td><?=$data['object_name']?></td>
                    <td class="text-center"><?=$data['value_cnt']?></td>
                    <td class="text-center"><?=$data['used']?></td>
                    <td class="text-center"><?=round($data['usedkvt'],3)?></td>
                    <td colspan="2" class="text-center"><?=round($data['udel'],3)?></td>
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
            let used = data[i].used;
            let usedkvt = data[i].usedKvt;
            let udel = data[i].udel;
            let row = `
                <tr>
                    <td>${rues}</td>
                    <td>${object_name}</td>
                    <td class="text-center">${counter}</td>
                    <td class="text-center">${used}</td>
                    <td class="text-center">${usedkvt}</td>
                    <td class="text-center" colspan='2'>${udel}</td>
                <tr/>
                `;
            table.innerHTML += row;
        }
    }

    buildTable(arr);
</script>