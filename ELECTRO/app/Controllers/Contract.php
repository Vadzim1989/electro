<?php 

namespace App\Controllers;

use App\Services\Router;
use mysqli;

class Contract {

    public function add($data) 
    {

        require('vendor/db.php');     

        /**
         * Добавление договоров аренды
         */

        
        $landlord = $data['landlord'];
        $unp = $data['unp'];
        $landlord_address = $data['landlord_address'];
        $object = $data['object'];
        $equip_address = $data['equip_address'];
        $contract_num = $data['contract_num'];
        $contract_start = $data['contract_start'];
        $contract_end = $data['contract_end'];
        $landlord_area = $data['landlord_area'];
        $wall = $data['wall'];
        $length = $data['length'];
        $bav = $data['bav'];
        $byn = $data['byn'];
        $nds = $data['nds'];
        $pay_attribute = $data['pay_attribute'];
        $pay_date = $data['pay_date'];
        $comments = $data['comments'];
        $area = $data['area'];
        $part = $data['part'];

        mysqli_query($db, "INSERT INTO `contracts`(`id_contract`, `landlord`, `unp`, `landlord_address`, `object`, `equip_address`, `contract_num`, `contract_start`, `contract_end`, `landlord_area`, `wall`, `length`, `bav`, `byn`, `nds`, `pay_attribute`, `pay_date`, `comments`, `area`, `part`) VALUES (NULL, '$landlord', '$unp', '$landlord_address', '$object', '$equip_address', '$contract_num', '$contract_start', '$contract_end', '$landlord_area', '$wall', '$length', '$bav', '$byn', '$nds', '$pay_attribute', '$pay_date', '$comments', '$area', '$part')");
        
        Router::redirect('/contracts');
    }

    public function delete($data)
    {
        require('vendor/db.php'); 

        /**
         * Удаление договоров аренды
         */
        $id_contract = $data['id_contract'];
        $id_object = $data['object_id'];

        $check = mysqli_query($db, "SELECT * FROM `object_contracts` WHERE `id_contract` = '$id_contract' AND `id_object` = '$id_object'");
        $check = mysqli_fetch_assoc($check);
        $checkCnt = mysqli_query($db, "SELECT * FROM `object_contracts` WHERE `id_contract` = '$id_contract'");
        $checkCnt = mysqli_fetch_all($checkCnt);

        if($check) {
            if(isset($checkCnt) && count($checkCnt) > 1) {
                mysqli_query($db, "DELETE FROM `object_contracts` WHERE `id_contract` = '$id_contract' AND `id_object` = '$id_object'");
            }else {
                mysqli_query($db, "DELETE FROM `object_contracts` WHERE `id_contract` = '$id_contract' AND `id_object` = '$id_object'");
                mysqli_query($db, "DELETE FROM `contracts` WHERE `id_contract` = '$id_contract'");
            }            
        }else {
            mysqli_query($db, "DELETE FROM `contracts` WHERE `id_contract` = '$id_contract'");
        }     
        
        mysqli_close($db);

        Router::redirect('/contracts');
    }

    public function update($data)
    {
        require('vendor/db.php');

        /**
         * Внесение изменений в договора аренды
         */

        $id_contract = $data['id_contract'];
        $id_object = $data['id_object'] != 0 ? $data['id_object'] : NULL;
        $object_id = $data['object_id'];
        $landlord = $data['landlord'];
        $unp = $data['unp'];
        $landlord_address = $data['landlord_address'];
        $object = $data['object'];
        $equip_address = $data['equip_address'];
        $contract_num = $data['contract_num'];
        $contract_start = $data['contract_start'];
        $contract_end = $data['contract_end'];
        $landlord_area = $data['landlord_area'];
        $wall = $data['wall'];
        $length = $data['length'];
        $bav = $data['bav'];
        $byn = $data['byn'];
        $nds = $data['nds'];
        $pay_attribute = $data['pay_attribute'];
        $pay_date = $data['pay_date'];
        $comments = $data['comments'];
        $area = $data['area'];
        $part = $data['part'];

        $landlord_area = str_replace(',','.',$landlord_area);
        $wall = str_replace(',','.',$wall);
        $length = str_replace(',','.',$length);
        $bav = str_replace(',','.',$bav);
        $byn = str_replace(',','.',$byn);
        $nds = str_replace(',','.',$nds);
        $pay_attribute = str_replace(',','.',$pay_attribute);
        $pay_date = str_replace(',','.',$pay_date);
        $area = str_replace(',','.',$area);
        $part = str_replace(',','.',$part);


        $checkObjectContacts = mysqli_query($db, "SELECT * FROM `object_contracts` WHERE `id_contract` = '$id_contract' AND `id_object` = '$id_object'");
        $checkObjectContacts = mysqli_fetch_assoc($checkObjectContacts);

        if(is_null($checkObjectContacts)) {
            if(!is_null($id_object)) {
                mysqli_query($db, "INSERT INTO `object_contracts`(`id_object`, `id_contract`) VALUES ('$id_object', '$id_contract')");
            }            
        }
        else
        {    
            $check = mysqli_query($db, "SELECT * FROM `object_contracts` WHERE `id_contract` = '$id_contract' AND `id_object` = '$object_id'");
            $check = mysqli_fetch_assoc($check);
            if($check) {
                if(is_null($id_object)) {
                    mysqli_query($db, "DELETE FROM `object_contracts` WHERE `id_contract` = '$id_contract' AND `id_object` = '$object_id'");
                }
            }
        };


        mysqli_query($db, "UPDATE `contracts` SET `landlord` = '$landlord', `unp` = '$unp', `landlord_address` = '$landlord_address', `object` = '$object', `equip_address` = '$equip_address', `contract_num` = '$contract_num', `contract_start` = '$contract_start', `contract_end` = '$contract_end', `landlord_area` = '$landlord_area', `wall` = '$wall', `length` = '$length', `bav` = '$bav', `byn` = '$byn', `nds` = '$nds', `pay_attribute` = '$pay_attribute', `pay_date` = '$pay_date', `comments` = '$comments', `area` = '$area', `part` = '$part' WHERE `id_contract` = '$id_contract'");

        
        mysqli_close($db);

        Router::redirect('/contracts');
    }
}