<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../../includes/header.php");
?>

<!-- page start -->

<p>
<a href="kp_uppd2.php">Uppdatera från KP</a>&nbsp;
</p>

<?
$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

//visa antal
$query = "SELECT count(DISTINCT kategori, distrikt, trycksaker) as tal FROM ".$xsite."_kp
WHERE trycksaker != ''
AND distrikt != ''
AND kategori > 0";

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

while($row = mysql_fetch_assoc($result)) {

	echo "Antal unika poster i kp: " . $row['tal'];

}

mysql_free_result($result);

echo "<br>";

//visa antal
$query = "SELECT count(DISTINCT kategori, distrikt, trycksaker) as tal FROM ".$xsite."_panel
WHERE trycksaker != ''
AND distrikt != ''
AND kategori > 0";

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

while($row = mysql_fetch_assoc($result)) {

	echo "Antal unika poster i panel: " . $row['tal'];

}

mysql_free_result($result);

mysql_close($connection);

?>

</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../../includes/footer.php"); ?>