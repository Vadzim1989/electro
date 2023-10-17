<?php 

namespace App\Controllers;

use App\Services\Router;

class Auth {

    public function login($data) 
    {
        $login = $data['login'];
        $password = $data['password'];

        $user = \R::findOne('users', 'login = ?', [$login]);

        if(!$user) {
            Router::redirect('/login');
        }

        if(password_verify($password, $user->password) || $password == $user->password) {
            session_start();
            $_SESSION["user"] = [
                "id" => $user->id,
                "full_name" => $user->full_name,
                "group" => $user->group,
                "login" => $user->login,
                "zues" => $user->zues,
                "counter" => false,
                "contract" => false,
                'data' => true
            ];
            if(date('d')>15) {
                $_SESSION['user']['data'] = false;
            }
            Router::redirect('/');
        } else {
            Router::redirect_wrong('/login');
        }
    }

    public function register($data) 
    {
        $login = $data['login'];
        $full_name = $data['full_name'];
        $password = $data['password'];
        $password_confirm = $data['password_confirm'];
        $group = is_null($data['group']) ? 1 : $data['group'];
        $zues = $data['zues'];

        if($password !== $password_confirm) {
            Router::error(500);
            die();
        }
        $user = \R::dispense('users');
        $user->login = $login;
        $user->full_name = $full_name;
        /**
         * 1 - пользователь
         * 2 - админ
         */
        $user->group = $group;
        $user->zues = $zues;
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        \R::store($user);
        Router::redirect('/admin');
    }

    public function userInfo($data) {
        $id = $data['id'];
        $name = $data['name'];
        $login = $data['login'];
        $code_adm = $data['code_adm'];

        $user = \R::load('users', $id);
        $user->full_name = $name;
        $user->login = $login;
        $user->zues = $code_adm;

        \R::store($user);
        Router::redirect('/admin');
    }

    public function update($data)
    {
        $id = $data["id"];
        $user = \R::load('users', $id);
        $user->password = password_hash(111111, PASSWORD_DEFAULT);
        \R::store($user);
        Router::redirect('/admin');
    }

    public function userUpdate($data)
    {
        $id = $data["id"];
        $user = \R::load('users', $id);
        $user->password = password_hash(111111, PASSWORD_DEFAULT);
        \R::store($user);
        Router::redirect('/profile');
    }

    public function logout() 
    {
        unset($_SESSION["user"]);
        Router::redirect('/login');
    }
}