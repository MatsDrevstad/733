<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n
<meta http-equiv=refresh content=0;URL=" . $_POST['page'] .">";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/includes/header.php");
?>

<!-- page start -->
  <table width="100%" border="0">
    <tr valign="top">
      <td NOWRAP><br>
Sparar..
<?

$svar = $_POST['svar'];
$arrkommentar3 = preg_split("/\[answer\]\):/", $_POST['kommentar']);
$kommentar3 = $arrkommentar3[1];
$kommentar3 = trim($kommentar3);
if (strlen($kommentar3)>0) {
	$kommentar3 = $svar . " (" . $kommentar3 . ")";
}
else {
	$kommentar3 = $svar;
}
$telefon = $_POST['telefon'];
$id = $_POST['id'];
$optid = $_POST['optid'];
$kommentar = str_replace("[answer]", $svar, $_POST['kommentar']);
$distrikt = $_POST['distrikt'];
$lp = $_POST['lp'];
$nt = $_POST['nt'];
$ad = $_POST['ad'];
$sp = $_POST['sp'];
$telefon = $_POST['telefon'];
$op = $_SERVER['REMOTE_USER'];
$redansvarat = $_POST['redansvarat'];
$vecka = $_POST['vecka'];

if ($redansvarat == "1") {

	$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
	or die ('Cannot connect to the database: ' . mysql_error());
	mysql_select_db ("quicotse_bill");

	$query = "SELECT ".$xsite."_panel.*, ".$xsite."_svar.*
	FROM ".$xsite."_panel, ".$xsite."_svar
	WHERE ".$xsite."_panel.telefon = ".$xsite."_svar.telefon
	AND ".$xsite."_svar.telefon = '" . $telefon . "'
	AND ".$xsite."_svar.vecka = '" . $vecka . "'
	AND ".$xsite."_svar.svar = 'N';";
	$result = mysql_query($query)
	or die("Cannot get data from the database:" . mysql_error());

	if (mysql_num_rows($result) == 1 && $svar != 'N') {
		$query = "UPDATE ".$xsite."_bokning set nejsvar = nejsvar - 1
		WHERE distrikt = '" . $distrikt . "'
		AND vecka = '" . $vecka . "';";
		mysql_query($query)
		or die("Cannot get data from the database:"  . mysql_error());
	}

	if (mysql_num_rows($result) == 0 && $svar == 'N') {
		$query = "UPDATE ".$xsite."_bokning set nejsvar = nejsvar + 1
		WHERE distrikt = '" . $distrikt . "'
		AND vecka = '" . $vecka . "';";
		mysql_query($query)
		or die("Cannot get data from the database:"  . mysql_error());
	}


	$query = "update ".$xsite."_bokning
	SET kommentar3 = concat(kommentar3, '" . $kommentar3 . "')
	WHERE distrikt = '" . $distrikt . "'
	AND vecka = '" . $vecka . "';";
	mysql_query($query)
	or die("Cannot get data from the database:"  . mysql_error());


	$query = "update ".$xsite."_svar set
	svar = '" . $svar . "',
	nt = '" . $nt . "',
	ad = '" . $ad . "',
	sp = '" . $sp . "'
	where id = '" . $id . "';";
	mysql_query($query)
	or die("Cannot get data from the database:"  . mysql_error());

	if ($svar == 'J' OR $svar == 'N') {
		$query = "update ".$xsite."_panel set
		lp = '" . $lp . "',
		ad = '" . $ad . "',
		dag = '" . $today[mday] . "',
		kommentar = '" . $kommentar . "',
		svar = '" . $svar . "',
		vecka = '" . $vecka . "'
		where telefon = '" . $telefon . "';";
	}
	else {
		$query = "update ".$xsite."_panel set
		lp = '" . $lp . "',
		ad = '" . $ad . "',
		dag = '" . $today[mday] . "',
		kommentar = '" . $kommentar . "',
		svar = '" . $svar . "'
		where telefon = '" . $telefon . "';";
	}

	mysql_query($query)
	or die("Cannot get data from the database:"  . mysql_error());

}
else {

	$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
	or die ('Cannot connect to the database: ' . mysql_error());
	mysql_select_db ("quicotse_bill");

	if ($svar == 'N') {
		$query = "UPDATE ".$xsite."_bokning set nejsvar = nejsvar + 1
		WHERE distrikt = '" . $distrikt . "'
		AND vecka = '" . $vecka . "';";
		mysql_query($query)
		or die("Cannot get data from the database:"  . mysql_error());
	}

	$query = "insert into ".$xsite."_svar (svar, optid, op, lp, nt, ad, sp, vecka, telefon)
	values ('". $svar . "','". $optid . "','". $op . "','". $lp . "','". $nt . "','". $ad . "','". $sp . "','". $vecka . "','". $telefon . "');";
	mysql_query($query)
	or die("Cannot get data from the database:"  . mysql_error());

	if ($svar == 'J' OR $svar == 'N') {
		$query = "update ".$xsite."_panel set
		lp = '" . $lp . "',
		ad = '" . $ad . "',
		dag = '" . $today[mday] . "',
		kommentar = '" . $kommentar . "',
		opinnan = '" . $op . "',
		svar = '" . $svar . "',
		vecka = '" . $vecka . "'
		where telefon = '" . $telefon . "';";
	}
	else {
		$query = "update ".$xsite."_panel set
		lp = '" . $lp . "',
		ad = '" . $ad . "',
		dag = '" . $today[mday] . "',
		kommentar = '" . $kommentar . "',
		svar = '" . $svar . "',
		opinnan = '" . $op . "'
		where telefon = '" . $telefon . "';";
	}

	mysql_query($query)
	or die("Cannot get data from the database:"  . mysql_error());

	$query = "update ".$xsite."_bokning
	SET kommentar3 = concat(kommentar3, '" . $kommentar3 . "')
	WHERE distrikt = '" . $distrikt . "'
	AND vecka = '" . $vecka . "';";
	mysql_query($query)
	or die("Cannot get data from the database:"  . mysql_error());

}

$query = "SELECT svar, maxsvar, jasvar, nejsvar_1, nejsvar_2, count(svar) AS antal
FROM ".$xsite."_panel
WHERE distrikt = '" . $distrikt . "'
GROUP BY svar, maxsvar, jasvar, nejsvar_1, nejsvar_2;";

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

/*
kolla rader. ska ju vara max 5 (en för varje svarstyp, inkl inget svar alls)
det är ju egentligen en bugg om det är fler.
Nu kan ju även olyckligtvis ex två ja svar även ha olika konfiguration men då
antas den första konfigurationen gälla. konf[0], se nedan.
buggen beror på att maxsvar, jasvar, nejsvar_1, nejsvar_2 felaktigt inte är samma för varje person i distriktet,
vilket det ju givetvis ska vara. sätt isåfall kontroll = 4
anledningen till att detta db designfel får finnas kvar är helt enkelt att jag vill att konfen ska kunna
skickas med i en enda tabell för framtiden när även site id finns med som inställning
*/

$count = mysql_num_rows($result);

if (mysql_num_rows($result) > 5) {
	$kontroll = 4;
}
else {

	$count = 0;
	$konf = array();

	while($row = mysql_fetch_assoc($result)) {

		//skapa en 2-dimentionell array
		$konf[$count] = array($row['svar'], $row['antal'], $row['maxsvar'], $row['jasvar'], $row['nejsvar_1'], $row['nejsvar_2']);
		$count++;
	}

	/*

	svar, antal, maxsvar, jasvar, nejsvar_1, nejsvar_2

	använd konf[0][N] för att visa konfvärden för alla svar.
	Det finns alltid nått svar (konfiguration) vid detta laget eftersm ett minst svar är registrerat.
	ta det första eftersom alla är lika.
	*/

	//kolla vart i arrayen som J svaren sitter.
	for ($i=0; $i<4; $i++) {

		if ($konf[$i][0] == 'J') {
			$ja_element = $i;
			break;
		}
		else {
			//använd ett element vars värden defenititv är ingenting, nått Ja-svar finns alltså inte.
			$ja_element = 99;
		}
	}

	//kolla vart i arrayen som N svaren sitter.
	for ($i=0; $i<4; $i++) {

		if ($konf[$i][0] == 'N') {
			$nej_element = $i;
			break;
		}
		else {
			//använd ett element vars värden defenititv är ingenting, nått Nej-svar finns alltså inte.
			$nej_element = 99;
		}
	}

	//kolla om maxsvar är uppfyllt
	$maxsvar_ = $konf[$ja_element][1] + $konf[$nej_element][1];

	if (!($maxsvar_ < $konf[0][2])) {
		$kontroll = 4;
	}

	//kolla om nejsvar_1 är uppfyllt på en söndag
	if($today['wday']==0) {

		if (!($konf[$nej_element][1] < $konf[0][4])) {
			$kontroll = 2;
		}
	}

	//kolla om nejsvar_2 är uppfyllt
	if (!($konf[$nej_element][1] < $konf[0][5])) {
		$kontroll = 4;
	}

	//kolla om jasvar är uppfyllt
	if (!($konf[$ja_element][1] < $konf[0][3])) {
		$kontroll = 4;
	}

}

if ($kontroll > 1) {

	$query = "update ".$xsite."_panel set kontroll = '" . $kontroll . "' where distrikt = '" . $distrikt . "';";
	mysql_query($query)
	or die("Cannot get data from the database:"  . mysql_error());

	// blanda inte inte "system-fyran" i den fina konf tabellen. Sätt en trea istället.
	$query = "update ".$xsite."_distrikt set kontroll = 3 where distrikt = '" . $distrikt . "';";
	mysql_query($query)
	or die("Cannot get data from the database:"  . mysql_error());
}

mysql_free_result($result);

mysql_close($connection);

?>

    </td>
  </tr>
</table>
<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/includes/footer.php"); ?>




