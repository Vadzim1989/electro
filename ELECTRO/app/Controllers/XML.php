<?php 

namespace App\Controllers;

class XML {

    private function objectsIntoArray($arrObjData, $arrSkipIndices = array())
    {
        $arrData = array();    
        // if input is object, convert into array
        if (is_object($arrObjData)) {
            $arrObjData = get_object_vars($arrObjData);
        }
        
        if (is_array($arrObjData)) {
            foreach ($arrObjData as $index => $value) {
                if (is_object($value) || is_array($value)) {
                    $value = self::objectsIntoArray($value, $arrSkipIndices); // recursive call
                }
                if (in_array($index, $arrSkipIndices)) {
                    continue;
                }
                $arrData[$index] = $value;
            }
        }
        return $arrData;
    }

    public function load() 
    {
        require('vendor/db.php');     

        $xmlUrl = $_FILES['xml']['tmp_name'];
        $xmlStr = file_get_contents($xmlUrl);
        $xmlObj = simplexml_load_string($xmlStr);
        $arrXml = self::objectsIntoArray($xmlObj);

        print_r($arrXml);

        $contractNumber = $arrXml['deliveryCondition']['contract']['documents']['document']['number'];
        $contractNumber = mb_substr($contractNumber, 6);

        $sqlData = mysqli_query($db, "SELECT * FROM `contracts` WHERE `contract_num` LIKE '%$contractNumber%'");
        $sqlData = mysqli_fetch_assoc($sqlData);

        print_r($sqlData);                
    }

    
}