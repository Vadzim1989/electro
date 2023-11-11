<?php
require('vendor/db.php');
$date = mysqli_query($db, "SELECT `date` FROM `news`");
$date = mysqli_fetch_assoc($date);
$date = $date['date'];
$dateDiff = date_diff(new DateTime(), new DateTime($date)) -> days;
?>

<script>
    function load() {    
        let loader = document.querySelector('.load');
        loader.textContent = "Загрузка...";    
        setTimeout(n = 5000,()=> {
            loader.textContent = "";
        }, 5000000 * n)
    }
    function deleteDataFromArendaCounter() {
        const form = document.querySelector('.deleteForm');
        form.addEventListener('submit', function(event) {
            let answer = confirm('Вы действительно хотите удалить данные?');
            if(!answer) {
                event.preventDefault();
            }
        })
    } 
    function showModalCounter() {
        const dialog = document.querySelector("dialog");
        let loader = document.querySelector('.load');
        loader.textContent = "Загрузка..."; 
        dialog.showModal();
        setTimeout(n = 5000,()=> {
            dialog.close() = "";
            loader.textContent = "";
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
        top: 5.1rem;
        background-color: #e3e3e3;
    }
    .text {
        text-decoration: none;
        font-weight: bold;
        color: #893a70;
    }
    .text-analis {
        text-decoration: none;
        font-weight: bold;
        color: green;
    }
    .values {
        font-weight: 500;
        font-size: .8rem;
        margin: 0;
        padding: 0;
    }
    .profile {
        font-weight: bold;
    }
    .add_object:hover,
    .profile:hover,
    .info-down:hover {
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

    .shadow_news {
        box-shadow: 0 0rem 2rem green, 0 0rem 2rem green;
        border-radius: 50%;
    }
    .shadow_news:hover {
        color: yellow;
        font-weight: bold;
        box-shadow: 0 0rem 3rem green, 0 0 3rem yellow;        
        animation: lr .3s infinite;
        transition: all .1s ease-in-out;
    }

    .shadow_not_news {
        border-radius: 50%;
    }

    .arenda-code-adm {
        font-weight: 700;
    }

    @keyframes lr{
        0% {
            transform:rotate(45deg);
        }
        25% {
            transform:rotate(50deg);
        }
        75% {
            transform:rotate(40deg);
        }
        100% {
            transform:rotate(45deg);
        }
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

    .counter-load {
        color: hsla(0, 0%, 0%, .9);
        left: 0;
        font-weight: bold;
        text-align: center;
        text-transform: uppercase;
        animation: pulsate 1.2s infinite linear  
    }

    @keyframes pulsate{
        50%{
            color:#fff;
            text-shadow:0 -1px rgba(0,0,0,.3),0 0 5px #f03000,0 0 8px #f80000;
        }
    }

    /* Links inside the dropdown */
    .dropdownContent a {
    color: black;
    margin-left: 0;
    padding: 10px 10px;
    text-decoration: none;
    display: block;
    }

    .lightIconWrapper:hover {
        text-shadow: 3px 3px .2rem grey;
        transition: all .1s ease-in-out;
    }

    .lightIconWrapper:hover > span.lightIcon {
        text-shadow: 0 0 1.1rem yellow, 0 0 1.1rem white, 0 0 1.1rem yellow;
        opacity: 0.7;
        transition: all .1s ease-in-out;
    }

    .object_name{
        max-width: 33.779rem;
    }
    .object_rues {
        max-width: 13.003rem;
    }
    .object_address,
    .object_name {        
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 12rem;
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

        body,
        input::placeholder,
        .nav-link, .btn {
            font-size: .75rem;
        }

        .table.table-striped > thead > tr > th,
        .table.table-striped > tbody > tr > td,
        .table.table-striped > tfoot > tr > td {
            font-size: .6rem;
        }
    }

</style>

<nav class="navbar navbar-expand-lg navbar-light sticky-top" style="background-color: #e3f2fd;">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <div class="navbar-nav">
                <a class="nav-link active lightIconWrapper" aria-current="page" href="./" onclick="load()"><span class="lightIcon">&#128161</span> Главная</a>
                <?php
                    if(isset($_SESSION["user"])) {
                        ?>
                        <div class="dropdownMenu">
                            <a class="add_object nav-link active ms-3" aria-current="page" >Выбрать район</a>
                            <div class="dropdownContent">
                                <a class="nav-link active" aria-current="page" href="./rues?id=20" onclick="load()">Гомель</a>
                                <a class="nav-link active" aria-current="page" href="./rues?id=30" onclick="load()">Ветка</a>
                                <a class="nav-link active" aria-current="page" href="./rues?id=32" onclick="load()">Чечерск</a>
                                <a class="nav-link active" aria-current="page" href="./rues?id=33" onclick="load()">Добруш</a>
                                <a class="nav-link active" aria-current="page" href="./rues?id=34" onclick="load()">Жлобин</a>
                                <a class="nav-link active" aria-current="page" href="./rues?id=36" onclick="load()">Буда_Кошелево</a>
                                <a class="nav-link active" aria-current="page" href="./rues?id=37" onclick="load()">Корма</a>
                                <a class="nav-link active" aria-current="page" href="./rues?id=39" onclick="load()">Рогачев</a>
                                <a class="nav-link active" aria-current="page" href="./rues?id=40" onclick="load()">Речица</a>
                                <a class="nav-link active" aria-current="page" href="./rues?id=42" onclick="load()">Светлогорск</a>
                                <a class="nav-link active" aria-current="page" href="./rues?id=44" onclick="load()">Брагин</a>
                                <a class="nav-link active" aria-current="page" href="./rues?id=45" onclick="load()">Калинковичи</a>
                                <a class="nav-link active" aria-current="page" href="./rues?id=46" onclick="load()">Хойники</a>
                                <a class="nav-link active" aria-current="page" href="./rues?id=47" onclick="load()">Лоев</a>
                                <a class="nav-link active" aria-current="page" href="./rues?id=50" onclick="load()">Петриков</a>
                                <a class="nav-link active" aria-current="page" href="./rues?id=51" onclick="load()">Мозырь</a>
                                <a class="nav-link active" aria-current="page" href="./rues?id=53" onclick="load()">Житковичи</a>
                                <a class="nav-link active" aria-current="page" href="./rues?id=54" onclick="load()">Ельск</a>
                                <a class="nav-link active" aria-current="page" href="./rues?id=55" onclick="load()">Наровля</a>
                                <a class="nav-link active" aria-current="page" href="./rues?id=56" onclick="load()">Лельчицы</a>
                                <a class="nav-link active" aria-current="page" href="./rues?id=57" onclick="load()">Октябрьский</a>
                                <a class="nav-link active" aria-current="page" href="./rues?id=79" onclick="load()">Гомельские РУЭС</a>
                            </div>
                        </div>
                        <a class="nav-link active ms-4 add_object" aria-current="page" href="./contracts" onclick="load()"><span class="text">Договора аренды</span></a>                   
                        <a class="nav-link active ms-4 add_object analysis" aria-current="page" href="./analis" onclick="load()"><span class="text-analis">&#128202 Анализ данных</span></a>                   
                        <?php
                    }
                ?>
                <a class="nav-link active text-right load ms-5 fw-bold" style="color: red;"></a>
                <dialog class="align-middle">
                    <p class="counter-load pt-3">Идет опрос счетчиков...</p>
                </dialog> 
            </div>
        </div>
        
        <div class="d-flex">
        <?php 
            if(!isset($_SESSION["user"])) {
                ?>
                    <a class="nav-link m-4" href="/login">Войти</a>
                <?php
            } else {
                ?>
                    <form action="./info" method="post">
                        <button type="submit" title="Инструкция" class="btn mt-3 info-down" onmouseover="infoFocus()" onmouseleave="infoUnFocus()">&#10068</button>
                    </form>
                <?php
                if($dateDiff < 3) {
                    echo '<button type="submit" title="Уведомления" class="btn btn-success shadow_news m-3" data-bs-toggle="modal" data-bs-target="#news">&#128365</button>';
                } else {
                    echo '<button type="submit" title="Уведомления" class="btn btn-outline-secondary shadow_not_news m-3" data-bs-toggle="modal" data-bs-target="#news">&#128365</button>';
                }
                ?>
                <?php
                if($_SESSION["user"]["group"] == 2) {
                    ?>
                    <a class="nav-link m-4" href="./admin" style="color: #0dcaf0;"><b>Добавить пользователя</b></a>
                    <?php
                }?>
                <?php if($_SESSION["user"]) {
                    ?>
                    <a class="nav-link m-4 profile" href="./profile"><?=$_SESSION['user']['full_name']?> &#128100</a>
                    <?php
                }?>                    
                    <form action="/auth/logout" method="post">
                        <button type="submit" class="btn btn-danger m-3">Выйти</button>
                    </form>
                <?php
            }
        ?>        
        </div>
    </div>
</nav>