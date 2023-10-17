<?php 

namespace App\Controllers;

use App\Services\Router;

class Device {

    public function add($data) 
    {

        require('vendor/db.php');     

        $id_object = $data['id_object'];
        $name = $data['name'];
        $mount = $data['mount'];
        $used = $data['used'];
        $power = $data['power'];
        $time = $data['time'];

        mysqli_query($db, "INSERT INTO `object_devices`(`id_device`, `id_object`, `device_name`, `device_power`, `device_mount`, `device_used`, `device_time`) VALUES (NULL, '$id_object', '$name', '$power', '$mount', '$used', '$time')");

        Router::redirect('/device?id='.$id_object);
    }

    public function delete($data)
    {
        require('vendor/db.php'); 

        $id_device = $data["id_device_delete"];
        $id_object = $data["id_object_delete"];

        mysqli_query($db, "DELETE FROM `object_devices` WHERE `id_device` = '$id_device' AND `id_object` = '$id_object'");
        
        Router::redirect('/device?id='.$id_object);
    }

    public function update($data)
    {
        require('vendor/db.php');

        $id_device = $data['id_device'];
        $id_object = $data['id_object'];
        $name = $data['name'];
        $mount = $data['mount'];
        $used = $data['used'];
        $power = $data['power'];
        $time = $data['time'];

        mysqli_query($db, "UPDATE `object_devices`SET `device_name` = '$name', `device_mount` = '$mount', `device_used` = '$used', `device_power` = '$power', `device_time` = '$time' WHERE `id_device` = '$id_device' AND `id_object` = '$id_object'");

        Router::redirect('/device?id='.$id_object);
    }
}