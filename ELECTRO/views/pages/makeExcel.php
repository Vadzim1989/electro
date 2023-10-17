<?php

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;


require('vendor/db.php');
// $id = $_POST['code_adm'];


$query = mysqli_query($db, "SELECT * FROM `object`");
$datas = [];
while($row = mysqli_fetch_assoc($query)) {
    $datas[] = $row;
}


$spreadsheet = new Spreadsheet();
 
// Подключение к активной таблице
$sheet = $spreadsheet->getActiveSheet();

// Объединяем ячейки от A1:F1
$sheet->mergeCells('A1:F1');

// Устанавливаем значение ячейке A1
$sheet->setCellValue('A1', 'Информация по объектам');

// Установка значений в шапку таблицы
$sheet->setCellValue('A2', '№ объекта');
$sheet->setCellValue('B2', 'Название объекта');
$sheet->setCellValue('C2', 'Регион');

$i=3;
foreach($datas as $key => $data) {
    $sheet->setCellValue('A'.$i, $data['id_object']);
    $sheet->setCellValue('B'.$i, $data['object_name']);
    $sheet->setCellValue('C'.$i, $data['code_adm']);
    $i++;
}

// получение текущей даты, будет использоваться в имени файла
$dt = date('h:i:s');

// создание объекта Xlsx
$writer = new Xlsx($spreadsheet);

// отправка файла в браузер
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment;filename=word.xlsx");
$writer->save('php://output');

