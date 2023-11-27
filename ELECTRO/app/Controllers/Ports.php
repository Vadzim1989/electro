<?php
namespace App\Controllers;

use App\Services\Router;
use mysqli;

class Ports
{
    public function add($data)
    {
        require_once('vendor/db.php');

        $id_object = $data['id_object'];
        $tab = $data['tab'];
        $used = $data['used'];
        $mount = $data['mount'];

        $check = mysqli_query($db, "SELECT * FROM `$tab` WHERE `id_object` = '$id_object'");
        $check = mysqli_fetch_assoc($check);

        if($check) 
        {
            mysqli_query($db, "UPDATE `$tab` SET `mount` = '$mount', `used` = '$used', `date_input` = '".date('Y-m-d')."' WHERE `id_object` = '$id_object'");
        }
        else
        {
            mysqli_query($db, "INSERT INTO `$tab`(`id_object`, `mount`, `used`, `date_input`) VALUES ('$id_object', '$mount', '$used', '".date('Y-m-d')."')");
        }
        
        mysqli_close($db);

        Router::redirect('/mount?id='.$id_object);
    }

    public function delete($data)
    {
        require_once('vendor/db.php');

        $id_object = $data['id_object_del'];
        $tab = $data['tab_delete'];
        mysqli_query($db, "DELETE FROM `$tab` WHERE `id_object` = '$id_object'");
        mysqli_close($db);

        Router::redirect('/mount?id='.$id_object);
    }
}
?>
