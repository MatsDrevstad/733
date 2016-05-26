<?
$t = $_GET['t'];

$yesterdaytime  = mktime(0, 0, 0, date("m")  , date("d")-$t, date("Y"));
$t--;

include_once realpath(dirname(__FILE__)."/../includes/config.php");
include_once realpath(dirname(__FILE__)."/../includes/functions.php");

$mytime = time() + (DAYDIFF * 24 * 60 * 60);
$today = getdate($mytime);
$week1 = substr(get_week_number($mytime, 0), 4);
$week2 = get_week_number($mytime, -OFFSET_DAYS);
$css = CSS;
$op = $_SERVER['REMOTE_USER'];
$mynow = sprintf("%04d-%02d-%02d", $today[year], $today[mon], $today[mday]);
$xsite = get_fold_name(1);


?>
<html>
<head>
<title>Untitled Document</title>
<?
if ($t > -1) {
?>
<meta http-equiv="refresh" content="2;URL=kal_tid_loop.php?t=<? echo $t ?>">
<?
}
?>

</head>


<body bgcolor="#FFFFFF">

<?



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



jaha

</body>
</html>