<?php
use App\Services\Page;
use App\Services\Router;
if(!$_SESSION['user']) {
    Router::redirect('/');
}
?>

<!DOCTYPE html>
<html lang="en">
<?php Page::part('head'); 
?>

<body>
    <?php Page::part('navbar'); ?>
    <div class="container">
        <div class="p-3 mb-4 mt-4 bg-light rounded-3">
            <div class="container-fluid d-flex flex-row justify-content-between">
                <h1 class="display-5 fw-bold">Новый договора аренды</h1>
            </div>
        </div>
        <form class="mt-4" action="./contract/add" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="landlord" class="form-label">Арендодатель</label>
                <input type="text" name="landlord" class="form-control" id="landlord">
            </div>
            <div class="mb-3">
                <label for="unp" class="form-label">УНП</label>
                <input type="text" class="form-control" name="unp" id="unp">
            </div>
            <div class="mb-3">
                <label for="landlord_address" class="form-label">Юридический адрес и контакты арендодателя</label>
                <input type="text" class="form-control" name="landlord_address" id="landlord_address">
            </div>
            <div class="mb-3">
                <label for="object" class="form-label">Объект</label>
                <input type="text" class="form-control" name="object" id="object">
            </div>
            <div class="mb-3">
                <label for="equip_address" class="form-label">Местонахождение имущества (адрес, здание, учреждение)</label>
                <input type="text" class="form-control" name="equip_address" id="equip_address">
            </div>
            <div class="mb-3">
                <label for="contract_num" class="form-label">Номер договора</label>
                <input type="text" class="form-control" name="contract_num" id="contract_num">
            </div>
            <div class="mb-3">
                <label for="contract_start" class="form-label">Срок действия договора (начало)</label>
                <input type="text" class="form-control" name="contract_start" id="contract_start">
            </div>
            <div class="mb-3">
                <label for="contract_end" class="form-label">Срок действия договора (окончание)</label>
                <input type="text" class="form-control" name="contract_end" id="contract_end">
            </div>
            <div class="mb-3">
                <label for="landlord_area" class="form-label">Арендуемая площадь, м.кв.</label>
                <input type="text" class="form-control" name="landlord_area" id="landlord_area">
            </div>
            <div class="mb-3">
                <label for="wall" class="form-label">Стены, асфальт</label>
                <input type="text" class="form-control" name="wall" id="wall">
            </div>
            <div class="mb-3">
                <label for="length" class="form-label">Протяженность, км</label>
                <input type="text" class="form-control" name="length" id="length">
            </div>
            <div class="mb-3">
                <label for="bav" class="form-label">Арендная плата, БАВ</label>
                <input type="text" class="form-control" name="bav" id="bav">
            </div>
            <div class="mb-3">
                <label for="byn" class="form-label">Арендная плата, руб</label>
                <input type="text" class="form-control" name="byn" id="byn">
            </div>
            <div class="mb-3">
                <label for="nds" class="form-label">НДС, %</label>
                <input type="text" class="form-control" name="nds" id="nds">
            </div>
            <div class="mb-3">
                <label for="pay_attribute" class="form-label">Сроки оплаты (признак)</label>
                <input type="text" class="form-control" name="pay_attribute" id="pay_attribute">
            </div>
            <div class="mb-3">
                <label for="pay_date" class="form-label">Сроки оплаты (срок)</label>
                <input type="text" class="form-control" name="pay_date" id="pay_date">
            </div>
            <div class="mb-3">
                <label for="comments" class="form-label">Примечания</label>
                <input type="text" class="form-control" name="comments" id="comments">
            </div>
            <div class="mb-3">
                <label for="area" class="form-label">Общая площадь здания/норм, м.кв.</label>
                <input type="text" class="form-control" name="area" id="area">
            </div>
            <div class="mb-3">
                <label for="part" class="form-label">Доля, %</label>
                <input type="text" class="form-control" name="part" id="part">
            </div>
            <button type="submit" class="btn btn-primary mb-3">Добавить</button>          
            <a href="/ELECTRO/contracts" class="btn btn-secondary mb-3">Закрыть</a>
        </form>
    </div>
</body>



</html>