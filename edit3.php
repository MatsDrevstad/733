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

	//skicka till svarssidan om dessa villkor uppfylls

//gammal fel	if (!(form1.dagiveckan.value <= 1) || (form1.reset_answer.value <= form1.dagiveckan.value) || form1.medlem.value == 'N' || form1.medlem.value == 'E') {
	if ((form1.reset_answer.value < form1.dagiveckan.value) || form1.medlem.value == 'N' || form1.medlem.value == 'E') {
		document.form1.action = "update3.php";
	}
	else {
		document.form1.action = "update3answer.php";
	}

	if (s.medlem.selectedIndex < 0) {
		alert ("Du glömde att svara Ja eller Nej.");
		return false;
	}

	if (s.medlem.options[s.medlem.selectedIndex].value == 'J') {
		alert ('Bra jobbat! Ny medlem sparad!');
	}

	if (s.medlem.options[s.medlem.selectedIndex].value == 'N') {
		alert ('Tack! Numret arkiverat!');
	}

	if (s.medlem.options[s.medlem.selectedIndex].value == 'E') {
		alert ('Ej svar. Ring igen nån annan dag (max 5 gånger)!');
	}

	setDisabled();
	return true;
}

function setDisabled() {
	document.form1.Submit.disabled = true;
}

</script>

<?
$week = get_week_number($mytime, -5);
$dagiveckan = $today[wday];
$reset_answer = RESET_ANSWER;

?>
<form name="form1" method=POST onsubmit="return Checkform(this)">
  <input type=hidden name=telefon value="<?php echo $_GET["tel"] ?>">
  <input type=hidden name=telefon2 value="<?php echo $_GET["tel"] ?>">
  <input type=hidden name=dagiveckan value="<?php echo $dagiveckan ?>">
  <input type=hidden name=reset_answer value="<?php echo $reset_answer ?>">
  <input type=hidden name=week value="<?php echo $week ?>">
  <table width="100%" border="0">
    <?
$telefon = str_replace("_", " ", $_GET["tel"]);

if(is_null($telefon)) {
	echo "Inga poster.";
}
else {
	$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
	or die ('Cannot connect to the database: ' . mysql_error());
	mysql_select_db ("quicotse_bill");

	$query = "SELECT *
FROM ".$xsite."_panel
WHERE ".$xsite."_panel.telefon = '" . $telefon . "';";

	$result = mysql_query($query)
	or die("Cannot get data from the database:"  . mysql_error());
	while($row = mysql_fetch_assoc($result)) {
		echo "<tr class=\"monkeyface1\" onmouseover=\"this.className = 'monkeyface2'\" onmouseout=\"this.className = 'monkeyface1'\">\n";
		echo "<td NOWRAP>" . $row['distrikt'] . "</td>\n";
		echo "<td NOWRAP>Ny</td>\n";
		echo "<td NOWRAP>N/A</td>\n";
		echo "<td NOWRAP><a href=callto:+46" . str_replace(" ", "", substr($row['telefon'], 1)) . ">0" . substr($row['telefon'], 1)  . "</a></td>\n";
		echo "<td NOWRAP>" . $row['adress'] . ", " . $row['postadress'] . " " . $row['ort'] . "</td>\n";
		echo "<td NOWRAP>" . $row['namn'] . "</td>\n";
		echo "<td NOWRAP>N/A</td>\n";
    	echo "</tr><tr><td NOWRAP colspan=7><i>" . $row['trycksaker'] . "</i></td>\n";
		echo "</tr>\n";
	}
	mysql_free_result($result);
}

?>
    <tr valign="top">
      <td NOWRAP colspan=4>
        <table width="333" border="0">
          <tr valign=top>
            <td>&nbsp;</td>
            <td></td>
          </tr>
          <tr valign=top>
            <td>Vill personen vara medlem i panelen? <br>
              <select name="medlem" size=3>
                <option value="J">Ja</option>
                <option value="N">Nej</option>
                <option value="E">Kunde ej svara</option>
              </select>
            </td>
          </tr>
        </table>
        <br>
        <input type="submit" name="Submit" value="Spara">
        <br>
        </td>
      <td NOWRAP colspan=4>
        <p><b>V I K T I G T !</b></p>
        <p>24kr /st f&aring;r man om:</p>
        <p>1) Personen efter samtalet &auml;r medveten om att han/hon &auml;r
          medlem i SDR:s panel.<br>
          2) Personens namn tydligt framg&aring;r f&ouml;r mig (vem du pratat
          med), se nedan.<br>
          3) V&auml;rvar personen som l&auml;gger m&auml;rke till reklamen hemma.
          (inga minder&aring;riga)<br>
          4) Du kollat s&aring; adressen st&auml;mmer. (att dom inte flyttat)<br>
          5) Du kollat om n&aring;n l&aring;sanordning finns dagtid helg.<br>
          <br>
          OBS! Vi matchar inte mot &quot;nix-telefon&quot;. se <a href="http://www.nix.nu">nix.nu</a>
          Om n&aring;gra klagar, be om urs&auml;kt (frivilligt), <br>
          s&auml;g att du inte marknadsf&ouml;r n&aring;got. </p>
        <p>Skriv g&auml;rna om personen f&aring;tt reklam i f&auml;ltet nedan.
          om inget svar registreras s&aring; rings personen sannolikt imorgon
          igen. <br>
        </p>
        <p>Meddela vem du pratat med om det <b>I N T E</b> &auml;r den personen
          som st&aring;r i adressen.<br>
          Skall inneh&aring;lla Efternamn, F&ouml;rnamn<br>
          <textarea name="kommentar" cols="55" rows="8"></textarea>
          <br>
          <br>
          <br>
        </p>
        </td>
    </tr>
  </table>
</form>
<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/includes/footer.php"); ?>


