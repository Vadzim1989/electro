<h2 class="text-center analis-name">Арендуемые объекты</h2>
<table class="table table-striped device-table">
    <thead>
        <tr>
            <th>УЭС, ЗУЭС</th>
            <th>Название объекта</th>
            <th>Адрес объекта аренды</th>
            <th>Арендодатель</th>
            <th>Номер договора</th>
            <th>Дата начала действия договора</th>
            <th>Дата окончания действия договора</th>
            <th>Площадь (кв.м.)</th>
            <th>Арендная плата (руб.)</th>
            <th>
                <form action="./excel/analisArenda" method="post" enctype="multipart/form-data">                    
                    <button title="Excel" class="btn" type="submit">&#128196</button>
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
                    <td><?=$data['equip_address']?></td>
                    <td><?=$data['landlord']?></td>
                    <td><?=$data['contract_num']?></td>
                    <td><?=$data['contract_start']?></td>
                    <td><?=$data['contract_end']?></td>
                    <td><?=$data['landlord_area']?></td>
                    <td colspan="2" class="text-center"><?=$data['byn']?></td>
                </tr>
                <?php
            }
        ?>
    </tbody>
</table>