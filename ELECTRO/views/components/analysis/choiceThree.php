<h2 class="text-center analis-name">Арендуемые объекты</h2>
<table class="table table-striped device-table">
    <thead>
        <tr>
            <th class="align-middle" style="font-size: .8rem;">УЭС, ЗУЭС</th>
            <th class="align-middle" style="font-size: .8rem;">Название объекта</th>
            <th class="align-middle" style="font-size: .8rem;">Адрес объекта аренды</th>
            <th class="align-middle" style="font-size: .8rem;">Арендодатель</th>
            <th class="align-middle" style="font-size: .8rem;">Номер договора</th>
            <th class="align-middle" style="font-size: .8rem;">Дата начала действия договора</th>
            <th class="align-middle" style="font-size: .8rem;">Дата окончания действия договора</th>
            <th class="align-middle" style="font-size: .8rem;">Площадь (кв.м.)</th>
            <th class="align-middle" style="font-size: .8rem;">Арендная плата (руб.)</th>
            <th>
                <form action="./excel/analisArenda" method="post" enctype="multipart/form-data">  
                    <input type="hidden" name="sort" value="<?=$sort?>">                  
                    <button title="Excel" class="btn excel-btn" type="submit">&#128196</button>
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