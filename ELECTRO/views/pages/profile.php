<?php
use App\Services\Page;
use App\Services\Router;

//session_start();

if(!$_SESSION["user"]) {
    Router::redirect('/');
}

$id = $_SESSION['user']['id'];
$full_name = $_SESSION['user']['full_name'];

?>

<!DOCTYPE html>
<html lang="en">
<?php Page::part('head'); ?>

<script type="text/javascript">
    function onClick() {
        alert("Пароль изменен!");
    }
</script>

<body>
    <?php Page::part('navbar'); ?>

    <div class="container">
        <div class="p-5 mb-4 mt-4 bg-light rounded-3">
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold">Личный кабинет</h1>
            </div>
        </div>
        <form class="mt-4" action="./auth/userUpdate" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $id ?>">
            <div class="mb-3">
                <label for="full_name" class="form-label">ФИО</label>
                <input type="text" name="full_name" disabled class="form-control" id="full_name" value="<?= $full_name ?>">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" name="password" class="form-control" id="password">
            </div>
            <button type="submit" class="btn btn-primary" onclick="onClick()">Изменить пароль</button>
        </form>        
    </div>
</body>

</html>