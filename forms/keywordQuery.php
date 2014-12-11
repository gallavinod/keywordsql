<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Cp1252">
<title>Forms</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="blogger.js"></script>
<script type="text/javascript" src="jquery.min.js"></script>
<script src="jgcharts.js" type="text/javascript"></script>
<?php
function enumerate($idx, $buffer, $buckets) {
	global $enumerated_sQueries;
	if ($idx < count ( $buckets )) {
		for($i = 0; $i < count ( $buckets [$idx] ); $i ++) {
			$buffer [$idx] = $buckets [$idx] [$i];
			enumerate ( $idx + 1, $buffer, $buckets );
		}
	}
	if ($idx >= count ( $buckets )) {
		array_push ( $enumerated_sQueries, $buffer );
	}
}

$stopwords = [ 
		'a',
		'an',
		'and',
		'are',
		'as',
		'at',
		'be',
		'but',
		'by',
		'for',
		'if',
		'in',
		'into',
		'is',
		'it',
		'no',
		'not',
		'of',
		'on',
		'or',
		's',
		'such',
		't',
		'that',
		'the',
		'their',
		'then',
		'there',
		'these',
		'they',
		'this',
		'to',
		'was',
		'will',
		'with' 
];
?>

</head>

<body>
	<center>
		<p id="results"></p>
    		<?php
						$tables = array ();
						$tables ['city'] = [ 
								'name',
								'country',
								'province',
								'population',
								'longitude',
								'latitude' 
						];
						$tables ['borders'] = [ 
								'country1',
								'country2',
								'length' 
						];
						$tables ['continent'] = [ 
								'name',
								'area' 
						];
						$tables ['country'] = [ 
								'name',
								'code',
								'capital',
								'province',
								'area',
								'population' 
						];
						$tables ['desert'] = [ 
								'name',
								'area',
								'longitude',
								'latitude' 
						];
						$tables ['lake'] = [ 
								'name',
								'area',
								'depth',
								'altitude',
								'type',
								'river',
								'longitude',
								'latitude' 
						];
						$tables ['language'] = [ 
								'country',
								'name',
								'percentage' 
						];
						$tables ['ismember'] = [ 
								'country',
								'organization',
								'type' 
						];
						$tables ['island'] = [ 
								'name',
								'islands',
								'area',
								'height',
								'type',
								'longitude',
								'latitude' 
						];
						$tables ['ethnicgroup'] = [ 
								'country',
								'name',
								'percentage' 
						];
						$tables ['mountain'] = [ 
								'name',
								'mountains',
								'height',
								'type',
								'longitude',
								'latitude' 
						];
						$tables ['economy'] = [ 
								'country',
								'gdp',
								'agriculture',
								'service',
								'industry',
								'inflation' 
						];
						$tables ['encompasses'] = [ 
								'country',
								'continent',
								'percentage' 
						];
						$tables ['organization'] = [ 
								'abbreviation',
								'name',
								'city',
								'country',
								'province',
								'established' 
						];
						$tables ['politics'] = [ 
								'country',
								'independence',
								'dependent',
								'government' 
						];
						$tables ['population'] = [ 
								'country',
								'population_growth',
								'infant_mortality' 
						];
						$tables ['province'] = [ 
								'name',
								'country',
								'population',
								'area',
								'capital',
								'capprov' 
						];
						$tables ['religion'] = [ 
								'country',
								'name',
								'percentage' 
						];
						$tables ['river'] = [ 
								'name',
								'river',
								'lake',
								'sea',
								'length',
								'sourcelongitude',
								'sourcelatitude',
								'mountains',
								'sourcealtitude',
								'estuarylongitude',
								'estuarylatitude' 
						];
						$tables ['sea'] = [ 
								'name',
								'depth' 
						];
						$refTables = array ();
						$refTables ['country'] = [ 
								'borders',
								'encompasses',
								'ismember',
								'locatedon' 
						];
						$refTables ['continent'] = [ 
								'encompasses' 
						];
						$refTables ['organization'] = [ 
								'ismember' 
						];
						$refTables ['city'] = [ 
								'locatedon' 
						];
						$refTables ['province'] = [ 
								'locatedon' 
						];
						if (isset ( $_GET ["query"] )) {
							$q = $_GET ["query"];
							$formTerms = array (); // Set of all form terms //
							$formIds = array ();
							$formScores = array ();
							$deadForms = array (); // set of all dead forms identified //
							$sQueries = array (); // Enumeration of all frorm terms obtained for each query term //
							$keywords = explode ( " ", trim ( $q ) );
							global $qTime;
							foreach ( $keywords as $word ) {
								if (! (in_array ( $word, $stopwords ))) {
									$sQuery = array (); // bucket for each query term //
									
									$code = file_get_contents ( 'http://localhost:8983/solr/core0/select?q=docText%3A%22' . $word . '%22' . '&wt=php&indent=true' );
									eval ( "\$results = " . $code . ";" );
									$qTime += $results ['responseHeader'] ['QTime'];
									if ($results ['response'] ['numFound'] > 0) {
										$docs = $results ['response'] ['docs'];
										foreach ( $docs as $pair ) {
											$result_tables = explode ( "::", $pair ['id'] );
											$table_name = $result_tables [0];
											?><p><?php
											// echo $table_name;
											?></p><?php
											$primary_docId = substr ( $pair ['docId'], 0, - 1 );
											?><p><?php
											// echo $primary_docId;
											?></p><?php
											$tuple_ids = explode ( ";", $primary_docId );
											$primary_atts = array ();
											$primary_vals = array ();
											foreach ( $tuple_ids as $tuple_id ) {
												$keyValues = explode ( ":", $tuple_id );
												
												array_push ( $primary_atts, $keyValues [0] );
												array_push ( $primary_vals, $keyValues [1] );
											}
											// print_r ( $table_name );
											if (! (in_array ( $table_name, $formTerms ))) {
												array_push ( $formTerms, $table_name );
												array_push ( $sQuery, $table_name );
												// foreach ( $tables [$table_name] as $column_name ) {
												// array_push ( $formTerms, $column_name );
												// array_push ( $sQuery, $column_name );
												// }
												
												// Search for reference tables to identify dead forms //
												// $references = $refTables[$table_name];
											}
										}
									} else {
										?><p><?php
										// echo 'No dataIndex found' . $word;
										?></p><?php
									}
									
									if (! (in_array ( $word, $formTerms ))) {
										array_push ( $formTerms, $word );
										array_push ( $sQuery, $word );
									}
									
									array_push ( $sQueries, $sQuery );
								}
							}
							// print_r($sQueries);
							// Enumeration of sQueries //
							$enumerated_sQueries = array ();
							$buffer = array ();
							enumerate ( 0, $buffer, $sQueries );
							foreach ( $enumerated_sQueries as $enums ) {
								?><p><?php
								// print_r ( $enums );
								?></p><?php
							}
							
							if (count ( $enumerated_sQueries ) > 0) {
								foreach ( $enumerated_sQueries as $qTerms ) {
									$formURL = 'http://localhost:8983/solr/core1/select?q=';
									foreach ( $qTerms as $qWord ) {
										$formURL .= 'formText%3A%22' . $qWord . '%22+OR+';
									}
									// }
									$formURL = substr ( $formURL, 0, - 4 );
									$formscode = file_get_contents ( $formURL . '&wt=php&indent=true&fl=*,score' );
									// echo $formURL;
									eval ( "\$form_results = " . $formscode . ";" );
									$qTime += $form_results ['responseHeader'] ['QTime'];
									$forms = $form_results ['response'] ['docs'];
									foreach ( $forms as $pair ) {
										$formId = $pair ['formId'];
										$formScore = intval ( $pair ['score'], 10 );
										if (! (in_array ( $formId, $formIds ))) {
											array_push ( $formIds, $formId );
											$formScores [$formId] = $formScore;
										} else if (intval ( $formScores [$formId] ) < $formScore) {
											$formScores [$formId] = $formScore;
										}
										// print_r($formId);
									}
									
									// print_r ( $formIds );
								}
								
								if (count ( $formIds ) > 0) {
									echo 'Number of formms retrieved ' . count ( $formIds );
									?><p><?php
									echo 'Time taken ' . $qTime . ' milliseconds';
									?></p><?php
									
									// $columns = $tables [$formIds [0]];
									// Connecting, selecting database
								//	arsort ( $formScores );
									foreach ( $formScores as $form_name => $score ) {
										// foreach ( $formIds as $form_name ) {
										?>
																		<h1><?php echo $form_name?></h1>
		<p>
		
		
		<form action="<?php echo $form_name . '.php' ;?>" method="post">
																		<?php
										$columns = $tables [$form_name];
										foreach ( $columns as $column_name ) {
											echo $column_name;
											?> <select name="<?php echo $column_name;?>_op">
				<option name="like" value="LIKE">LIKE</option>
				<option name="eq" value="=">=</option>
				<option name="lt" value="&lt;">&lt;</option>
				<option name="le" value="<="><=</option>
				<option name="gt" value=">">></option>
				<option name="ge" value=">=">>=</option>


			</select> <input type="text" name="<?php echo $column_name; ?>"></input>
			</br>
																			<?php
										}
										?>
																		<button type="button">Reset</button>
			<input type="submit" name="<?php echo $form_name;?>-submit">


		</form>
		</p>
																		<?php
									}
								} else {
									echo 'No relevant forms found.';
								}
							} else {
								echo 'No Results found. Try a new query';
							}
						} else {
							echo 'Enter keywords for the query';
						}
						?></center>
</body>

</html>