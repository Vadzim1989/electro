<?php 

namespace App\Controllers;

use App\Services\Router;
use mysqli;

class Obj {

    public function add($data) 
    {

        require('vendor/db.php');     

        $name = $data['name'];
        $code_adm = $data['code_adm'];
        $address = $data['address'];
        $mount = $data["mount"];
        $used = $data["used"];
        $power = $data["power"];

        mysqli_query($db, "INSERT INTO `object`(`id_object`, `object_name`, `code_adm`) VALUES (NULL, '$name', '$code_adm')");

        $object = mysqli_query($db, "SELECT * FROM `object` WHERE `object_name` = '$name' AND `code_adm` = '$code_adm'");
        $object = mysqli_fetch_assoc($object);

        $id_object = $object['id_object'];

        mysqli_query($db, "INSERT INTO `object_address`(`id_object`, `address`) VALUES ('$id_object', '$address')");
        mysqli_query($db, "INSERT INTO `object_mount`(`id_object`, `mount`, `used`, `id_type`) VALUES ('$id_object', '$mount', '$used', NULL)");
        mysqli_query($db, "INSERT INTO `object_power`(`id_object`, `object_power`) VALUES ('$id_object', '$power')");

        Router::redirect('/');
    }

    public function delete($data)
    {
        require('vendor/db.php'); 

        $id = $data["id_delete"];
        var_dump($data);

        mysqli_query($db, "DELETE FROM `object` WHERE `id_object` = '$id'");
        mysqli_query($db, "DELETE FROM `object_address` WHERE `id_object` = '$id'");
        mysqli_query($db, "DELETE FROM `object_mount` WHERE `id_object` = '$id'");
        mysqli_query($db, "DELETE FROM `object_counter` WHERE `id_object` = '$id'");
        mysqli_query($db, "DELETE FROM `object_contracts` WHERE `id_object` = '$id'");
        mysqli_query($db, "DELETE FROM `object_power` WHERE `id_object` = '$id'");

        Router::redirect('/');
    }

    public function update($data)
    {
        require('vendor/db.php');

        $id_object = $data["id"];
        $object_name = $data["object_name"];
        $code_adm = $data["code_adm"];
        $address = $data["address"];
        $mount = $data["mount"];
        $used = $data["used"];
        $power = $data["power"];
        $remark = $data['remark'];

        if(!$mount) $mount = 0;
        if(!$used) $used = 0;
        if(!$power) $power = 0;

        
        $objectAddress = mysqli_query($db, "SELECT `id_object` FROM `object_address` WHERE `id_object` = '$id_object'");
        $objectAddress = mysqli_fetch_assoc($objectAddress);

        if($objectAddress) {
            mysqli_query($db, "UPDATE `object_address` SET `address` = '$address' WHERE `id_object` = '$id_object'");
        } else {
            mysqli_query($db, "INSERT INTO `object_address`(`id_object`, `address`) VALUES ('$id_object', '$address')");
        };
      

        mysqli_query($db, "UPDATE `object` SET `code_adm` = '$code_adm', `object_name` = '$object_name' WHERE `id_object` = '$id_object'");
       
        $objectMount = mysqli_query($db, "SELECT `id_object` FROM `object_mount` WHERE `id_object` = '$id_object'");
        $objectMount = mysqli_fetch_assoc($objectMount);
       
        if(!is_null($objectMount)) {
            mysqli_query($db, "UPDATE `object_mount` SET `mount` = '$mount', `used` = '$used' WHERE `id_object` = '$id_object'");
        } else {
            mysqli_query($db, "INSERT INTO `object_mount`(`id_object`, `mount`, `used`, `id_type`) VALUES ('$id_object', '$mount', '$used', NULL)");
        };

        $objectPower = mysqli_query($db, "SELECT * FROM `object_power` WHERE `id_object` = '$id_object'");
        $objectPower = mysqli_fetch_assoc($objectPower);

        if(!is_null($objectPower)) {
            mysqli_query($db, "UPDATE `object_power` SET `object_power` = '$power' WHERE `id_object` = '$id_object'");
        } else {
            mysqli_query($db, "INSERT INTO `object_power`(`id_object`, `object_power`) VALUES ('$id_object', '$power')");
        }

        mysqli_close($db);

        Router::redirect('/');
    }

    public function arenda($data)
    {
        require('vendor/db.php');

        $id_object = $data['id_object'];
        $id_contract = $data['id_contract'];

        mysqli_query($db, "INSERT INTO `object_contracts`(`id_object`, `id_contract`) VALUE ('$id_object', '$id_contract')");

        Router::redirect('/');
    }

    public function remark($data) {
        require('vendor/db.php');
        $id = $data['id'];
        $remark = $data['remark'];
        $code_adm = $data['code_adm'];

        mysqli_query($db, "UPDATE `object` SET `remark` = '$remark' WHERE `id_object` = '$id'");
        mysqli_close($db);

        Router::redirect('/rues?id='.$code_adm);
    }
}