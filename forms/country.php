<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<?php
$table_name = 'country';
$columns = [
		'name',
		'code',
		'capital',
		'province',
		'area',
		'population' 
];
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Cp1252">
<style>
table,th,td {
	border: 1px solid black;
}
</style>
<title>Form - Country</title>
</head>

    <body>
    <center>
    <?php
if (! empty ( $_POST ['country-submit'] )) {
	// do something here;
	$q = 'SELECT * FROM ' . $table_name . ' WHERE ';
	foreach ( $columns as $column_name ) {
		if (isset ( $_POST [$column_name] ) and ! (($_POST [$column_name]) == '')) {
			$op = $column_name . '_op';
			$q .= $column_name . ' ' . $_POST [$op] . ' "' . $_POST [$column_name] . '" AND ';
		}
	}
//	$q .= '1';
	
	
	$q = substr($q, 0, -5);
	echo $q;
	?>
	<p>
		
		
		<center>
	<?php
	
	$conn = mysql_connect ( "localhost", "root", "" ) or die ( 'Could not connect: ' . mysql_error () );
	mysql_select_db ( 'mondial' ) or die ( 'Could not select database' );
	// Performing SQL query
	// $query = 'SELECT * FROM ' . $formIds [0];
	$result = mysql_query ( $q ) or die ( 'Query failed: ' . mysql_error () );
	// Printing results in HTML
	echo "<table>\n";
	echo "<tr>\n";
	foreach ( $columns as $col_name ) {
		echo '<th>' . $col_name . '</th>';
	}
	while ( $line = mysql_fetch_array ( $result, MYSQL_ASSOC ) ) {
		echo "\t<tr>\n";
		foreach ( $line as $col_value ) {
			echo "\t\t<td>$col_value</td>\n";
		}
		echo "\t</tr>\n";
	}
	echo "</table>\n"; // Free resultset mysql_free_result ( $result ); // Closing connection mysql_close ( $conn );
}

?>
<p><form action="index.php"><input type="submit" value="Try Again!"></form></p>
    </center>

    
    </body>
</html>