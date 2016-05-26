<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../../includes/header.php");
?>

<!-- page start -->
<?
$tid = $_GET['tid'];
$filter = $_GET['filter'];
?>
<p><a href=svar6.php?tid=<? echo $tid ?>&filter=1>Visa enbart medelemmar och som dessutom inte finns i KP. (dvs skall läggas in)</a></p>
<table width=100% border="0">
<tr><td>#</td><td>Distr</td><td>Namn</td><td>Telefon</td>
<td>Adress</td><td>Medlem</td><!--förvirrar bara <td>Kat.</td>--><td>Vop</td>
<td>Datum</td><td>Kommentar</td></tr>
<?
if (is_null($tid)) {
	echo "ange tid";
}
else {

$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

if ($filter) {
		$query = "SELECT ".$xsite."_panel. *
		FROM ".$xsite."_panel
		WHERE ".$xsite."_panel.telefon NOT
		IN (
		SELECT telefon
		FROM ".$xsite."_kp
		)
		AND ".$xsite."_panel.tid > '" . $tid . " 01:01:01'
		AND ".$xsite."_panel.medlem = 'J'
		ORDER BY ".$xsite."_panel.tid;";
}
else {
	$query = "SELECT * FROM ".$xsite."_panel WHERE tid > '" . $tid . " 01:01:01' ORDER BY tid;";
}

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

		$count = 1;
while($row = mysql_fetch_assoc($result)) {

	echo "<tr><td>" . $count ."</td>
<td>" . $row['distrikt'] ."</a></td>
<td><a href=form.php?telefon=" . urlencode($row['telefon']) . ">" . $row['namn'] ."</td>
<td>" . $row['telefon'] ."</td>
<td>" . $row['adress'] .", " . $row['postadress'] ." " . $row['ort'] ."</td>
<td>" . $row['medlem'] ."</td>
<!--förvirrar bara <td>" . $row['kategori'] ."</td>-->
<td>" . $row['vop'] ."</td>
<td>" . $row['tid'] ."</td>
<td>" . $row['kommentar'] ."</td></tr>\n";
			$count++;
}

}

?>
</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../../includes/footer.php"); ?>
