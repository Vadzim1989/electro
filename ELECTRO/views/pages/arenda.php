<?php
use App\Services\Page;
use App\Services\Router;

if(!$_SESSION['user']) {
    Router::redirect('/');
}

$id_contract = $_GET["idc"];
$id_object = $_GET["ido"];
$code_adm = $_GET['cda'];
require('vendor/db.php');
$contract = mysqli_query($db, "SELECT * FROM `contracts` WHERE `id_contract` = '$id_contract'");
$contract = mysqli_fetch_assoc($contract);
?>

<!DOCTYPE html>
<html lang="en">
<?php Page::part('head'); 
?>

<style>
    textarea {
        resize: none;
    }
</style>

<body>
    <?php Page::part('navbar'); ?>
    <div class="container">
        <div class="p-3 mb-4 mt-4 bg-light rounded-3">
            <div class="container-fluid d-flex flex-row justify-content-between">
                <h1 class="display-5 fw-bold">Информация по аренде</h1>
                <form class="deleteForm" action="./contract/delete" method="post" enctype="multipart/form-data">
                    <input type="hidden" class="id_contract" name="id_contract" id="id_contract" value="<?=$id_contract?>">
                    <input type="hidden" class="id_contract" name="object_id" id="object_id" value="<?=$id_object?>">
                    <button type="submit" class="btn btn-danger">Удалить</button>
                </form>
            </div>
        </div>
        <form class="mt-4" action="./contract/update" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_contract" value="<?=$contract['id_contract']?>">
            <input type="hidden" name="object_id" value="<?=$id_object?>">
            <p class="form-label">Название объекта</p>
            <div class="form-floating">
                <select name="id_object" id="id_object" class="form-select mb-3">
                    <option value="" selected></option>
                    <?php
                        if($id_object){
                            $datas = \R::getAll("SELECT `id_object`, `object_name` FROM `object` WHERE `code_adm` = '$code_adm' ORDER BY `object_name`");
                            foreach($datas as $key => $data) {
                                ?>
                                <option value="<?=$data['id_object']?>" <?php if($data['id_object'] === $id_object) echo "selected"?>><?=$data['object_name']?></option>
                                <?php
                            }
                        } else {
                            $datas = \R::getAll("SELECT `id_object`, `object_name` FROM `object` ORDER BY `object_name`");
                            foreach($datas as $key => $data) {
                                ?>
                                <option value="<?=$data['id_object']?>"><?=$data['object_name']?></option>
                                <?php
                            }
                        }
                    ?>
                </select>
                <label for="id_object">ВЫБЕРИТЕ ОБЪЕКТ К КОТОРОМУ ОТНОСИТСЯ ДОГОВОР</label>
            </div>
            <div class="mb-3">
                <label for="landlord" class="form-label">Арендодатель</label>
                <textarea name="landlord" class="form-control" id="landlord" value="<?=$contract['landlord']?>"><?=$contract['landlord']?></textarea>
            </div>
            <div class="mb-3">
                <label for="unp" class="form-label">УНП</label>
                <input type="text" class="form-control" name="unp" id="unp" value="<?=$contract['unp']?>">
            </div>
            <div class="mb-3">
                <label for="landlord_address" class="form-label">Юридический адрес и контакты арендодателя</label>
                <input type="text" class="form-control" name="landlord_address" id="landlord_address" value="<?=$contract['landlord_address']?>">
            </div>
            <div class="mb-3">
                <label for="object" class="form-label">Объект</label>
                <input type="text" class="form-control" name="object" id="object" value="<?=$contract['object']?>">
            </div>
            <div class="mb-3">
                <label for="equip_address" class="form-label">Местонахождение имущества (адрес, здание, учреждение)</label>
                <input type="text" class="form-control" name="equip_address" id="equip_address" value="<?=$contract['equip_address']?>">
            </div>
            <div class="mb-3">
                <label for="contract_num" class="form-label">Номер договора</label>
                <input type="text" class="form-control" name="contract_num" id="contract_num" value="<?=$contract['contract_num']?>">
            </div>
            <div class="mb-3">
                <label for="contract_start" class="form-label">Срок действия договора (начало)</label>
                <input type="text" class="form-control" name="contract_start" id="contract_start" value="<?=$contract['contract_start']?>">
            </div>
            <div class="mb-3">
                <label for="contract_end" class="form-label">Срок действия договора (окончание)</label>
                <input type="text" class="form-control" name="contract_end" id="contract_end" value="<?=$contract['contract_end']?>">
            </div>
            <div class="mb-3">
                <label for="landlord_area" class="form-label">Арендуемая площадь, м.кв.</label>
                <input type="text" class="form-control" name="landlord_area" id="landlord_area" value="<?=$contract['landlord_area']?>">
            </div>
            <div class="mb-3">
                <label for="wall" class="form-label">Стены, асфальт</label>
                <input type="text" class="form-control" name="wall" id="wall" value="<?=$contract['wall']?>">
            </div>
            <div class="mb-3">
                <label for="length" class="form-label">Протяженность, км</label>
                <input type="text" class="form-control" name="length" id="length" value="<?=$contract['length']?>">
            </div>
            <div class="mb-3">
                <label for="bav" class="form-label">Арендная плата, БАВ</label>
                <input type="text" class="form-control" name="bav" id="bav" value="<?=$contract['bav']?>">
            </div>
            <div class="mb-3">
                <label for="byn" class="form-label">Арендная плата, руб</label>
                <input type="text" class="form-control" name="byn" id="byn" value="<?=$contract['byn']?>">
            </div>
            <div class="mb-3">
                <label for="nds" class="form-label">НДС, %</label>
                <input type="text" class="form-control" name="nds" id="nds" value="<?=$contract['nds']?>">
            </div>
            <div class="mb-3">
                <label for="pay_attribute" class="form-label">Сроки оплаты (признак)</label>
                <input type="text" class="form-control" name="pay_attribute" id="pay_attribute" value="<?=$contract['pay_attribute']?>">
            </div>
            <div class="mb-3">
                <label for="pay_date" class="form-label">Сроки оплаты (срок)</label>
                <input type="text" class="form-control" name="pay_date" id="pay_date" value="<?=$contract['pay_date']?>">
            </div>
            <div class="mb-3">
                <label for="comments" class="form-label">Примечания</label>
                <input type="text" class="form-control" name="comments" id="comments" value="<?=$contract['comments']?>">
            </div>
            <div class="mb-3">
                <label for="area" class="form-label">Общая площадь здания/норм, м.кв.</label>
                <input type="text" class="form-control" name="area" id="area" value="<?=$contract['area']?>">
            </div>
            <div class="mb-3">
                <label for="part" class="form-label">Доля, %</label>
                <input type="text" class="form-control" name="part" id="part" value="<?=$contract['part']?>">
            </div>
            <input type="hidden" name="old_id" value="<?=$id_object?>">
            <button type="submit" class="btn btn-primary mb-3">Сохранить</button>          
            <a href="/ELECTRO/contracts" class="btn btn-secondary mb-3">Закрыть</a>
        </form>
    </div>
</body>



</html>


<script src="http://electro.gmltelecom.int/libs/select2/select2.min.js"></script>
<script>
    $("#id_object").select2({
        placeholder: "ВЫБЕРИТЕ ОБЪЕКТ К КОТОРОМУ ОТНОСИТСЯ ДОГОВОР",
        allowClear: true
    });
</script>