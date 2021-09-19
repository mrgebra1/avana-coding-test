<?php 

namespace ExcelValidator;
include '/../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use jc21\CliTable;

class ExcelValidator
{
	function validateContain($file) {
		// $file = './file_excel/Type_A.xlsx';
		// $file = './file_excel/Type_B.xlsx';

		$allowed_extension = array('xls', 'xlsx');
		$file_array = explode(".", $file);
		$file_extension = end($file_array);

		if(in_array($file_extension, $allowed_extension))
		{
			$reader = IOFactory::createReader('Xlsx');
			$spreadsheet = $reader->load($file);
			$dt = $spreadsheet->getSheet(0)->toArray();
			
			for ($i=1; $i < count($dt); $i++) {
				$error = '';

				for ($j=0; $j < count($dt[$i]); $j++) {
					$cecking_space = substr($dt[0][$j], 0, 1) === '#';

					if ($cecking_space) {
						if (preg_match('/ /i', $dt[$i][$j])) {
							$field_name =  substr($dt[0][$j], 1);
							$error .= $field_name.' should not contain any space, ';
							$dt[$i][$j] = 'false';
						}
					}

					$cecking_null = substr($dt[0][$j], -1) === '*';
					if ($cecking_null) {
						if (is_null($dt[$i][$j])) {
							$field_name =  substr($dt[0][$j], 0, -1);
							$error .= 'Missing value in '. $field_name .', ';
							$dt[$i][$j] = 'false';
						}
					}

				}
				if ($error != '') {
					$result[$i][0] = $i +1;
					$result[$i][1] = substr($error, 0, -2);
				}
			}

			$table = new CliTable;

			$table->addField('Row',  0, false, 'red');
			$table->addField('Error',    1,      false,  'white');
			$table->injectData($result);
			$table->display();

		} 
		else {
			return 'Only .xls or .xlsx file allowed ';
		}

	}
}