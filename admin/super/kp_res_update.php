<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../../includes/header.php");
?>

<!-- page start -->

<?
$vecka = get_week_number($mytime, -5);

$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

// fixa riktiga veckor med år från panel till kp.
$query = "SELECT ".$xsite."_panel.telefon, ".$xsite."_panel.vecka
FROM ".$xsite."_panel, ".$xsite."_kp
WHERE ".$xsite."_panel.telefon = ".$xsite."_kp.telefon";

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

while($row = mysql_fetch_assoc($result)) {

	$arvecka[$row['telefon']] = $row['vecka'];
}

mysql_free_result($result);

// uppdatera kp
foreach ($arvecka as $key => $value) {

	if(!empty($value)) {

		$query = "update ".$xsite."_kp set vecka2 = '$value' where telefon = '$key';";

		// echo $query . "<br>";

		mysql_query($query)
		or die("Cannot get data from the database:"  . mysql_error());

	}
}

// börja populera array med J och N
$query = "SELECT telefon, svar FROM ".$xsite."_panel WHERE svar = 'J' or svar = 'N'";

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

while($row = mysql_fetch_assoc($result)) {

	$arpost[$row['telefon']] = $row['svar'];
}

mysql_free_result($result);

// uppdatera med riktiga svar
foreach ($arpost as $key => $value) {

	if(!empty($value)) {

		$query = "update ".$xsite."_kp set svar = '$value' where telefon = '$key';";

		// echo $query . "<br>";

		mysql_query($query)
		or die("Cannot get data from the database:"  . mysql_error());

	}
}

// uppdatera med falska svar
for ($i=0;;$i++) {

	$query = "SELECT *
	FROM ".$xsite."_kp
	WHERE distrikt
	NOT IN (
		SELECT distrikt
		FROM (
			SELECT distrikt, count( svar ) AS antal
			FROM ".$xsite."_kp
			WHERE svar = 'J'
			OR svar = 'N'
			GROUP BY distrikt
		) AS tl
		WHERE antal > 1
		ORDER BY distrikt
	)
	AND trycksaker != ''
	ORDER BY vecka2
	LIMIT 1;";

	$result = mysql_query($query)
	or die("Cannot get data from the database:"  . mysql_error());

	$row = mysql_fetch_assoc($result);

	if (mysql_num_rows($result) == 0 || $i==999) {
		echo "End of file<br><br>";

		if ($i==999) {
			echo "Fel: Det finns inte tillräckligt med kontrollpunkter.<br>
			Möjlig lösning: ta bort den sista personen från xxx_kp eller xxx_panel.<br>
			Tänk på att det även i excelfilen måste finnas minst 2 stycken,<br>
			även om det ser bra ut i sammanställningen ";

		}
		break;

	}
	else {

		$query = "update ".$xsite."_kp set svar = 'J', vecka2 = '" . $vecka . "' where telefon = '" . $row['telefon'] . "';";

		echo $query . "<br>";

		mysql_query($query)
		or die("Cannot get data from the database:"  . mysql_error());
	}
}

mysql_free_result($result);

// börja populera array med U
$query = "SELECT ".$xsite."_panel.telefon, ".$xsite."_svar.nt
FROM ".$xsite."_panel, ".$xsite."_svar
WHERE ".$xsite."_panel.telefon = ".$xsite."_svar.telefon
AND ".$xsite."_svar.nt = 1
AND ".$xsite."_svar.vecka = '$vecka';";

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

$patterns2[0] = '/^1$/';
$replacement2 = 'U';

while($row = mysql_fetch_assoc($result)) {

	$arnejtack[$row['telefon']] = preg_replace($patterns2, $replacement2, $row['nt']);

}

mysql_free_result($result);

// uppdatera med U
if (!is_null($arnejtack)) {
	foreach ($arnejtack as $key => $value) {

		if(!empty($value)) {

			$query = "update ".$xsite."_kp set svar = CONCAT(svar, '$value') where telefon = '$key';";

			// echo $query . "<br>";

			mysql_query($query)
			or die("Cannot get data from the database:"  . mysql_error());

		}
	}
}

mysql_close($connection);

?>

</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../../includes/footer.php"); ?>