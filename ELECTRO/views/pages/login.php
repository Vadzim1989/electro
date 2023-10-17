<?php 
session_start();
use App\Services\Page;
if(isset($_SESSION["user"])) {
    \App\Services\Router::redirect('/');
}
?>

<!DOCTYPE html>
<html lang="en">
<?php Page::part('head'); ?>
<body>
    <?php Page::part('navbar'); ?>

    <div class="container">
        <h2 class="mt-4">Вход в систему</h2>
        <form class="mt-4" method="post" action="./auth/login">
            <div class="mb-3">
                <label for="login" class="form-label">Логин</label>
                <input type="text" class="form-control" id="login" aria-describedby="emailHelp" name="login">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-primary" onclick="load()">Войти</button>
        </form>
    </div>
</body>

</html>