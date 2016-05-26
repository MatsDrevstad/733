<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../../includes/header.php");
?>

<!-- page start -->
<p>
<p><a href="kp_res_update.php">Uppdatera från Excel</a>&nbsp;
</p>

<p>kolla nu förfan extra mycket så att svaren stämmer
det verkar ju som om felet var att cron inte bet.....
nej nu vet jag... jag laddade tillbaka backup
faan. Ska kronen bort eller inte är frågan ????
kan man resetta den i kp-res?
</p>


<!--
<table width=100% border="0">
<tr>
<td align=left>distr</td>
<td align=left>kat</td>
<td align=left>adress</td>
<td align=left>namn</td>
<td align=left>uppringd</td>
<td align=left>vecka</td>
<td align=left>av</td>
<td align=left>telefon</td>
<td align=left>telefontid</td>
<td align=left>svar</td>
<td align=left>kommentar</td>
<td align=left>trycksaker</td>
</tr>


<?
/*
//distr	kat	adress	namn	uppringd	vecka	av	telefon	telefontid	svar	kommentar	trycksaker
$vecka = get_week_number($mytime, -5);

$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

$query = "SELECT ".$xsite."_kp.*, ".$xsite."_panel.svar as svar2, ".$xsite."_svar.nt
FROM ".$xsite."_kp
LEFT JOIN ".$xsite."_panel ON ".$xsite."_kp.telefon = ".$xsite."_panel.telefon
LEFT JOIN ".$xsite."_svar ON ".$xsite."_kp.telefon = ".$xsite."_svar.telefon
AND ".$xsite."_svar.vecka = '" . $vecka . "'
;";

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

		$count = 1;
while($row = mysql_fetch_assoc($result)) {

	echo "<tr>
<td align=left>" . $row['distrikt'] ."</td>
<td align=left>" . $row['kategori'] ."</td>
<td align=left>" . $row['adress'] . ", " . $row['postadress'] . " " . $row['ort'] . "</td>
<td align=left>" . $row['namn'] ."</td>
<td align=left>" . $row['uppringd'] ."</td>
<td align=left>" . $row['vecka'] ."</td>
<td align=left>" . $row['op'] ."</td>
<td align=left>" . $row['telefon'] ."</td>
<td align=left>" . $row['telefontid'] ."</td>
<td align=left>" . $row['nt'] . $row['svar2'] ."</td>
<td align=left>" . $row['kommentar'] ."</td>
<td align=left>" . $row['trycksaker'] ."</td>

</tr>\n";
$count++;

}

*/
?>

</table>
-->
<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../../includes/footer.php"); ?>