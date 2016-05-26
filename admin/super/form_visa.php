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

  <table width="444" border="0">
    <tr valign="top">
      <td>Distrikt</td>
      <td>
        <? echo $distrikt ?>
      </td>
    </tr>
    <tr valign="top">
      <td>Vecka</td>
      <td>
        <? echo $vecka ?>
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
        <? echo $telefon ?>
      </td>
    </tr>
    <tr valign="top">
      <td>Adress</td>
      <td>
        <? echo $adress ?>
      </td>
    </tr>
    <tr valign="top">
      <td>Postadress</td>
      <td>
        <? echo $postadress ?>
      </td>
    </tr>
    <tr valign="top">
      <td>Ort</td>
      <td>
        <? echo $ort ?>
      </td>
    </tr>
    <tr valign="top">
      <td>Kategori</td>
      <td>
        <? echo $kategori ?>
      </td>
    </tr>
    <tr valign="top">
      <td>Namn</td>
      <td>
        <? echo $namn ?>
      </td>
    </tr>
    <tr valign="top">
      <td>Opinnan</td>
      <td>
        <? echo $opinnan ?>
      </td>
    </tr>
    <tr valign="top">
      <td>Op</td>
      <td>
        <? echo $op ?>
      </td>
    </tr>
    <tr valign="top">
      <td>Vop</td>
      <td>
        <? echo $vop ?>
      </td>
    </tr>
    <tr valign="top">
      <td>Trycksaker</td>
      <td>
        <? echo $trycksaker ?>
      </td>
    </tr>
    <tr valign="top">
      <td>Medlem</td>
      <td>
        <? echo $medlem ?>
      </td>
    </tr>
<?
if ($week1 < $week2) {
	echo "
	<tr valign=\"top\">
      <td>Svar</td>
      <td>
        " . $svar . "
      </td>
    </tr>
	";
}
else {
	echo $svar;
}
?>
    <tr valign="top">
      <td>Tid</td>
      <td>
        <? echo $tid ?>
      </td>
    </tr>
    <tr valign="top">
      <td>Kommentar</td>
      <td>
        <? echo nl2br($kommentar) ?>
      </td>
    </tr>

  </table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../../includes/footer.php"); ?>
