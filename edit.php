<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/includes/header.php");
?>

<!-- page start -->
<script language="JavaScript">
function Checkform (s) {


	re = /answer/;

	if(!s.kommentar.value.match(re)) {
		alert("VARNING: Kommentar ej korrekt angiven! Påbörja kommentaren efter ([answer]): ");
	}

	if (s.svar[2].checked) {
		if (!(s.ad[0].checked || s.ad[1].checked || s.ad[2].checked)) {
			alert("Du glömde svara på följfrågan 'Stämmer adressen'");
			return false;
		}

		if (s.ad[1].checked) {
			alert("Sätt ett Vet ej istället som svar!");
			return false;
		}

		if (!(s.lp[0].checked || s.lp[1].checked || s.lp[2].checked) && s.kategori.value == 1) {
			alert("Du glömde svara på följfrågan 'Är porten låst mitt på dagen?'");
			return false;
		}
	}

	if (s.svar[0].checked || s.svar[1].checked || s.svar[2].checked || s.svar[3].checked) {
		return true;
	}
	else {
		alert ("Du glömde svara Ja/Nej/Vet inte/Ej svar.");
		return false;
	}

}
</script>
<?
if ($_GET["page"] == "3") {
	$page = "list3.php";
}
else {
	$page = "list.php";
}

?>
  <table width="100%" border="0">
<form name="form1" method=POST action=update.php onsubmit="return Checkform(this);">
<input type=hidden name=telefon value="<?php echo $_GET["telefon"] ?>">
<input type=hidden name=optid value="<?php echo $_GET["optid"] ?>">
<input type=hidden name=page value="<?php echo $page ?>">
    <?
$telefon = $_GET["telefon"];
$week = get_week_number($mytime, -5);
$op = $_SERVER['REMOTE_USER'];
$mynow = $today[year] . "-" . substr("0" .$today[mon], strlen($today[mon])-1) . "-" . substr("0" .$today[mday], strlen($today[mday])-1) . " " . substr("0" .$today[hours], strlen($today[hours])-1) . ":" . substr("0" . $today[minutes], strlen($today[minutes])-1) . " (" . $op . ")([answer]): ";

if(is_null($telefon)) {
	echo "Inga poster.";
}
else {
	$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
	or die ('Cannot connect to the database: ' . mysql_error());
	mysql_select_db ("quicotse_bill");

	$query = "SELECT ".$xsite."_panel.distrikt, ".$xsite."_svar.id, ".$xsite."_svar.vecka, ".$xsite."_svar.tid, ".$xsite."_panel.telefon,
".$xsite."_panel.adress, ".$xsite."_panel.postadress, ".$xsite."_panel.ort, ".$xsite."_panel.namn, ".$xsite."_svar.op,
".$xsite."_panel.kommentar, ".$xsite."_panel.trycksaker, ".$xsite."_panel.uppdrag, ".$xsite."_svar.svar,
".$xsite."_panel.lp, ".$xsite."_panel.ad, ".$xsite."_svar.nt, ".$xsite."_svar.sp, ".$xsite."_panel.kategori
FROM ".$xsite."_panel
LEFT JOIN ".$xsite."_svar ON ".$xsite."_panel.telefon = ".$xsite."_svar.telefon
WHERE ".$xsite."_panel.telefon = '" . $telefon . "'
ORDER BY ".$xsite."_svar.tid DESC
LIMIT 1;";

//By default, the quantifiers are "greedy", that is, they match as much as possible (up to the maximum number of permitted times), without causing the rest of the pattern to fail. The classic example of where this gives problems is in trying to match comments in C programs. These appear between the sequences /* and */ and within the sequence, individual * and / characters may appear. An attempt to match C comments by applying the pattern /\*.*\*/ to the string /* first comment */ not comment /* second comment */ fails, because it matches the entire string due to the greediness of the .* item.
//However, if a quantifier is followed by a question mark, then it ceases to be greedy, and instead matches the minimum number of times possible, so the pattern /\*.*?\*/ does the right thing with the C comments. The meaning of the various quantifiers is not otherwise changed, just the preferred number of matches. Do not confuse this use of question mark with its use as a quantifier in its own right. Because it has two uses, it can sometimes appear doubled, as in \d??\d which matches one digit by preference, but can match two if that is the only way the rest of the pattern matches.
$patterns[0] = '/( \(.+?\))*/';
$replacement = '';
$show_edition = SHOW_EDITION;

	$result = mysql_query($query)
	or die("Cannot get data from the database:"  . mysql_error());
	while($row = mysql_fetch_assoc($result)) {
		echo "<tr>\n";
		echo "<td NOWRAP>" . $row['distrikt'] . "</td>\n";
		if (is_null($row['vecka'])) {
			$vecka = 'Ny';
		}
		else {
			$vecka = $row['vecka'];
		}
		echo "<td NOWRAP>" . $vecka . "</td>\n";
		echo "<td NOWRAP> " . get_kategori($row['kategori']) . "</td>\n";
		echo "<td NOWRAP><a href=callto:+46" . str_replace(" ", "", substr($row['telefon'], 1)) . ">0" . substr($row['telefon'], 1)  . "</a></td>\n";
		echo "<td NOWRAP>" . $row['adress'] . ", " . $row['postadress'] . " " . $row['ort'] . "</td>\n";
		echo "<td NOWRAP>" . $row['namn'] . "</td>\n";
		echo "<td NOWRAP>" . $row['op'] . "</td>\n";
		if ($show_edition == 'Ja') {
    		echo "</tr><tr><td colspan=7><i>" . $row['trycksaker'] . "</i></td>\n";
		}
		else {
    		echo "</tr><tr><td colspan=7><i>" . preg_replace($patterns, $replacement, $row['trycksaker']) . "</i></td>\n";
		}
		echo "</tr>\n";
		if (!empty($row['uppdrag'])) {
   			echo "<tr><td colspan=7 class=red><b>" . $row['uppdrag'] . "</b></td></tr>\n";
   		}
	$kategori = $row['kategori'];
	$svar = $row['svar'];
	$lp = $row['lp'];
	$ad = $row['ad'];
	$ntcheck = $row['nt'];
	$spcheck = $row['sp'];
	$id = $row['id'];
	$distrikt = $row['distrikt'];
	$vecka = $row['vecka'];
	$svaratdag = substr($row['tid'], 8, 2);
	$kommentar = $row['kommentar'];

	}

	echo "<input type=hidden name=vecka  value=" . $week . ">";
	echo "<input type=hidden name=id  value=" . $id . ">";
	echo "<input type=hidden name=distrikt value=" . $distrikt . ">";
	//kategori andvänds vid checkform
	echo "<input type=hidden name=kategori value=" . $kategori . ">";

	if ($week == $vecka) {

		switch ($svar) {
		case "E":
			$e = "checked";
		   break;
		case "J":
			$j = "checked";
		   break;
		case "N":
			$n = "checked";
		   break;
		case "V":
			$v = "checked";
		   break;
		}

		//markera ja/nej/vet ej checked och sätt redansvarat = 1 för sql updatering om svaret redan finns.
		//markera "ej svar" och sätt redansvarat = 1 för sql updatering.
		//observera att "ej svar" ska vara icke checked om det är en ny dag eftersom dom får en chans per dag att svara.

		$idag = substr("0" .$today[mday], strlen($today[mday])-1);

		// eftersom dom får en chans per dag att svara.
		// så om det inte är samma dag så skall alltså svar E inte vara checked och redansvarat = "" (inte vara 1)

		if (($svaratdag != $idag) && $e == "checked") {

			$e = "";
		}
		else {
			echo "<input type=hidden name=redansvarat value=1>";
		}

		if ($ntcheck == '1') {
			$ntcheck = 'checked';
		}
		else {
			$ntcheck = '';
		}

		if ($spcheck == '1') {
			$spcheck = 'checked';
		}
		else {
			$spcheck = '';
		}
	}

	mysql_free_result($result);
}

?>
    <tr valign="top">
      <td NOWRAP colspan=4> <br>
        <table width="333" border="0">
          <tr>
            <td>
              <input type="radio" name="svar" value="E" <? echo $e ?>>
              Ej svar</td>
            <td>
              <input type="radio" name="svar" value="J" <? echo $j ?>>
              Ja</td>
            <td>
              <input type="radio" name="svar" value="N" <? echo $n ?>>
              Nej</td>
          </tr>
          <tr>
            <td>
              <input type="radio" name="svar" value="V" <? echo $v ?>>
              Vet ej</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp; </td>
            <td>&nbsp;</td>
            <td>&nbsp; </td>
          </tr>
        </table>
        Följdfrågor:
        <table width="333" border="0" cellpadding="6">
          <tr>
            <td>St&auml;mmer adressen?<br>
              <input type="radio" name="ad" value="2" <? echo write_checked($ad, 2) ?>>
              Ja<br>
              <input type="radio" name="ad" value="1" <? echo write_checked($ad, 1) ?>>
              Nej<br>
              <input type="radio" name="ad" value="3" <? echo write_checked($ad, 3) ?>>
              Glömde fråga/fick inget svar.</td>
          </tr>
          <tr>
            <td>
              <p>Är porten låst mitt på dagen?<br>
                <input type="radio" name="lp" value="1" <? echo write_checked($lp, 1) ?>>
				<? echo get_adressanswer(1) ?><br>
                <input type="radio" name="lp" value="2" <? echo write_checked($lp, 2) ?>>
				<? echo get_adressanswer(2) ?><br>
                <input type="radio" name="lp" value="3" <? echo write_checked($lp, 3) ?>>
				<? echo get_adressanswer(3) ?><br>
              </p>
              </td>
          </tr>
        </table>
      </td>
      <td NOWRAP colspan=4> <br>
        <input type="checkbox" name="nt" value="1" <? echo $ntcheck ?>>
          Utträde/&quot;Nej tack&quot; nyss &auml;r uppsatt<br>
          <input type="checkbox" name="sp" value="1" <? echo $spcheck ?>>
        SPECIAL. Övrigtfältet bör följas upp snarast.<br><br>
        &Ouml;vrigt: <br>

        <textarea name="kommentar" cols="70" rows="12"><? echo $kommentar ?><? echo "\n" . $mynow ?></textarea>
          <br>
        <input type="submit" name="Submit" value="Spara">
      </td>
  </tr>
</form>
</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/includes/footer.php"); ?>





