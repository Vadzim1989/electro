<?php
use App\Services\Page;
use App\Services\Router;
if(!$_SESSION['user']) {
    Router::redirect('/');
}
?>

<!DOCTYPE html>
<html lang="en">
<?php Page::part('head'); ?>

<style>
    .drop_pass {
        border-radius: 5px;
    }
    .drop_pass:hover {
        background-color: #42f58a;
        transform: scale(1.2);
        transition: all .5s ease-in-out;
    }
</style>

<script type="text/javascript">
    function dropPass() {
        alert("Пароль сброшен!");
    }
</script>

<body>
    <?php Page::part('navbar'); ?>
    <div class="container">
        <div class="p-5 mb-4 mt-4 bg-light rounded-3">
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold">Добавить объект</h1>
            </div>
        </div>
        <form class="mt-4" action="./object/add" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="code_adm" class="form-label">Район</label>
                <select name="code_adm" id="code_adm" class="form-control">
                    <option value="20">Гомель</option>
                    <option value="30">Ветка</option>
                    <option value="32">Чечерск</option>
                    <option value="33">Добруш</option>
                    <option value="34">Жлобин</option>
                    <option value="36">Буда-Кошелево</option>
                    <option value="37">Корма</option>
                    <option value="39">Рогачев</option>
                    <option value="40">Речица</option>
                    <option value="42">Светлогорск</option>
                    <option value="44">Брагин</option>
                    <option value="45">Калинковичи</option>
                    <option value="46">Хойники</option>
                    <option value="47">Лоев</option>
                    <option value="50">Петриков</option>
                    <option value="51">Мозырь</option>
                    <option value="53">Житковичи</option>
                    <option value="54">Ельск</option>
                    <option value="55">Наровля</option>
                    <option value="56">Лельчицы</option>
                    <option value="57">Октябрьский</option>
                    <option value="79">Гомельский РУЭС</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Название объекта</label>
                <input type="text" name="name" class="form-control" id="name">
            </div>            
            <div class="mb-3">
                <label for="address">Адрес объекта</label>
                <input type="text" class="form-control" id="address" name="address" require>
            </div>
            <div class="mb-3">
                <label for="mount">Монтированая емкость</label>
                <input type="text" class="form-control" id="mount" name="mount" require>
            </div>
            <div class="mb-3">
                <label for="used">Задействованая емкость</label>
                <input type="text" class="form-control" id="used" name="used" require>
            </div>
            <div class="mb-3">
                <label for="power">Расчетная мощность</label>
                <input type="text" class="form-control" id="power" name="power" require>
            </div>
            <button type="submit" class="btn btn-primary">Добавить</button>
            <a href="/" class="btn btn-secondary">Закрыть</a>
        </form>
    </div>
</body>
</html>

