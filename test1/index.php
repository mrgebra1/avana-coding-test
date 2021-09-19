	<?php 
	function indexPosition($str, $int)
	{
		$selected_str = substr($str, $int);
		$arr_string = str_split($selected_str);
		$selected_arr = [];

		if (substr($selected_str, 0, 1) !== '(') {
			return 'the integer not correctly indicates the index position of an open parenthesis "(" inside the given string';
		}

		$x = 0;
		$a = '';
		for ($i=0; $i < count($arr_string); $i++) {
			switch ($arr_string[$i]) {
		    case '(':
		        $x++;
		        break;
		    case ')':
		        $x--;
		        break;
			}

			if ($x === 0) {
				$a = $arr_string[$i];
				return $i + $int;
				break;
			}
		}

		return '"(" index '. $int +1 .', there is no close ")"' ;
	}

	echo indexPosition("a (b c (d e (f) g) h) i (j k)", 2);
?>