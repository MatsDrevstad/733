<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../../includes/header.php");
?>

<!-- page start -->
<p>
Om Villkoret "Nej svar 1" uppfylls, och det är en söndag, slutar kontrollen
tillfälligt för att sen fortsätta på måndagen med att uppfylla något av de andra
villkoren.<br>
Om något av villkoren "Max svar" eller "Ja svar" (eller båda) uppfylls på en söndag upphör kontrollen av distriktet.
<br>
Om något (eller fler) av villkoren "Max svar", "Ja svar" eller "Nej svar 2" uppfylls på en måndag upphör kontrollen av distriktet.
<br>
Siffrorna avser totalt antal svar under både söndag och måndag. <br>
"Kontroll" ska vara 1, 2 eller 3.<br>
Sätt 1 för de fall kontrollen av distriktet startar på söndag.<br>
Sätt 2 för de fall kontrollen av distriktet startar på måndag.<br>
Sätt 3 för de fall kontroll av distriktet inte ska ske alls. <br>
</p>

<p>
<a href="distrikt_update.php">Uppdatera från Excel</a>&nbsp;
<a href="distrikt_update2.php">Uppdatera enbart Op</a>
</p>

<table width=100% border="0">
<tr><td align=right>#</td>
<td align=left nowrap>Distrikt</td>
<td align=left nowrap>Op</td>
<td align=right nowrap>Max svar</td>
<td align=right nowrap>Ja svar</td>
<td align=right nowrap>Nej svar 1</td>
<td align=right nowrap>Nej svar 2</td>
<td align=right nowrap>Kontroll</td>
<td align=left nowrap>Kommentar</td>
<td align=left nowrap>Uppdrag</td>
<td align=left nowrap><i>Namn</i></td>
<td align=left nowrap><i>Matris</i></td></tr>

<?
$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

$query = "SELECT
".$xsite."_distrikt.distrikt,
".$xsite."_distrikt.op,
".$xsite."_distrikt.maxsvar,
".$xsite."_distrikt.jasvar,
".$xsite."_distrikt.nejsvar_1,
".$xsite."_distrikt.nejsvar_2,
".$xsite."_distrikt.kontroll,
".$xsite."_distrikt.uppdrag,
".$xsite."_distrikt.kommentar AS kommentar,
".$xsite."_bokning.namn,
".$xsite."_bokning.kommentar AS kommentar2
FROM ".$xsite."_distrikt
LEFT JOIN ".$xsite."_bokning
ON ".$xsite."_distrikt.distrikt = ".$xsite."_bokning.distrikt
WHERE ".$xsite."_bokning.vecka_noindex = '" . get_week_number($mytime, -5) . "'
ORDER BY ".$xsite."_distrikt.distrikt;";

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

		$count = 1;
while($row = mysql_fetch_assoc($result)) {

	echo "<tr><td align=right>" . $count ."</td>
<td align=left>" . $row['distrikt'] ."</td>
<td align=left>" . $row['op'] ."</td>
<td align=right>" . $row['maxsvar'] ."</td>
<td align=right>" . $row['jasvar'] ."</td>
<td align=right>" . $row['nejsvar_1'] ."</td>
<td align=right>" . $row['nejsvar_2'] ."</td>
<td align=right><a href=distrikt_save3.php?distrikt=" . $row['distrikt'] . "&kontroll=" . $row['kontroll'] . ">" . $row['kontroll'] ."</a></td>
<td align=right>" . $row['kommentar'] ."</td>
<td align=right>" . $row['uppdrag'] ."</td>
<td align=right>" . $row['namn'] ."</td>
<td align=left>" . $row['kommentar2'] ."</td></tr>\n";
$count++;

}


?>

</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../../includes/footer.php"); ?>