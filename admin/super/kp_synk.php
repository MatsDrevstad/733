<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../../includes/header.php");
?>

<!-- page start -->

<?

$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

$query = "SELECT count(".$xsite."_panel.telefon) AS ant
FROM ".$xsite."_kp, ".$xsite."_panel
WHERE ".$xsite."_kp.telefon = ".$xsite."_panel.telefon
AND ".$xsite."_panel.medlem = 'J'
AND (
".$xsite."_kp.distrikt != ".$xsite."_panel.distrikt
OR ".$xsite."_kp.kategori != ".$xsite."_panel.kategori
OR ".$xsite."_kp.adress != ".$xsite."_panel.adress
OR ".$xsite."_kp.postadress != ".$xsite."_panel.postadress
OR ".$xsite."_kp.ort != ".$xsite."_panel.ort
);";

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

while($row = mysql_fetch_assoc($result)) {

	$ant = $row['ant'];
}

mysql_free_result($result);

?>

<table width=100% border="0">
<tr>
<td align=left>kp = excelfil</td>
<td align=left>distrikt</td>
<td align=left>kategori</td>
<td align=left>adress</td>
<td align=left>postadress</td>
<td align=left>ort</td>
<td align=left>kommentar</td>
</tr>

<?

$query = "SELECT ".$xsite."_kp.distrikt AS kdistrikt, ".$xsite."_kp.kategori AS kkategori,
".$xsite."_kp.telefon AS ktelefon, ".$xsite."_kp.adress AS kadress, ".$xsite."_kp.postadress AS kpostadress,
".$xsite."_kp.ort AS kort, ".$xsite."_panel.distrikt AS pdistrikt, ".$xsite."_panel.kategori AS pkategori,
".$xsite."_panel.telefon AS ptelefon, ".$xsite."_panel.adress AS padress, ".$xsite."_panel.postadress AS ppostadress,
".$xsite."_panel.ort AS port, ".$xsite."_panel.kommentar AS kommentar
FROM ".$xsite."_kp, ".$xsite."_panel
WHERE ".$xsite."_kp.telefon = ".$xsite."_panel.telefon
AND ".$xsite."_panel.medlem = 'J'
AND ".$xsite."_kp.synk = 0
AND (
".$xsite."_kp.distrikt != ".$xsite."_panel.distrikt
OR ".$xsite."_kp.kategori != ".$xsite."_panel.kategori
OR ".$xsite."_kp.adress != ".$xsite."_panel.adress
OR ".$xsite."_kp.postadress != ".$xsite."_panel.postadress
OR ".$xsite."_kp.ort != ".$xsite."_panel.ort
)
LIMIT 1;";

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

$count = 1;

while($row = mysql_fetch_assoc($result)) {

$telefon = $row['ptelefon'];

if ($row['kdistrikt'] != $row['pdistrikt']) {
	$kdistrikt = $row['kdistrikt'];
	$pdistrikt = $row['pdistrikt'];
}
else {
	$kdistrikt = '';
	$pdistrikt = '';
}

if ($row['kkategori'] != $row['pkategori']) {
	$kkategori = $row['kkategori'];
	$pkategori = $row['pkategori'];
}
else {
	$kkategori = '';
	$pkategori = '';
}

if ($row['kadress'] != $row['padress']) {
	$kadress = $row['kadress'];
	$padress = $row['padress'];
}
else {
	$kadress = '';
	$padress = '';
}

if ($row['kpostadress'] != $row['ppostadress']) {
	$kpostadress = $row['kpostadress'];
	$ppostadress = $row['ppostadress'];
}
else {
	$kpostadress = '';
	$ppostadress = '';
}
if ($row['kort'] != $row['port']) {
	$kort = $row['kort'];
	$port = $row['port'];
}
else {
	$kort = '';
	$port = '';
}

	echo "<tr>
			<td align=left>kp</td>
			<td align=left>" . $kdistrikt . "</td>
			<td align=left>" . $kkategori . "</td>
			<td align=left>" . $kadress . "</td>
			<td align=left>" . $kpostadress . "</td>
			<td align=left>" . $kort . "</td>
			<td align=left rowspan=3>" . str_replace(chr(13),"<br>", $row['kommentar']) . "</td>


		</tr>\n
		<tr>
			<td align=left>panel</td>
			<td align=left>" . $pdistrikt . "</td>
			<td align=left>" . $pkategori . "</td>
			<td align=left>" . $padress . "</td>
			<td align=left>" . $ppostadress . "</td>
			<td align=left>" . $port . "</td>
		</tr>\n";
$count++;

	echo "<tr>
			<td align=left colspan=6>
			<a href=form.php?telefon=" . urlencode($row['ptelefon']) . ">Edit</a> &nbsp;<a href=form_visa.php?telefon=" . urlencode($row['ptelefon']) . ">Visa</a></td>
		</tr>\n";

}

mysql_free_result($result);

mysql_close($connection);

?>

</table>

<p>
<a href=kp_synk_update.php?telefon=<? echo urlencode($telefon) ?>>Uppdatera panel (<? echo $ant ?>)</a>&nbsp;
</p>

<p>
<a href=kp_synk_update2.php?telefon=<? echo urlencode($telefon) ?>>Skippa</a>&nbsp;
</p>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../../includes/footer.php"); ?>