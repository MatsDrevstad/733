<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/includes/header.php");
?>

<!-- page start -->
<?
echo "<p>" . MISSION . "</p>";
$op = $_SERVER['REMOTE_USER'];
$week = get_week_number($mytime, -5);
$preweek = $week-MIN_NEXTCALL;
$flats_only = FLATS_ONLY;
$q_kategori = 2;
$repset = -1; //OBS variabel, ändra ej här. default, dvs ring alla. XXX_panel.rapporterad har värdena 0 eller 1
$call_reported_only = CALL_REPORTED_ONLY;

if(is_null($op)) {
	echo "Inga poster.";
}
else {
	$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
	or die ('Cannot connect to the database: ' . mysql_error());
	mysql_select_db ("quicotse_bill");

	//Om det är söndag kontrollera enbart kontroll = 1
	if($today['wday'] == 0) {
		$q_kontroll = '1';
	}
	else {
		$q_kontroll = '2';
	}

	//Om det är söndag kontrollera flats_only inställningen
	if($today['wday'] == 0 && $flats_only > 0) {
		$q_kategori = 1;
	}

	//flats_only = 2, dvs kolla alltid enbart lägenheter.
	if($flats_only == 2) {
		$q_kategori = 1;
	}

	//Kolla $call_reported_only för söndagar
	if($today['wday'] == 0 && $call_reported_only > -1 ) {
		$repset = '0'; //kolla enbart rapporterade, dvs de som har en 1
	}

	//Kolla $call_reported_only för måndagar
	if($today['wday'] == 1 && $call_reported_only == 1) {
		$repset = '0'; //kolla enbart rapporterade, dvs de som har en 1
	}

	//Kolla $call_reported_only för inställningen samtilga dagar, (används nog mycket sällan)
	if($call_reported_only == 2) {
		$repset = '0'; //kolla enbart rapporterade, dvs de som har en 1
	}


	$query = "SELECT * FROM ".$xsite."_panel
	WHERE kontroll <= '" . $q_kontroll . "'
	AND medlem = 'J'
	AND vecka <= '" . $preweek . "'
	AND kategori <= '" . $q_kategori . "'
	AND rapporterad > '" . $repset . "'
	AND op = '" . $op . "'
	ORDER BY vecka;";

	$result = mysql_query($query)
	or die("Cannot get data from the database:" . mysql_error());

	$count = mysql_num_rows($result);

		echo "<table width=100% border=0>\n";
		echo "  <tr>\n";
		echo "    <td nowrap><b># (" . $count . ")</b></td>\n";
		echo "    <td><b>Distrikt</b></td>\n";
		echo "    <td><b>Vecka</b></td>\n";
		echo "    <td><b>Kat.</b></td>\n";
		echo "    <td><b>Telefon</b></td>\n";
		echo "    <td><b>Namn</b></td>\n";
		echo "    <td><b>Adress</b></td>\n";
		echo "    <td><b>Op</b></td>\n";
		echo "  </tr>\n";

	while($row = mysql_fetch_assoc($result)) {

		if ($count <= MAX_MEMBER) {

			if ($row['svar'] == 'J' OR $row['svar'] == 'N') {
				echo "<tr class=\"monkeyface3\" onmouseover=\"this.className = 'monkeyface2'\" onmouseout=\"this.className = 'monkeyface3'\">\n";
			}
			elseif ($row['svar'] == 'V') {
				echo "<tr class=\"monkeyface4\" onmouseover=\"this.className = 'monkeyface4'\" onmouseout=\"this.className = 'monkeyface4'\">\n";
			}
			elseif ($row['svar'] == 'E') {

				//markera "ej svar" med en viss färg.
				//observera att "ej svar" får standardfärg om det är en ny dag eftersom dom får en chans per dag att svara.

				$idag = $today[mday];
				$svaratdag = $row['dag'];

				if (($svaratdag == $idag)) {
					echo "<tr class=\"monkeyface5\" onmouseover=\"this.className = 'monkeyface5'\" onmouseout=\"this.className = 'monkeyface5'\">\n";
				}
				else {
					echo "<tr class=\"monkeyface1\" onmouseover=\"this.className = 'monkeyface2'\" onmouseout=\"this.className = 'monkeyface1'\">\n";
				}
			}
			else {
				echo "<tr class=\"monkeyface1\" onmouseover=\"this.className = 'monkeyface2'\" onmouseout=\"this.className = 'monkeyface1'\">\n";
			}
			echo "<td align=center>" . $count . "</td>\n";
			echo "<td align=right>" . $row['distrikt'] . "</td>\n";
			echo "<td align=right>" . $row['vecka'] . "</td>\n";
			echo "<td align=center>" . $row['kategori'] . "</td>\n";
			echo "<td NOWRAP>" . $row['telefon'] . "</td>\n";
			echo "<td NOWRAP><a href=edit.php?optid=1&telefon=" . urlencode($row['telefon']) . ">" . $row['namn'] . "</a></td>\n";
			echo "<td NOWRAP>" . $row['adress'] . ", " . $row['postadress'] . " " . $row['ort'] . "</td>\n";
			echo "<td NOWRAP>" . $row['opinnan'] . "</td>\n";
			echo "</tr>\n";
		}

		$count = $count - 1;
	}
	mysql_free_result($result);

	mysql_close($connection);
}

echo "</table>";
?>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/includes/footer.php"); ?>
