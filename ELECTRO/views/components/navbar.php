<?php
use App\Services\Page;
require('vendor/db.php');
$date = mysqli_query($db, "SELECT `date` FROM `news`");
$date = mysqli_fetch_assoc($date);
$date = $date['date'];
$dateDiff = date_diff(new DateTime(), new DateTime($date)) -> days;
?>

<script>
    function load() {    
        let loader = document.querySelector('.load');
        loader.textContent = "Загрузка страницы...";    
        setTimeout(n = 5000,()=> {
            loader.textContent = "";
        }, 5000000 * n)
    }
    
    // "Show the dialog" button opens the dialog modally
    function showModalCounter() {
        const dialog = document.querySelector("dialog");
        dialog.showModal();
        setTimeout(n = 5000,()=> {
            dialog.close() = "";
        }, 5000000 * n)
    }

    function infoFocus() {
        const btn = document.querySelector('.info-down');
        btn.innerHTML = "&#128195";
    }
    function infoUnFocus() {
        const btn = document.querySelector('.info-down');
        btn.innerHTML = "&#10068";
    }
</script>

<style>    
    thead {
        position: sticky;
        top: 5.5rem;
        background-color: #e3e3e3;
    }
    .text {
        text-decoration: none;
        font-weight: bold;
        color: #893a70;
    }

    .add_object:hover {
        transform: scale(1.1);
        transition: all .5s ease-in-out;
    }
    
    #search {
        width: 25rem;
    }

    /* The container <div> - needed to position the dropdown content */
    .dropdownMenu {
    position: relative;
    display: inline-block;
    }

    /* Dropdown Content (Hidden by Default) */
    .dropdownContent {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    }

    /* Links inside the dropdown */
    .dropdownContent a {
    color: black;
    margin-left: 0;
    padding: 10px 10px;
    text-decoration: none;
    display: block;
    }

    @keyframes blur {
        from {
            text-shadow:0px 0px 10px #f09089,
            0px 0px 10px #f09089, 
            0px 0px 25px #f09089,
            0px 0px 25px #f09089
        }
    }

    .load{
        text-transform: uppercase;
        animation: blur .75s ease-out infinite;
        text-shadow: 0px 0px 5px #f09089, 0px 0px 7px #f09089;
    }

    /* Change color of dropdown links on hover */
    .dropdownContent a:hover {background-color: #ddd;}

    /* Show the dropdown menu on hover */
    .dropdownMenu:hover .dropdownContent {display: block;}

    @media screen and (max-width: 1920px) {
        .dropdownContent > a.nav-link {
            font-size: .75rem;
            margin: 0;
            padding: 3px;
        }

        .nav-link, .btn {
            font-size: .75rem;
        }

        .table.table-striped > thead > tr > th,
        .table.table-striped > tbody > tr > td,
        .table.table-striped > tfoot > tr > td {
            font-size: .6rem;
        }
        .xml-loader{
            display: flex;
            flex-direction: row;
        }
    }

</style>

<nav class="navbar navbar-expand-lg navbar-light sticky-top" style="background-color: #e3f2fd;">
    <div class="container-fluid">
        <a class="navbar-brand" href="/ELECTRO/">&#128161 elec.</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <div class="navbar-nav">
                <a class="nav-link active" aria-current="page" href="/ELECTRO/" onclick="load()">Главная</a>
                <div class="dropdownMenu">
                    <a class="add_object nav-link active ms-3" aria-current="page" >Выбрать район</a>
                    <?php
                    if(isset($_SESSION["user"])) {
                        switch($_SESSION['user']['zues']){
                            case 'all':
                                include('views/components/navbardropdown/all.php');
                                break;
                            case 'gomelzues':
                                include('views/components/navbardropdown/gomelzues.php');
                                break;
                            case 'jlobin':
                                include('views/components/navbardropdown/jlobinzues.php');
                                break;
                            case 'kalin':
                                include('views/components/navbardropdown/kalinzues.php');
                                break;
                            case 'mozir':
                                include('views/components/navbardropdown/mozirzues.php');
                                break;
                            case 'rech':
                                include('views/components/navbardropdown/rechzues.php');
                                break;
                            default:
                                break;
                        }
                        ?>
                </div>                
                <a class="nav-link active ms-4 add_object" aria-current="page" href="/ELECTRO/add"><span class="text">Добавить объект</span></a>
                
                <form class="ms-3" action="/ELECTRO/search" method="post" enctype="multipart/form-data">
                    <input type="text" name="search" id="search" placeholder="Поиск по названию объекта...">
                    <button type="submit" class="btn btn-outline-primary mb-1">&#128269</button>
                </form>
                
                <button type="button" title="Загрузить XML" class="btn btn-outline-primary ms-3" data-bs-toggle="modal" data-bs-target="#addXML">XML</button>
                <a class="nav-link active ms-4 add_object" aria-current="page" href="/ELECTRO/analysis">Анализ</a>    
                <p class="text-center load ms-5 fw-bold" style="color: red;"></p>   
                <dialog>
                    <p>Идет опрос счетчиков...</p>
                </dialog>  
                <?php                       
                    }
                ?>
                
            </div>
        </div>
        
        <div class="d-flex">
        <?php 
            if(!isset($_SESSION["user"])) {
                ?>
                    <a class="nav-link m-4" href="/ELECTRO/login">Войти</a>
                <?php
            } else {
                if($_SESSION["user"]["group"] == 2) {
                    ?>
                    <a class="nav-link m-4" href="/ELECTRO/admin" style="color: #0dcaf0;"><b>Добавить пользователя</b></a>
                    <?php
                }?>
                <?php if($_SESSION["user"]) {
                    ?>
                    <form action="./getFile" method="post">
                        <button type="submit" title="Инструкция" class="btn mt-3 info-down" onmouseover="infoFocus()" onmouseleave="infoUnFocus()">&#10068</button>
                    </form>
                    <?php
                    if($dateDiff <= 3) {
                        echo '<button type="submit" class="btn btn-success m-3" data-bs-toggle="modal" data-bs-target="#news">&#128365</button>';
                    } else {
                        echo '<button type="submit" class="btn btn-outline-primary m-3" data-bs-toggle="modal" data-bs-target="#news">&#128365</button>';
                    }
                    ?>                    
                    <a class="nav-link active m-4 add_object" aria-current="page" href="/ELECTRO/contracts"><span class="text">Договора аренды</span></a>
                    <a class="nav-link m-4" href="/ELECTRO/profile">Личный кабинет</a>
                    <?php
                }?>                    
                    <form action="./auth/logout" method="post">
                        <button type="submit" class="btn btn-danger m-3">Выйти</button>
                    </form>
                <?php
            }
        ?>        
        </div>
    </div>
</nav>