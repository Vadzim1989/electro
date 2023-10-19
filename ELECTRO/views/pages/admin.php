<?php
use App\Services\Page;
use App\Services\Router;

require_once('vendor/db.php');

if($_SESSION["user"]["group"] != 2) {
    Router::redirect('/');
}
$datas = [];
?>

<!DOCTYPE html>
<html lang="en">
<?php Page::part('head'); ?>

<style>
    .drop_pass,
    .delete_user {
        border-radius: 5px;
    }
    .drop_pass:hover {
        background-color: #42f58a;
        transform: scale(1.2);
        transition: all .5s ease-in-out;
    }

    .delete_user:hover {
        background-color: red;
        transform: scale(1.2);
        transition: all .5s ease-in-out;
    }
</style>

<script type="text/javascript">
    function dropPass() {
        alert("Пароль сброшен!");
    }
    function deleteUser() {
        alert("Пользователь удален!");
    }
</script>

<body>
    <?php Page::part('navbar'); ?>

    <div class="container">
        <div class="p-5 mb-4 mt-4 bg-light rounded-3">
            <div class="container-fluid">
                <h1 class="display fw-bold">Добавить пользователя</h1>
            </div>
        </div>
        <form class="mt-4" action="./auth/register" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="login" class="form-label">Логин</label>
                <input type="text" name="login" class="form-control" id="login">
            </div>
            <div class="mb-3">
                <label for="full_name" class="form-label">ФИО</label>
                <input type="text" name="full_name" class="form-control" id="full_name">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" name="password" class="form-control" id="password">
            </div>
            <div class="mb-3">
                <label for="group" class="form-label">Роль</label>
                <select name="group" id="group" class="form-control">
                    <option value="1">Пользователь</option>
                    <option value="2">Админ</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Добавить</button>
        </form>

        <div class="p-5 mb-4 mt-4 bg-light rounded-3">
            <div class="container-fluid">
                <h1 class="fw-bold">Пользователи</h1>
            </div>
        </div>

        <table class="table table-striped">
           <thead>
                <tr>
                    <th>Логин</th>
                    <th>ФИО</th>
                    <th>Роль</th>
                    <th class="text-center">Сброс пароля</th>
                    <th class="text-center">Удалить пользователя</th>
                    <th class="text-center">Правки</th>
                </tr>
           </thead> 
           <tbody>
           <?php 
                $query = mysqli_query($db, 'SELECT `id`, `login`, `full_name`, `group` FROM `users`');
                while($row = mysqli_fetch_assoc($query)) {
                    $datas[] = $row;
                }
                mysqli_close($db);
                foreach ($datas as $key => $data) {
                    # code...
                    ?>
                        <tr>
                            <td class="align-middle"><?= $data["login"] ?></td>
                            <td class="align-middle"><?= $data["full_name"] ?></td>
                            <td class="align-middle"><?php if ($data["group"] == 1) echo "Пользователь"; else echo "Админ";?></td>
                            <td class="text-center">
                                <form class="mt-1 mb-1" action="./auth/update" method="post">
                                    <input type="hidden" name="id" value="<?= $data['id'] ?>">
                                    <button type="submit" class="drop_pass" onclick="dropPass()">&#10003</button>
                                </form>
                            </td>
                            <td class="text-center">
                                <form class="mt-1 mb-1" action="./auth/delete" method="post">
                                    <input type="hidden" name="id" value="<?= $data['id'] ?>">
                                    <button type="submit" class="delete_user" onclick="deleteUser()">&#10007</button>
                                </form>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#updateUserInfo" id="<?=$data['id']?>" name="<?=$data['full_name']?>" login="<?=$data['login']?>">&#128396</button>
                            </td>
                        </tr>
                    <?php
                }
                ?>
           </tbody>
        </table>
    </div>
    <?php
        require_once('views/modal/modalForAdmin.php');
    ?>
</body>
</html>

