<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Cp1252">
<title>Insert title here</title>

<?php
function enumerate($idx, $buffer, $buckets) {
	global $enum;
	if ($idx < count ( $buckets )) {
		for($i = 0; $i < count ( $buckets [$idx] ); $i ++) {
			$buffer [$idx] = $buckets [$idx] [$i];
			enumerate ( $idx + 1, $buffer, $buckets );
		}
	}
	if ($idx >= count ( $buckets )) {
		
		array_push ( $enum, $buffer );
	}
}
?>
</head>

<body>
    
    <?php
				
				$b1 = [ 
						'a',
						'b',
						'c' 
				];
				$b2 = [ 
						'd',
						'e' 
				];
				$b3 = [ 
						'f',
						'g',
						'h',
						'i' 
				];
				
				$buc = [ 
						$b1,
						$b2,
						$b3 
				];
				$tuple = "abc:d";
				$tuples = explode(":", $tuple);
				print_r($tuples);
				// $buf = array ();
				// $enum = array ();
				// enumerate ( 0, $buf, $buc );
				// foreach ( $enum as $bin ) {
				//
				// print_r ( $bin );
				//
				// }
				?>
</body>

</html>