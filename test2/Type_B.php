<?php 

require_once __DIR__ .'/vendor/autoload.php';

use ExcelValidator\ExcelValidator;

$excel_validator = new ExcelValidator();
$file = './file_excel/Type_B.xlsx';

$excel_validator->validateContain($file);
