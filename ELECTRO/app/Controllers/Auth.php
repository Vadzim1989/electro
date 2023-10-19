<?php 

namespace App\Controllers;

use App\Services\Router;
use mysqli;

class Auth {

    public function login($data) 
    {
        require_once('vendor/db.php');

        $login = $data['login'];
        $password = $data['password'];

        $user = mysqli_query($db, "SELECT * FROM `users` WHERE `login` = '$login'");
        $user = mysqli_fetch_assoc($user);
        mysqli_close($db);

        if(!$user) {
            Router::redirect('/login');
        }

        if(password_verify($password, $user['password']) || $password == $user['password']) {
            session_start();
            $_SESSION["user"] = [
                "id" => $user['id'],
                "full_name" => $user['full_name'],
                "group" => $user['group'],
                "login" => $user['login'],
                "counter" => false
            ];
            Router::redirect('/');
        } else {
            Router::redirect_wrong('/login');
        }
    }

    public function register($data) 
    {
        require_once('vendor/db.php');

        $login = $data['login'];
        $full_name = $data['full_name'];
        $password = $data['password'];
        $group = is_null($data['group']) ? 1 : $data['group'];

        $password = password_hash($password, PASSWORD_DEFAULT);

        $checkLogin = mysqli_query($db, "SELECT `login` FROM `users` WHERE `login` = '$login'");
        $checkLogin = mysqli_fetch_assoc($checkLogin);

        if(isset($checkLogin['login']) && $checkLogin['login'] == $login) {
            mysqli_close($db);
            echo "<script>alert('Пользователь с таким логинов уже существует'); window.location.href = '/admin'</script>";
        } else {
            mysqli_query($db, "INSERT INTO `users`(`id`, `login`, `full_name`, `password`, `group`) VALUES(NULL, '$login', '$full_name', '$password', '$group')");
            mysqli_close($db);
            Router::redirect('/admin');
        }
        
        

        
    }

    public function userInfo($data) {
        require_once('vendor/db.php');

        $id = $data['id'];
        $name = $data['name'];
        $login = $data['login'];

        mysqli_query($db, "UPDATE `users` SET `full_name` = '$name', `login` = '$login' WHERE `id` = '$id'");
        mysqli_close($db);

        Router::redirect('/admin');
    }

    public function update($data)
    {
        require_once('vendor/db.php');

        $id = $data["id"];
        $password = password_hash(111111, PASSWORD_DEFAULT);

        mysqli_query($db, "UPDATE `users` SET `password` = '$password' WHERE `id` = '$id'");
        mysqli_close($db);

        Router::redirect('/admin');
    }

    public function delete($data) 
    {
        require_once('vendor/db.php');

        $id = $data['id'];

        mysqli_query($db, "DELETE FROM `users` WHERE `id` = '$id'");
        mysqli_close($db);

        Router::redirect('/admin');
    }

    public function userUpdate($data)
    {
        require_once('vendor/db.php');

        $id = $data["id"];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        mysqli_query($db, "UPDATE `users` SET `password` = '$password' WHERE `id` = '$id'");
        mysqli_close($db);
        
        Router::redirect('/login');
    }

    public function logout() 
    {
        unset($_SESSION["user"]);
        Router::redirect('/login');
    }
}