<h1 class="text-center">Тестовая страница</h1>

<?php
use App\Services\Router;
if($_SESSION["user"]["group"] != 2) {
  Router::redirect('/');
}

require_once('vendor/db.php');

/**
 * ТУТ МОЖНО РАБОТАТЬ С БД НА ПРЯМУЮ
*/

// $query = mysqli_query($db, "CREATE TABLE `object_counter_arenda` (`id_counter` INT(10) NOT NULL AUTO_INCREMENT,`id_object` INT(10) NULL DEFAULT NULL,`counter_type` INT(10) NULL DEFAULT NULL,PRIMARY KEY (`id_counter`) USING BTREE,UNIQUE INDEX `id_counter` (`id_counter`)USING BTREE,INDEX `id_object` (`id_object`) USING BTREE)COLLATE='utf8mb3_general_ci'ENGINE=MyISAM");

// mysqli_query($db, "CREATE TABLE `arenda_pay_122023` (`id_counter` INT(10) NOT NULL DEFAULT '0',	`value` DECIMAL(10,3) NOT NULL DEFAULT '0.000',	`pay` DECIMAL(10,3) NULL DEFAULT NULL,	`date_input` DATE NOT NULL)COLLATE='utf8mb3_general_ci'ENGINE=InnoDB");
// mysqli_query($db, "DROP TABLE arenda_122023");


// $counterConn = mysqli_connect('10.245.31.5', 'counter', '@1QAZwsx', 'ctell');
// $cntData = mysqli_query($counterConn, "SELECT * FROM bm_cnt_data INNER JOIN (SELECT c_id, MAX(id) AS maxid FROM bm_cnt_data WHERE c_id = (select c_id from bm_cnts where fact_num like '02013804' LIMIT 1)) AS m where bm_cnt_data.id = m.maxid");
// $cntData = mysqli_fetch_assoc($cntData);
// print_r($cntData);

// $test = mysqli_query($counterConn, "SELECT * FROM bm_cnts WHERE fact_num LIKE '02013804'");
// $test = mysqli_fetch_assoc($test);
// print_r($test);

// $query = mysqli_query($db, "SELECT `id_object`, SUM(`device_power`) FROM `object_devices` WHERE `id_object` = 37");
// $query = mysqli_fetch_all($query);
// var_dump($query);

// mysqli_query($db, "ALTER TABLE `news` ADD COLUMN `date` DATE")

// $dateDiff = date_diff(new DateTime(), new DateTime('2023-09-09')) -> days;
// print_r($dateDiff);

// mysqli_query($db, "ALTER TABLE `news` MODIFY `news` TEXT NULL")

// mysqli_query($db, "CREATE TABLE `news` (`news` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb3_general_ci') COLLATE='utf8mb3_general_ci' ENGINE=InnoDB;");

// $query = mysqli_query($db, "SELECT * FROM `object_devices` WHERE `remark` IS NOT NULL");
// $datas = [];
// while($row = mysqli_fetch_assoc($query)) {
//     $datas[] = $row;
// }
?>