<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../../includes/header.php");
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

$query = "SELECT op, svar, count(svar) AS antal
FROM ".$xsite."_svar
WHERE vecka = '" . $vecka . "'
GROUP BY op, svar;";

$op = "";

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

$rowan = 1;
$opcount = 0;

while($row = mysql_fetch_assoc($result)) {

	if ($op != $row['op']){
		$opcount = $rowan;
	}
	$op = $row['op'];

	echo "<tr><td>" . $row['op'] ."</td>\n";
	echo "<td>" . $row['svar'] . "</td>\n";
	echo "<td>" . $row['antal'] . "</td>\n";
	if ($rowan > 1) {
		echo "<td>=" . $sum . "(C" . $opcount . ":C" . $rowan . ")</td>\n";
		echo "<td>=C" . $rowan . "/D$" . $rowan . "</td></tr>\n";
	}
	else {
		echo "<td></td>\n";
		echo "<td></td></tr>\n";
	}

	$rowan = $rowan+1;

}
	mysql_free_result($result);
}
?>
</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../../includes/footer.php"); ?>
