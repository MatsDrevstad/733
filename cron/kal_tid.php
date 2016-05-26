<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../includes/header.php");
?>

<!-- page start -->
<?
/*
denna bör funka men i inför applikationstrukturen tog jag bort den


if (!is_null($t) && $t > 1) {
?>
<meta http-equiv="refresh" content="2;URL=kal_tid.php?t=<? echo $t ?>">
<?
}
else {
$t = 1;
}
?>

*/

$t = 1;

//$yesterdaytime  = mktime(0, 0, 0, date("m")  , date("d")-$t, date("Y"));
$yesterdaytime  = $mytime - (24 * 60 * 60);
$yesterday = date("Y-m-d", $yesterdaytime);

$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

$query = "SELECT count( svar ) AS svar , op, MIN( tid ) AS min, MAX( tid ) AS max
FROM ".$xsite."_svar
WHERE tid LIKE '" . $yesterday . "%'
AND optid = '1'
GROUP BY op;";

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

	$num_rows = mysql_num_rows($result);

	if( $num_rows > 0 ) {

		while($row = mysql_fetch_assoc($result)) {

			$op = $row['op'];
			$min = $row['min'];
			$max = $row['max'];
			$svar = $row['svar'];
			if( $diff=@get_time_difference(substr($row['min'], 11, 5), substr($row['max'], 11, 5)) ) {
			   	$tottime = sprintf( '%02d', $diff['minutes'] );
				$tottime = $tottime + 60*sprintf( '%02d', $diff['hours'] );
				$tottime = $tottime+2;
			}

			if( $tottime < 0.1 ) {
	   			$tottime = $tottime * -1;
			}
			$antal = round($tottime/60, 2);
			$medel = 10*round(60*$row['svar']/$tottime, 1);

			$query = "INSERT INTO ".$xsite."_tid (op, start1, stopp1, forsok, forsoktid, forsok10h)
			VALUES ('" . $op . "', '" . $min . "', '" . $max . "', '" . $svar . "',
			'" . $antal . "', '" . $medel . "');";

			mysql_query($query)
			or die("Cannot get data from the database:"  . mysql_error());

		}

		mysql_free_result($result);

		$query = "SELECT count( svar ) AS svar , op, MIN( tid ) AS min, MAX( tid ) AS max
		FROM ".$xsite."_svar
		WHERE (svar = 'J' OR svar = 'N')
		AND tid LIKE '" . $yesterday . "%'
		AND optid = '1'
		GROUP BY op;";

		$result = mysql_query($query)
		or die("Cannot get data from the database:"  . mysql_error());

		while($row = mysql_fetch_assoc($result)) {

			$op = $row['op'];
			$min = $row['min'];
			$max = $row['max'];
			$svar = $row['svar'];
			if( $diff=@get_time_difference(substr($row['min'], 11, 5), substr($row['max'], 11, 5)) ) {
			   	$tottime = sprintf( '%02d', $diff['minutes'] );
				$tottime = $tottime + 60*sprintf( '%02d', $diff['hours'] );
				$tottime = $tottime+2;
			}

			if( $tottime < 0.1 ) {
	   			$tottime = $tottime * -1;
			}
			$antal = round($tottime/60, 2);
			$medel = 10*round(60*$row['svar']/$tottime, 1);

			$query = "UPDATE ".$xsite."_tid SET
			svar = '" . $svar . "',
			svartid = '" . $antal . "',
			svar10h = '" . $medel . "'
			WHERE op = '" . $op . "'
			AND start1 LIKE '" . $yesterday . "%';";

			mysql_query($query)
			or die("Cannot get data from the database:"  . mysql_error());
		}
		mysql_free_result($result);
	}
	else {
			$query = "INSERT INTO ".$xsite."_tid (op, start1) VALUES ('', '" . $yesterday . " 00:00:00');";
			mysql_query($query)
			or die("Cannot get data from the database:"  . mysql_error());
	}

	mysql_close($connection);

?>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../includes/footer.php"); ?>
