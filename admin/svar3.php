<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../includes/header.php");
?>

<!-- page start -->
<?
$distrikt = $_GET['distrikt'];
$view = $_GET['view'];
$mynow = "\n" . $today[year] . "-" . substr("0" .$today[mon], strlen($today[mon])-1) . "-" . substr("0" .$today[mday], strlen($today[mday])-1) . " " . substr("0" .$today[hours], strlen($today[hours])-1) . ":" . substr("0" . $today[minutes], strlen($today[minutes])-1) . " (" . $op . "): ";
$id = $_GET['id'];
if ($view == 1) {
	$view = 2;
}
else {
	$view = 1;
}

?>

<table border="0">
<?

$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

$query = "SELECT kommentar FROM ".$xsite."_distrikt WHERE distrikt = '" . $distrikt . "';";

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

while($row = mysql_fetch_assoc($result)) {

	$dkomment = $row['kommentar'] . "&nbsp;";
}

mysql_free_result($result);

echo "<tr><td colspan=7><a href=svar5.php?distrikt=$distrikt title='�ndra info'>" . $dkomment ."</a></td></tr>";

?>
<tr>
	<td>&nbsp;</td>
	<td>Vecka</td>
	<td>Svar</td>
	<td>Distrikt</td>
	<td>Utdelare</td>
	<td>Kommentar</td>
	<td>Avrapportering</td>
</tr>
<?

$query = "SELECT kommentar, kommentar2, nejsvar, namn, vecka
FROM ".$xsite."_bokning
WHERE distrikt = '" . $distrikt . "'
ORDER BY vecka desc;";

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

$count = 1;

while($row = mysql_fetch_assoc($result)) {

	if (strlen($row['kommentar']) < 1) {
		$kommentar = "Skapa";
	}
	else {
		$kommentar = $row['kommentar'];
	}


	if ($row['nejsvar'] > 0) {
		$nejsvar = "N" . $row['nejsvar'];
	}

	echo "<tr><td>" . $count ."</td>
	<td><a href=matris1.php?vecka=" . $row['vecka'] .">" . $row['vecka'] ."</a></td>
	<td>" . $nejsvar ."</td>
	<td>" . $distrikt ."</td>
	<td nowrap><a href=svar4.php?namn=" . urlencode($row['namn']) .">" . $row['namn'] ."</a></td>
	<td><a href=edit1.php?matris=1&distrikt=" . $distrikt ."&vecka=" . $row['vecka'] .">" . $kommentar ."</a></td>
	<td>" . $row['kommentar2'] ."</td>
	</tr>\n";
	$count++;
	$nejsvar = '';

if ($count == 1) {
	$namn = $row['namn'];
}

}
mysql_free_result($result);

?>

</table>

<br>
<table border="0">
<tr><td nowrap><a name=mer href=svar3.php?distrikt=<?echo $distrikt?>&view=<?echo $view?>#mer>Visa mer</a></td>
<?
if ($view == 1) {
	echo "<td>Distrikt</td>";
	echo "<td>Utdelare</td>";
	echo "<td>Namn</td>";
	echo "<td>Telefon</td>";
	echo "<td><a href=# title='" . "0 = " . get_adressanswer(0) . "\n1 = " . get_adressanswer(1) . "\n2 = " . get_adressanswer(2) . "\n3 = " . get_adressanswer(3) . "'>L�st</a></td>";
	echo "<td>Adress</td>";
	echo "<td><a href=# title='" . "1 = " . get_kategori(1) . "\n2 = " . get_kategori(2) . "'>Kat</a></td>";
	echo "<td>Svar</td>";
	echo "<td>Vecka</td>";
	echo "<td>Tid</td>";
	echo "<td>Op</td></tr>";
}
else {
	echo "<td width=444>&nbsp;</td>";
	echo "<td>kommentar</td><td>kommentar</td></tr>";
}

$query = "SELECT ".$xsite."_panel.distrikt,
".$xsite."_panel.namn,
".$xsite."_panel.kommentar,
".$xsite."_panel.telefon,
".$xsite."_panel.lp,
".$xsite."_panel.adress,
".$xsite."_panel.postadress,
".$xsite."_panel.ort,
".$xsite."_panel.kategori,
".$xsite."_svar.op,
".$xsite."_svar.svar,
".$xsite."_svar.id,
".$xsite."_svar.tid,
".$xsite."_svar.vecka,
".$xsite."_bokning.kommentar as bokom,
".$xsite."_bokning.namn as utdelare
FROM ".$xsite."_panel, ".$xsite."_svar, ".$xsite."_bokning
WHERE ".$xsite."_panel.telefon = ".$xsite."_svar.telefon
AND ".$xsite."_svar.vecka = ".$xsite."_bokning.vecka_noindex
AND ".$xsite."_panel.distrikt = ".$xsite."_bokning.distrikt
AND ".$xsite."_bokning.distrikt = '" . $distrikt . "'";
if ($view == 1) {
$query = $query . "	AND (" .$xsite."_svar.svar = 'J'
	OR ".$xsite."_svar.svar = 'N'
	)";
}
$query = $query . "ORDER BY ".$xsite."_svar.tid desc";
//LIMIT 999;"; //limit snabbar upp fr�gan avsev�rt p� vissa php konfigurationer

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

$count = 1;

while($row = mysql_fetch_assoc($result)) {

	if ($view == 1) {
		echo "<tr><td>" . $count ."</td>
		<td>" . $row['distrikt'] ."</td>
		<td><a href=svar4.php?namn=" . urlencode($row['utdelare']) .">" . $row['utdelare'] ."</a></td>
		<td>" . $row['namn'] ."</td>
		<td>" . $row['telefon'] ."</td>
		<td>" . $row['lp'] . "</td>
		<td>" . $row['adress'] .", " . $row['postadress'] ." " . $row['ort'] ."</td>
		<td>" . $row['kategori'] ."</td>
		<td>" . $row['svar'] ."</td>
		<td><a href=matris1.php?vecka=" . $row['vecka'] .">" . $row['vecka'] ."</a></td>
		<td>" . $row['tid'] ."</td>
		<td>" . $row['op'] ."</td></tr>\n";
		$count++;
	}
	else {
		echo "<tr><td>" . $count ."</td><a name=" . $row['id'] . "></a><td>";
		echo "<table>
		<tr><td>Distrikt</td><td>" . $row['distrikt'] ."</td></tr>
		<tr><td>Utdelare</td><td><a href=svar4.php?namn=" . urlencode($row['utdelare']) .">" . $row['utdelare'] ."</a></td></tr>
		<tr><td>Vecka</td><td><a href=matris1.php?vecka=" . $row['vecka'] .">" . $row['vecka'] ."</a></td></tr>
		<tr><td>&nbsp;</td><td><td>&nbsp;</td></tr>
		<tr><td>Namn</td><td>" . $row['namn'] ."</td></tr>
		<tr><td>Adress</td><td>" . $row['adress'] .", " . $row['postadress'] ." " . $row['ort'] ."</td></tr>
		<tr><td>Telefon</td><td>" . $row['telefon'] ."</td></tr>
		<tr><td>Kategori</td><td>" . get_kategori($row['kategori']) ."</td></tr>
		<tr><td>L�stport</td><td>" . get_adressanswer($row['lp']) . "</td></tr>
		<tr><td>&nbsp;</td><td><td>&nbsp;</td></tr>
		<tr><td>Svar</td><td>" . $row['svar'] ."</td></tr>
		<tr><td>Tid</td><td>" . $row['tid'] ."</td></tr>
		<tr><td>Operat�r</td><td>" . $row['op'] ."</td></tr>
		</table></td>";
		echo "<td>" . $row['bokom'] ."</td>";
		if ($id == $row['id']) {
			echo "<td width=250>
			<form name=form1 action=save_svar3.php method=post>
			<input type=hidden name=telefon value='" . $row['telefon'] . "'>
			<input type=hidden name=distrikt value='" . $distrikt . "'>
			<input type=hidden name=id value='" . $id . "'>
			<textarea cols=44 rows=12 name=kommentar>" . $row['kommentar'] . $mynow . "</textarea>
			<input type=Submit name=Submit value=Spara>
			</td>";
		}
		else {
			echo "<td width=250><a href=svar3.php?distrikt=$distrikt&view=1&id=" . $row['id'] . "#" . $row['id'] . ">" . nl2br($row['kommentar']) ."</a></td>";
		}
		echo "</tr>\n";
		$count++;
	}
}
mysql_free_result($result);
mysql_close($connection);

?>

</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../includes/footer.php"); ?>