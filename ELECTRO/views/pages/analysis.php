<?php
use App\Services\Page;
use App\Services\Router;
require_once('vendor/db.php');
if (!isset($_SESSION['user'])) {
    Router::redirect('/');
}
?>

<style>
    .analiz{
        padding: 5rem;
    }
    .analiz-table {
        max-width: 45rem;
        margin: auto;
    }
    .check_analis {
        text-align: center;
    }
    tr:hover > .check_analis {
        background: greenyellow;
    }
    .form-analis {
        margin-block-end: 0;
    }
</style>

<!DOCTYPE html>
<html lang="en">
<?php Page::part('head');?>
<body>
    <?php Page::part('navbar'); ?>
    <div class="container text-center analiz">
        <table class="table table-striped analiz-table">
            <thead>
                <tr class="text-center">
                    <th colspan="2">Анализ данных</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="align-middle check_analis">&#10004</td>
                    <td class="align-middle">
                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#filterAnaliz">Удельное потребление эл.энергии на монтированный порт</button>
                    </td>
                </tr>
                <!--
                <tr>
                    <td class="align-middle check_analis">&#10004</td>
                    <td class="align-middle">
                        <button type="button" class="btn">Удельное потребление тепловой энергии на кв.метр занимаемой площади</button>
                    </td>
                </tr>
-->
                <tr>
                    <td class="align-middle check_analis">&#10004</td>
                    <td class="align-middle">
                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#filterAnalizProc">Расхождение показаний по электроэнергии</button>
                    </td>
                </tr>
                <tr>
                    <td class="align-middle check_analis">&#10004</td>
                    <td class="align-middle">
                        <form class="align-middle form-analis" action="./analisData" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="choice" value="3">
                            <button type="submit" class="btn">Арендуемые объекты</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php 
        Page::part('navbarModal');    
        Page::part('analysisModal');    
    ?>
</body>
</html>