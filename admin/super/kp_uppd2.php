<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n
<meta http-equiv=refresh content=1;URL=kp_uppd.php>";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../../includes/header.php");
?>

<!-- page start -->
<p>Uppdaterar..</p>

<?
//distr	kat	adress	namn	uppringd	vecka	av	telefon	telefontid	svar	kommentar	trycksaker

$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

$query = "SELECT DISTINCT kategori, distrikt, trycksaker
FROM ".$xsite."_kp
WHERE trycksaker != ''
AND distrikt != ''
AND kategori > 0";

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

while($row = mysql_fetch_assoc($result)) {

	$arpost[$row['distrikt'].$row['kategori']] = $row['trycksaker'];

}

mysql_free_result($result);

foreach ($arpost as $key => $value) {

	$query = "update ".$xsite."_panel set trycksaker = '$value' where distrikt = '" . substr($key, 0, 4) . "'
	and kategori = '" . substr($key, 4) . "';";

		mysql_query($query)
		or die("Cannot get data from the database:"  . mysql_error());

}

mysql_close($connection);

?>

</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../../includes/footer.php"); ?>