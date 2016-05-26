<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../includes/header.php");
?>

<!-- page start -->
<?
$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

$query = "SELECT ".$xsite."_panel.telefon
FROM ".$xsite."_svar, ".$xsite."_panel
WHERE ".$xsite."_svar.telefon = ".$xsite."_panel.telefon
AND ".$xsite."_panel.medlem = 'J'
AND ".$xsite."_svar.nt = '1'
AND ".$xsite."_svar.vecka = '" . get_week_number($mytime, -6) . "';";

//	echo $query	. "<br>";

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

while($row = mysql_fetch_assoc($result)) {

	$query = "update ".$xsite."_panel SET medlem = 'U' WHERE telefon = '" . $row['telefon'] . "';";
	mysql_query($query)
	or die("Cannot get data from the database:"  . mysql_error());

//	echo $query	. "<br>";
}

mysql_free_result($result);

mysql_close($connection);

?>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../includes/footer.php"); ?>
