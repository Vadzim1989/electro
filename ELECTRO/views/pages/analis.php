<?php
use App\Services\Page;
use App\Services\Router;
require_once('vendor/db.php');
if (!isset($_SESSION['user'])) {
    Router::redirect('/');
}
?>
<!DOCTYPE html>
<html lang="en">
<?php Page::part('head'); 
?>

<style>
    a {
        text-decoration: none;
    }
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
        background: rgba(0, 100, 0, .2);
    }
    .form-analis {
        margin-block-end: 0;
    }
    .shadow_not_news {
        border-radius: 50%;
    }
    .text-analis {
        text-align: left;
    }
</style>

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
                    <td class="align-middle text-analis">
                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#filterAnaliz">Удельное потребление эл.энергии на монтированный порт</button>
                    </td>
                </tr>
                <tr>
                    <td class="align-middle check_analis">&#10004</td>
                    <td class="align-middle text-analis">
                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#filterAnalizWarm">Удельное потребление тепловой энергии на кв.метр занимаемой площади</button>
                    </td>
                </tr>
                <tr>
                    <td class="align-middle check_analis">&#10004</td>
                    <td class="align-middle text-analis">
                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#filterAnalizProc">Расхождение показаний по электроэнергии</button>
                    </td>
                </tr>
                <tr>
                    <td class="align-middle check_analis">&#10004</td>
                    <td class="align-middle text-analis">
                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#filterAnalizArenda">Арендуемые объекты</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php 
        include('views/modal/modalForNavbar.php');
        include('views/modal/modalForAnalis.php');
    ?>
</body>
                            

</html>