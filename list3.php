<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/includes/header.php");
?>

<!-- page start -->
<p>OBS! Listan visar max <b><? echo  ENIRO_MAX?></b> adress(er) åt gången.</p>
<table width="100%" border="0">
<?
$op = $_SERVER['REMOTE_USER'];
$week = get_week_number($mytime, -5);
$mynow = sprintf("%04d-%02d-%02d 00:00:00", $today[year], $today[mon], $today[mday]);
if(is_null($op)) {
	echo "Inga poster.";
}
else {
	$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
	or die ('Cannot connect to the database: ' . mysql_error());
	mysql_select_db ("quicotse_bill");

		$query = "SELECT *
		FROM ".$xsite."_panel
		WHERE distrikt
		NOT IN (
		SELECT distrikt
		FROM (
		SELECT distrikt, count( svar ) AS antal
		FROM ".$xsite."_panel
		WHERE medlem = 'J'
		GROUP BY distrikt
		) AS tl
		WHERE antal >= " . MAX_NEW_MEMBER . "
		ORDER BY distrikt
		)
		AND medlem = 'E'
		AND op = '" . $op . "'
		AND kontroll < 3
		AND vecka <= '" . $week . "'
		AND tid < '$mynow'
		ORDER BY distrikt
		LIMIT " . ENIRO_MAX . ";";
		//om antal > 7 så visas nivå 7, 6, 5, 4  osv

	$result = mysql_query($query)
	or die("Cannot get data from the database:"  . mysql_error());
	while($row = mysql_fetch_assoc($result)) {
			echo "<tr class=\"monkeyface1\" onmouseover=\"this.className = 'monkeyface2'\" onmouseout=\"this.className = 'monkeyface1'\">\n";
		echo "<td NOWRAP>" . $row['distrikt'] . "</td>\n";
		echo "<td NOWRAP><a href=callto:+46" . str_replace(" ", "", substr($row['telefon'], 1)) . " class=slimface>0" . substr($row['telefon'], 1)  . "</a></td>\n";
		echo "<td NOWRAP><a href=\"edit3.php?tel=" . urlencode($row['telefon']) . "\"  class=slimface>" . $row['namn'] . "</a></td>\n";
		echo "<td NOWRAP>" . $row['adress'] . ", " . $row['postadress'] . " " . $row['ort'] . "</td>\n";
		echo "</tr>\n";
	}
	mysql_free_result($result);
}



?>

</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/includes/footer.php"); ?>
