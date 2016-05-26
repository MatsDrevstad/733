<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../includes/header.php");
?>

<!-- page start -->
<table width="333" border="0">
<?
if(MSOFFICE == 'Svenska') {
	$sum = 'SUMMA';
}
if(MSOFFICE == 'Engelska') {
	$sum = 'SUM';
}

$vecka = $_GET['vecka'];

if (is_null($vecka)) {
	echo "ange vecka";
}
else {

$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

$query = "SELECT svar, count(svar) AS antal
FROM ".$xsite."_svar
WHERE vecka = '" . $vecka . "'
GROUP BY svar;";

$op = "";

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

$rowan = 1;

while($row = mysql_fetch_assoc($result)) {

	echo "<tr><td>" . $row['svar'] ."</td>\n";
	echo "<td>" . $row['antal'] . "</td>\n";
	echo "<td>=B" . $rowan . "/B5</td></tr>\n";
	$rowan = $rowan+1;

}
	mysql_free_result($result);

	echo "<tr><td></td>\n";
	echo "<td>=" . $sum . "(B1:B4)</td>\n";
	echo "<td></td></tr>\n";

	echo "<tr><td>Kvalitet:</td>\n";
	echo "<td>=B2/" . $sum . "(B2:B3)</td>\n";
	echo "<td></td></tr>\n";

	echo "<tr><td>Antal \"kontrollpunkter\":</td>\n";
	echo "<td>=" . $sum . "(B2:B3)</td>\n";
	echo "<td></td></tr>\n";

}

?>
</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../includes/footer.php"); ?>
