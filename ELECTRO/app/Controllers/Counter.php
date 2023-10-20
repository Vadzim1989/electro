<?php 

namespace App\Controllers;

use App\Services\Router;
use mysqli;

class Counter {

    public function add($data) 
    {

        require('vendor/db.php');     

        $id_object = $data['id_object'];
        $counter_type = $data['counter_type'];
        $sn = $data['sn'];
        $transform = $data['transform'];
        $transform = str_replace(',','.',$transform);

        $object_name = mysqli_query($db, "SELECT `object_name` FROM `object` WHERE `id_object` = '$id_object'");
        $object_name = mysqli_fetch_assoc($object_name);
        mysqli_query($db, "INSERT INTO `history_counters`(`object_name`, `user`, `date`, `remark`) VALUES ('".$object_name['object_name']."', '".$_SESSION['user']['full_name']."', '".date('d-m-Y H:i:s')."', 'add')");

        mysqli_query($db, "INSERT INTO `object_counter`(`id_object`,`id_counter`, `counter_type`, `sn`, `online`, `transform`) VALUES ('$id_object', NULL, '$counter_type', '$sn', NULL, '$transform')");
        mysqli_close($db);
        
        Router::redirect('/counters?id='.$id_object);
    }

    public function delete($data)
    {
        require('vendor/db.php'); 

        $id_counter = $data["id_delete"];
        $id_object = $data["id_object_delete"];

        $object_name = mysqli_query($db, "SELECT `object_name` FROM `object` WHERE `id_object` = '$id_object'");
        $object_name = mysqli_fetch_assoc($object_name);
        mysqli_query($db, "INSERT INTO `history_counters`(`object_name`, `user`, `date`, `remark`) VALUES ('".$object_name['object_name']."', '".$_SESSION['user']['full_name']."', '".date('d-m-Y H:i:s')."', 'delete')");

        mysqli_query($db, "DELETE FROM `object_counter` WHERE `id_counter` = '$id_counter' AND `id_object` = '$id_object'");

        $month = [
            'counter_01'.date('Y'),
            'counter_02'.date('Y'),
            'counter_03'.date('Y'),
            'counter_04'.date('Y'),
            'counter_05'.date('Y'),
            'counter_06'.date('Y'),
            'counter_07'.date('Y'),
            'counter_08'.date('Y'),
            'counter_09'.date('Y'),
            'counter_10'.date('Y'),
            'counter_11'.date('Y'),
            'counter_12'.date('Y')
        ];
        
        for($i = 0; $i < 12; $i++) {
            mysqli_query($db, "DELETE FROM `".$month[$i]."` WHERE `id_counter` = '$id_counter'");
        }
        mysqli_close($db);

        Router::redirect('/counters?id='.$id_object);
    }

    public function update($data)
    {
        require('vendor/db.php');

        $id_counter = $data['id_counter'];
        $id_object = $data['id_object'];
        $counter_type = $data['counter_type'];
        $sn = $data['sn'];
        $transform = $data['transform'];
        $transform = str_replace(',','.',$transform);

        $object_name = mysqli_query($db, "SELECT `object_name` FROM `object` WHERE `id_object` = '$id_object'");
        $object_name = mysqli_fetch_assoc($object_name);
        mysqli_query($db, "INSERT INTO `history_counters`(`object_name`, `user`, `date`, `remark`) VALUES ('".$object_name['object_name']."', '".$_SESSION['user']['full_name']."', '".date('d-m-Y H:i:s')."', 'update')");

        mysqli_query($db, "UPDATE `object_counter` SET `counter_type` = '$counter_type', `sn` = '$sn', `transform` = '$transform' WHERE `id_counter` = '$id_counter' AND `id_object` = '$id_object'");
        mysqli_close($db);

        Router::redirect('/counters?id='.$id_object);
    }

    public function addData($data)
    {
        require('vendor/db.php');

        $id_object = $data['id_object'];
        $id_counter = $data['id_counter'];
        $table = $data['tab'];
        $value = $data['value'];
        $date = date('Y-m-d');
        $value = str_replace(',','.',$value);

        $object_name = mysqli_query($db, "SELECT `object_name` FROM `object` WHERE `id_object` = '$id_object'");
        $object_name = mysqli_fetch_assoc($object_name);
        mysqli_query($db, "INSERT INTO `history_counters`(`object_name`, `user`, `date`, `remark`) VALUES ('".$object_name['object_name']."', '".$_SESSION['user']['full_name']."', '".date('d-m-Y H:i:s')."', 'addData')");

        $checkInfo = mysqli_query($db, "SELECT * FROM `$table` WHERE `id_counter` = '$id_counter'");
        $checkInfo = mysqli_fetch_all($checkInfo);

        if($checkInfo) {
            mysqli_query($db, "UPDATE `$table` SET `value` = '$value', `date_input` = '$date' WHERE `id_counter` = '$id_counter'");
        } else {
            mysqli_query($db, "INSERT INTO `$table`(`id_counter`, `value`, `date_input`) VALUES ('$id_counter', '$value', '$date')");
        }
        mysqli_close($db);

        Router::redirect('/counters?id='.$id_object);
    }

    public function deleteData($data)
    {
        require('vendor/db.php');

        $id_object = $data['id_object_del'];
        $id_counter = $data['id_counter_delete'];
        $table = $data['tab_delete'];

        $object_name = mysqli_query($db, "SELECT `object_name` FROM `object` WHERE `id_object` = '$id_object'");
        $object_name = mysqli_fetch_assoc($object_name);
        mysqli_query($db, "INSERT INTO `history_counters`(`object_name`, `user`, `date`, `remark`) VALUES ('".$object_name['object_name']."', '".$_SESSION['user']['full_name']."', '".date('d-m-Y H:i:s')."', 'deleteData')");

        $checkInfo = mysqli_query($db, "SELECT * FROM `$table` WHERE `id_counter` = '$id_counter'");
        $checkInfo = mysqli_fetch_assoc($checkInfo);

        if($checkInfo) {
            mysqli_query($db, "DELETE FROM `$table` WHERE `id_counter` = '$id_counter'");
        }
        mysqli_close($db);

        Router::redirect('/counters?id='.$id_object);
    }

    public function addArenda($data) 
    {

        require('vendor/db.php');     

        $id_object = $data['id_object_arenda'];
        $counter_type = $data['counter_type'];

        $object_name = mysqli_query($db, "SELECT `object_name` FROM `object` WHERE `id_object` = '$id_object'");
        $object_name = mysqli_fetch_assoc($object_name);
        mysqli_query($db, "INSERT INTO `history_counters`(`object_name`, `user`, `date`, `remark`) VALUES ('".$object_name['object_name']."', '".$_SESSION['user']['full_name']."', '".date('d-m-Y H:i:s')."', 'addArenda')");

        mysqli_query($db, "INSERT INTO `object_counter_arenda`(`id_counter`,`id_object`, `counter_type`) VALUES (NULL,'$id_object', '$counter_type')");
        mysqli_close($db);

        Router::redirect('/counters?id='.$id_object);
    }

    public function deleteArenda($data)
    {
        require('vendor/db.php'); 

        $id_counter = $data["id_delete"];
        $id_object = $data["id_object_delete"];

        $object_name = mysqli_query($db, "SELECT `object_name` FROM `object` WHERE `id_object` = '$id_object'");
        $object_name = mysqli_fetch_assoc($object_name);
        mysqli_query($db, "INSERT INTO `history_counters`(`object_name`, `user`, `date`, `remark`) VALUES ('".$object_name['object_name']."', '".$_SESSION['user']['full_name']."', '".date('d-m-Y H:i:s')."', 'deleteArenda')");

        mysqli_query($db, "DELETE FROM `object_counter_arenda` WHERE `id_counter` = '$id_counter' AND `id_object` = '$id_object'");

        $month = [
            'arenda_01'.date('Y'),
            'arenda_02'.date('Y'),
            'arenda_03'.date('Y'),
            'arenda_04'.date('Y'),
            'arenda_05'.date('Y'),
            'arenda_06'.date('Y'),
            'arenda_07'.date('Y'),
            'arenda_08'.date('Y'),
            'arenda_09'.date('Y'),
            'arenda_10'.date('Y'),
            'arenda_11'.date('Y'),
            'arenda_12'.date('Y')
        ];
        
        for($i = 0; $i < 12; $i++) {
            mysqli_query($db, "DELETE FROM `".$month[$i]."` WHERE `id_counter` = '$id_counter'");
        }
        mysqli_close($db);
        Router::redirect('/counters?id='.$id_object);
    }

    public function addArendaData($data)
    {
        require('vendor/db.php');

        $id_object = $data['id_object'];
        $id_counter = $data['id_counter'];
        $table = $data['tab'];
        $value = $data['value'];
        $pay = $data['pay'];
        $date = date('Y-m-d');
        $value = str_replace(',','.',$value);
        $pay = str_replace(',','.',$pay);

        $object_name = mysqli_query($db, "SELECT `object_name` FROM `object` WHERE `id_object` = '$id_object'");
        $object_name = mysqli_fetch_assoc($object_name);
        mysqli_query($db, "INSERT INTO `history_counters`(`object_name`, `user`, `date`, `remark`) VALUES ('".$object_name['object_name']."', '".$_SESSION['user']['full_name']."', '".date('d-m-Y H:i:s')."', 'addArendaData')");

        $checkInfo = mysqli_query($db, "SELECT * FROM `$table` WHERE `id_counter` = '$id_counter'");
        $checkInfo = mysqli_fetch_assoc($checkInfo);

        if($checkInfo) {
            mysqli_query($db, "UPDATE `$table` SET `value` = '$value', `pay` = '$pay', `date_input` = '$date' WHERE `id_counter` = '$id_counter'");
        } else {
            mysqli_query($db, "INSERT INTO `$table`(`id_counter`, `value`, `pay`, `date_input`) VALUES ('$id_counter', '$value', '$pay', '$date')");
        }
        mysqli_close($db);
        Router::redirect('/counters?id='.$id_object);
    }

    public function deleteArendaData($data)
    {
        require('vendor/db.php');

        $id_object = $data['id_object_del'];
        $id_counter = $data['id_counter_delete'];
        $table = $data['tab_delete'];

        $object_name = mysqli_query($db, "SELECT `object_name` FROM `object` WHERE `id_object` = '$id_object'");
        $object_name = mysqli_fetch_assoc($object_name);
        mysqli_query($db, "INSERT INTO `history_counters`(`object_name`, `user`, `date`, `remark`) VALUES ('".$object_name['object_name']."', '".$_SESSION['user']['full_name']."', '".date('d-m-Y H:i:s')."', 'deleteArendaData')");

        $checkInfo = mysqli_query($db, "SELECT * FROM `$table` WHERE `id_counter` = '$id_counter'");
        $checkInfo = mysqli_fetch_assoc($checkInfo);

        if($checkInfo) {
            mysqli_query($db, "DELETE FROM `$table` WHERE `id_counter` = '$id_counter'");
        }
        mysqli_close($db);
        Router::redirect('/counters?id='.$id_object);
    }
}