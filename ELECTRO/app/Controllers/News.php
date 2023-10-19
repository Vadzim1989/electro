<?php 

namespace App\Controllers;

use App\Services\Router;

class News {

    public function load($data) 
    {
        require('vendor/db.php');     
        $news = $data['news'];
        $date = date('Y-m-d');

        $check = mysqli_query($db, "SELECT * FROM `news`");
        $check = mysqli_fetch_assoc($check);
        if($check) {
            mysqli_query($db, "UPDATE `news` SET `news` = '$news', `date` = '$date'");
        } else {
            mysqli_query($db, "INSERT INTO `news`(`news`, `date`) VALUES ('$news', '$date')");
        }
        mysqli_close($db);
        Router::redirect('/');               
    }

    
}