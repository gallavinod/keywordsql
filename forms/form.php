<html>
<head>
<title>Keyword SQL</title>
<link href="stylesheets/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="blogger.js"></script>
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript" src="jgcharts.js"></script>
</head>
<body>
	<div class="wholesetup">
		<div class="titleblk">
			<table>
				<tr>
					<td><a href="http://localhost/phpkeywordsql/forms"> <img
							src="images/image.png" class="image"> </img>
					</a></td>
					<td>
						<form id="srchform" action="form.php" method="GET">
							<p>
								<label for="q">Keyword:</label> <input type="text" id="q"
									name="q" value="<?php if($_GET['q'])echo $_GET['q'];?>"
									size="25" /> <label for="loc">Location:</label> <input
									type="text" id="loc" name="loc" value="" size="25" /> <input
									type="submit" id="btnSearch" class="btnSearch" value="Search" />
							</p>
						</form>
					</td>
					<td></td>
			
			</table>
		</div>
		<div class="loading">
			<img id="loading" src="ajax-loader.gif" alt="working.." />
		</div>
		<div>
			<div class="twitter_div">
<?php

form ( $_GET ['q'] );

?>
</div>
		</div>

</body>
</html>

<?php
function form($arg) {
	if ($arg == "1") {
		$html = "<b>Form 1</b><form id=\"srchform\" action=\"form.php\" method=\"GET\"><p>";
		$html = $html . "<label for=\"q\">Keyword:</label>";
		$html = $html . "&nbsp;<input type=\"text\" id=\"q\" name=\"q\" value=\"\" size=\"25\"/>";
		$html = $html . "&nbsp;<label for=\"loc\">Location:</label>";
		$html = $html . "&nbsp;<input type=\"text\" id=\"loc\" name=\"loc\" value=\"\" size=\"25\"/><input type=\"submit\" id=\"btnSearch\" class=\"btnSearch\" value=\"Search\"/>";
		$html = $html . "</p></form>";
		echo $html;
	} 

	else if ($arg == "2") {
		$html = "<b>Form 2</b><form id=\"srchform\" action=\"form.php\" method=\"GET\"><p>";
		$html = $html . "<label for=\"q\">Keyword:</label>";
		$html = $html . "&nbsp;<input type=\"text\" id=\"q\" name=\"q\" value=\"\" size=\"25\"/>";
		$html = $html . "&nbsp;<label for=\"loc\">Location:</label>";
		$html = $html . "&nbsp;<input type=\"text\" id=\"loc\" name=\"loc\" value=\"\" size=\"25\"/><input type=\"submit\" id=\"btnSearch\" class=\"btnSearch\" value=\"Search\"/>";
		$html = $html . "</p></form>";
		echo $html;
	} 

	else if ($arg == "1,2") {
		$html = "<b>Form 1</b><form id=\"srchform\" action=\"form.php\" method=\"GET\"><p>";
		$html = $html . "<label for=\"q\">Keyword:</label>";
		$html = $html . "<input type=\"text\" id=\"q\" name=\"q\" value=\"\" size=\"25\"/>";
		$html = $html . "&nbsp;<label for=\"loc\">Location:</label>";
		$html = $html . "&nbsp;<input type=\"text\" id=\"loc\" name=\"loc\" value=\"\" size=\"25\"/><input type=\"submit\" id=\"btnSearch\" class=\"btnSearch\" value=\"Search\"/>";
		$html = $html . "</p></form>";
		$html = $html . "<br/>";
		$html = $html . "<b>Form 2</b><form id=\"srchform\" action=\"form.php\" method=\"GET\"><p>";
		$html = $html . "<label for=\"q\">Keyword:</label>";
		$html = $html . "&nbsp;<input type=\"text\" id=\"q\" name=\"q\" value=\"\" size=\"25\"/>";
		$html = $html . "&nbsp;<label for=\"loc\">Location:</label>";
		$html = $html . "&nbsp;<input type=\"text\" id=\"loc\" name=\"loc\" value=\"\" size=\"25\"/><input type=\"submit\" id=\"btnSearch\" class=\"btnSearch\" value=\"Search\"/>";
		$html = $html . "</p></form>";
		echo $html;
	} else {
		echo "The Form is not found";
	}
}
?>