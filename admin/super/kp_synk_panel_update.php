<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n
<meta http-equiv=refresh content=1;URL=kp_synk_panel.php>";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../../includes/header.php");
?>

<!-- page start -->
<p>Uppdaterar..</p>

<?

$distrikt = $_GET['distrikt'];
$kategori = $_GET['kategori'];
$adress = $_GET['adress'];
$postadress = $_GET['postadress'];
$ort = $_GET['ort'];
$namn = $_GET['namn'];
$uppringd = $_GET['uppringd'];
$vecka = $_GET['vecka'];
$telefon = $_GET['telefon'];
$kommentar = $_GET['kommentar'];

$year = $today['year'];

$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

$week = substr(get_week_number($mytime, 0), 4);
$vecka = sprintf("%02d", $vecka);

if ($vecka != '00') {
	if ($vecka > $week) {
		$vecka = $year-1 . $vecka;
	}
	else {
		$vecka = $year . $vecka;

	}
}
else {
	$vecka = sprintf("%01d", $vecka);
}

$query = "INSERT INTO ".$xsite."_panel (distrikt, kategori, adress, postadress, ort, namn, vecka,
telefon, kommentar, medlem)
VALUES ('" . $distrikt . "', '" . $kategori . "', '" . $adress . "', '" . $postadress . "',
'" . $ort . "', '" . $namn . "', '" . $vecka . "', '" . $telefon . "', '" . $kommentar . "', 'J');";

//echo $query;

mysql_query($query)
or die("Cannot get data from the database:"  . mysql_error());

mysql_close($connection);

?>

</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../../includes/footer.php"); ?>