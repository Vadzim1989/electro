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

        mysqli_query($db, "INSERT INTO `object_counter`(`id_object`,`id_counter`, `counter_type`, `sn`, `online`) VALUES ('$id_object', NULL, '$counter_type', '$sn', NULL)");

        Router::redirect('/counters?id='.$id_object);
    }

    public function addArenda($data) 
    {

        require('vendor/db.php');     

        $id_object = $data['id_object_arenda'];
        $counter_type = $data['counter_type'];

        mysqli_query($db, "INSERT INTO `object_counter_arenda`(`id_counter`,`id_object`, `counter_type`) VALUES (NULL,'$id_object', '$counter_type')");

        Router::redirect('/counters?id='.$id_object);
    }

    public function delete($data)
    {
        require('vendor/db.php'); 

        $id_counter = $data["id_delete"];
        $id_object = $data["id_object_delete"];

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
        
        Router::redirect('/counters?id='.$id_object);
    }

    public function deleteArenda($data)
    {
        require('vendor/db.php'); 

        $id_counter = $data["id_delete"];
        $id_object = $data["id_object_delete"];

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
        
        Router::redirect('/counters?id='.$id_object);
    }

    public function update($data)
    {
        require('vendor/db.php');

        $id_counter = $data['id_counter'];
        $id_object = $data['id_object'];
        $counter_type = $data['counter_type'];
        $sn = $data['sn'];

        mysqli_query($db, "UPDATE `object_counter` SET `counter_type` = '$counter_type', `sn` = '$sn' WHERE `id_counter` = '$id_counter' AND `id_object` = '$id_object'");

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

        $checkInfo = mysqli_query($db, "SELECT * FROM `$table` WHERE `id_counter` = '$id_counter'");
        $checkInfo = mysqli_fetch_assoc($checkInfo);

        if($checkInfo) {
            mysqli_query($db, "UPDATE `$table` SET `value` = '$value', `date_input` = '$date' WHERE `id_counter` = '$id_counter'");
        } else {
            mysqli_query($db, "INSERT INTO `$table`(`id_counter`, `value`, `date_input`,`arenda_cnt`,`arenda_pay`) VALUES ('$id_counter', '$value', '$date')");
        }

        Router::redirect('/counters?id='.$id_object);
    }

    public function addArendaData($data)
    {
        require('vendor/db.php');

        $id_object = $data['id_object'];
        $id_counter = $data['id_counter'];
        $table = $data['tab'];
        $value = $data['value'];
        $value = str_replace(',','.',$value);
        $pay = $data['pay'];
        $pay = str_replace(',','.',$pay);
        $date = date('Y-m-d');
        print_r($value);
        print_r($pay);

        $checkInfo = mysqli_query($db, "SELECT * FROM `$table` WHERE `id_counter` = '$id_counter'");
        $checkInfo = mysqli_fetch_assoc($checkInfo);

        if($checkInfo) {
            mysqli_query($db, "UPDATE `$table` SET `value` = '$value', `pay` = '$pay', `date_input` = '$date' WHERE `id_counter` = '$id_counter'");
        } else {
            mysqli_query($db, "INSERT INTO `$table`(`id_counter`, `value`, `pay`, `date_input`) VALUES ('$id_counter', '$value', '$pay', '$date')");
        }

        // Router::redirect('/counters?id='.$id_object);
    }

    public function deleteData($data)
    {
        require('vendor/db.php');

        $id_object = $data['id_object_del'];
        $id_counter = $data['id_counter_delete'];
        $table = $data['tab_delete'];

        $checkInfo = mysqli_query($db, "SELECT * FROM `$table` WHERE `id_counter` = '$id_counter'");
        $checkInfo = mysqli_fetch_assoc($checkInfo);

        if($checkInfo) {
            mysqli_query($db, "DELETE FROM `$table` WHERE `id_counter` = '$id_counter'");
        }

        Router::redirect('/counters?id='.$id_object);
    }

    public function deleteArendaData($data)
    {
        require('vendor/db.php');

        $id_object = $data['id_object_del'];
        $id_counter = $data['id_counter_delete'];
        $table = $data['tab_delete'];

        $checkInfo = mysqli_query($db, "SELECT * FROM `$table` WHERE `id_counter` = '$id_counter'");
        $checkInfo = mysqli_fetch_assoc($checkInfo);

        if($checkInfo) {
            mysqli_query($db, "DELETE FROM `$table` WHERE `id_counter` = '$id_counter'");
        }

        Router::redirect('/counters?id='.$id_object);
    }
}