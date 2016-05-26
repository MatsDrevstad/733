<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../includes/header.php");
?>

<!-- page start -->
<table width="999" border="0">
<?
$tid = $_GET['tid'];

if (is_null($tid)) {
	echo "ange tid";
}
else {
		$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
		or die ('Cannot connect to the database: ' . mysql_error());
		mysql_select_db ("quicotse_bill");

		$query = "SELECT count( svar ) AS svar , op, MIN( tid ) AS min, MAX( tid ) AS max
		FROM ".$xsite."_svar
		WHERE tid LIKE '" . $tid . "%'
		AND optid = '1'
		GROUP BY op;";

		$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

			echo "<tr><td>&nbsp;</td>\n";
			echo "<td>start</td>\n";
			echo "<td>stop</td>\n";
			echo "<td>försök</td>\n";
			echo "<td>tid*</td>\n";
			echo "<td>samtalsförsök/10h*</td></tr>\n";

		while($row = mysql_fetch_assoc($result)) {

			echo "<tr><td>" . $row['op'] ."</td>\n";
			echo "<td>" . $row['min'] . "</td>\n";
			echo "<td>" . $row['max'] . "</td>\n";
			echo "<td>" . $row['svar'] . "</td>\n";
			if( $diff=@get_time_difference(substr($row['min'], 11, 5), substr($row['max'], 11, 5)) ) {
		    	$tottime = sprintf( '%02d', $diff['minutes'] );
				$tottime = $tottime + 60*sprintf( '%02d', $diff['hours'] );
				$tottime = $tottime+2;
			}
			if( $tottime < 0.1 ) {
		    	$tottime = $tottime * -1;
			}
			echo "<td>" . round($tottime/60, 2) . "</td>\n";
			echo "<td>" . 10*round(60*$row['svar']/$tottime, 1) . "</td></tr>\n";
			}
			mysql_free_result($result);
		$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
		or die ('Cannot connect to the database: ' . mysql_error());
		mysql_select_db ("quicotse_bill");

		$query = "SELECT count( svar ) AS svar , op, MIN( tid ) AS min, MAX( tid ) AS max
		FROM ".$xsite."_svar
		WHERE (svar = 'J' OR svar = 'N')
		AND tid LIKE '" . $tid . "%'
		AND optid = '1'
		GROUP BY op;";

		$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());


			echo "<tr><td>&nbsp;</td>\n";
			echo "<td>start</td>\n";
			echo "<td>stop</td>\n";
			echo "<td>svar</td>\n";
			echo "<td>tid*</td>\n";
			echo "<td>svar/10h*</td></tr>\n";

		while($row = mysql_fetch_assoc($result)) {

			echo "<tr><td>" . $row['op'] ."</td>\n";
			echo "<td>" . $row['min'] . "</td>\n";
			echo "<td>" . $row['max'] . "</td>\n";
			echo "<td>" . $row['svar'] . "</td>\n";
			if( $diff=@get_time_difference(substr($row['min'], 11, 5), substr($row['max'], 11, 5)) ) {
		    	$tottime = sprintf( '%02d', $diff['minutes'] );
				$tottime = $tottime + 60*sprintf( '%02d', $diff['hours'] );
				$tottime = $tottime+2;
			}
			if( $tottime < 0.1 ) {
		    	$tottime = $tottime * -1;
			}
			echo "<td>" . round($tottime/60, 2) . "</td>\n";
			echo "<td>" . 10*round(60*$row['svar']/$tottime, 1) . "</td></tr>\n";
			}
			mysql_free_result($result);
}

			echo "<tr><td colspan=6>* Första samtalet antas ta 2 minuter.</td></tr>\n";

?>
</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../includes/footer.php"); ?>
