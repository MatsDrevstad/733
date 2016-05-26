<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n
<meta http-equiv=refresh content=1;URL=kp_synk.php>";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../../includes/header.php");
?>

<!-- page start -->
<p>Uppdaterar..</p>

<?
$telefon = $_GET["telefon"];

$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

$query = "SELECT kategori, distrikt, adress, postadress, ort
FROM ".$xsite."_kp
WHERE telefon = '$telefon';";

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

while($row = mysql_fetch_assoc($result)) {

	$kategori = $row['kategori'];
	$distrikt = $row['distrikt'];
	$adress = $row['adress'];
	$postadress = $row['postadress'];
	$ort	 = $row['ort'];
}

mysql_free_result($result);

$query = "update ".$xsite."_panel set
kategori = '$kategori',
distrikt = '$distrikt',
adress = '$adress',
postadress = '$postadress',
ort	 = '$ort'
where telefon = '$telefon';";

mysql_query($query)
or die("Cannot get data from the database:"  . mysql_error());

mysql_close($connection);

?>

</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../../includes/footer.php"); ?>