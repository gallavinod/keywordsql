<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<?php
if (! empty ( $_POST ['mailing-submit'] )) {
	// do something here;
}

if (! empty ( $_POST ['contact-submit'] )) {
	// do something here;
}
?>
<?php
$columns = ['name','area'];
// Connecting, selecting database
$conn = mysql_connect ( "localhost", "root", "" ) or die ( 'Could not connect: ' . mysql_error () );
echo 'Connected successfully';
mysql_select_db ( 'mondial' ) or die ( 'Could not select database' );

// Performing SQL query
$query = 'SELECT * FROM continent';
$result = mysql_query ( $query ) or die ( 'Query failed: ' . mysql_error () );

// Printing results in HTML
echo "<table>\n";
echo "<tr>\n";
foreach ($columns as $col_name) {
	echo '<th>' . $col_name . '</th>\n';
	
	
}
while ( $line = mysql_fetch_array ( $result, MYSQL_ASSOC ) ) {
	echo "\t<tr>\n";
	foreach ( $line as $col_value ) {
		echo "\t\t<td>$col_value</td>\n";
	}
	echo "\t</tr>\n";
}
echo "</table>\n";

// Free resultset
mysql_free_result ( $result );

// Closing connection
mysql_close ( $conn );
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Cp1252">
<title>Insert title here</title>
<style>
table,th,td
{
border:1px solid black;
}
</style>
</head>

<body>
	<form name="mailinglist" method="post">
	<label for="city">City</label><br />
		<input type="text" name="email" /> <input type="submit"
			name="mailing-submit" value="Join Our Mailing List" />
	</form>
	<br />
	<form name="contactus" method="post">
		<input type="text" name="email" /> <input type="text" name="subjet" />
		<textarea name="message"></textarea>
		<input type="submit" name="contact-submit" value="Send Email" />
	</form>
</body>

</html>