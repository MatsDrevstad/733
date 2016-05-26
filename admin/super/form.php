<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../../includes/header.php");
?>

<!-- page start -->
<?
$op = $_SERVER['REMOTE_USER'];
$mynow = $today[year] . "-" . substr("0" .$today[mon], strlen($today[mon])-1) . "-" . substr("0" .$today[mday], strlen($today[mday])-1) . " " . substr("0" .$today[hours], strlen($today[hours])-1) . ":" . substr("0" . $today[minutes], strlen($today[minutes])-1) . " (" . $op . "): ";
$reset_answer = RESET_ANSWER;
$week1 = substr(get_week_number($mytime, -$reset_answer), 4);
$week2 = substr(get_week_number($mytime, 0), 4);
?>

<script language="JavaScript">
function addStamp() {
	str1 = '\n<? echo $mynow ?>';
	document.form1.kommentar.value = document.form1.kommentar.value + str1;
}

function Checkform (s) {

	if (s.oldadress.value != s.adress.value) {
		if (confirm("Du håller på att ändra adressen. \nPersonen kan ha svarat på om porten är låst. \nTryck OK om du vill ställa om den frågan igen på den nya adressen \(Rekommenderas\).") == true) {
			s.resetlp.value = 1;
		}
		else {
			s.resetlp.value = 0;
		}
	}
}

</script>
<?

$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");
	$query = "SELECT *
	FROM ".$xsite."_panel
	WHERE telefon = '" . $_GET['telefon'] . "';";

	$result = mysql_query($query)
	or die("Cannot get data from the database:"  . mysql_error());
	while($row = mysql_fetch_assoc($result)) {
		$distrikt = $row['distrikt'];
		$vecka = $row['vecka'];
		$ad = $row['ad'];
		$lp = $row['lp'];
		$telefon = $row['telefon'];
		$adress = $row['adress'];
		$postadress = $row['postadress'];
		$ort = $row['ort'];
		$kategori = $row['kategori'];
		$namn = $row['namn'];
		$kommentar = $row['kommentar'];
		$opinnan = $row['opinnan'];
		$op = $row['op'];
		$vop = $row['vop'];
		$trycksaker = $row['trycksaker'];
		$medlem = $row['medlem'];
		$svar = $row['svar'];
		$tid = $row['tid'];

	}
	mysql_free_result($result);

$ad_arr = array('n/a','Nej, jag anger ny','Ja','Glömde fråga/fick inget svar.');
$lp_arr = array('n/a','Ja, portkod eller liknande finns. (OBS! Eventuellt redan svarad på tidigare','Nej, det är öppet','Glömde fråga/fick inget svar.');

?>

<form name="form1" action="save_form.php" method="post" onsubmit="return Checkform(this);">
<input type=hidden name=resetlp value=0>
<input type=hidden name=oldadress value="<? echo $adress ?>">
<input type=hidden name=olddistrikt value="<? echo $distrikt ?>">
  <input type="button" name="Tillbaka" value="Tillbaka" onclick="javascript:history.go(-3);">
  <table width="444" border="0">
    <tr valign="top">
      <td>Distrikt</td>
      <td>
        <input type="text" name="distrikt" value="<? echo $distrikt ?>" size="100">
      </td>
    </tr>
    <tr valign="top">
      <td>Vecka</td>
      <td>
        <input type="text" name="vecka" value="<? echo $vecka ?>" size="100">
      </td>
    </tr>
    <tr valign="top">
      <td>Låst port</td><td><? echo $lp_arr[$lp] ?></td>
    </tr>
    <tr valign="top">
      <td>Stämmer adressen?</td><td><? echo $ad_arr[$ad] ?></td>
    </tr>
    <tr valign="top">
      <td>Telefon</td>
      <td>
        <input type="text" name="telefon" value="<? echo $telefon ?>" size="100">
      </td>
    </tr>
    <tr valign="top">
      <td>Adress</td>
      <td>
        <input type="text" name="adress" value="<? echo $adress ?>" size="100">
      </td>
    </tr>
    <tr valign="top">
      <td>Postadress</td>
      <td>
        <input type="text" name="postadress" value="<? echo $postadress ?>" size="100">
      </td>
    </tr>
    <tr valign="top">
      <td>Ort</td>
      <td>
        <input type="text" name="ort" value="<? echo $ort ?>" size="100">
      </td>
    </tr>
    <tr valign="top">
      <td>Kategori</td>
      <td>
        <input type="text" name="kategori" value="<? echo $kategori ?>" size="100">
      </td>
    </tr>
    <tr valign="top">
      <td>Namn</td>
      <td>
        <input type="text" name="namn" value="<? echo $namn ?>" size="100">
      </td>
    </tr>
    <tr valign="top">
      <td>Opinnan</td>
      <td>
        <input type="text" name="opinnan" value="<? echo $opinnan ?>" size="100">
      </td>
    </tr>
    <tr valign="top">
      <td>Op</td>
      <td>
        <input type="text" name="op" value="<? echo $op ?>" size="100">
      </td>
    </tr>
    <tr valign="top">
      <td>Vop</td>
      <td>
        <input type="text" name="vop" value="<? echo $vop ?>" size="100">
      </td>
    </tr>
    <tr valign="top">
      <td>Trycksaker</td>
      <td>
        <input type="text" name="trycksaker" value="<? echo $trycksaker ?>" size="100">
      </td>
    </tr>
    <tr valign="top">
      <td>Medlem</td>
      <td>
        <input type="text" name="medlem" value="<? echo $medlem ?>" size="100">
      </td>
    </tr>
<?
if ($week1 < $week2) {
	echo "
	<tr valign=\"top\">
      <td>Svar</td>
      <td>
        <input type=\"text\" name=\"svar\" value=\"" . $svar . "\" size=\"100\">
      </td>
    </tr>
	";
}
else {
	echo "<input type=hidden name=svar value=$svar>\n";
}
?>
    <tr valign="top">
      <td>Tid</td>
      <td>
        <input type="text" name="tid" value="<? echo $tid ?>" size="100">
      </td>
    </tr>
    <tr valign="top">
      <td>Kommentar</td>
      <td>
        <textarea name="kommentar" cols="55" rows="8"><? echo $kommentar ?></textarea>
      </td>
    </tr>
    <tr valign="top">
      <td>
        <input type="submit" name="Submit" value="Submit">

      </td>
      <td><input type="button" name="b1" value="Stämla" onclick="javascript:addStamp();"></td>
    </tr>
  </table>
  </form>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../../includes/footer.php"); ?>
