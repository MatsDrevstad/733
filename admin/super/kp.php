<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../../includes/header.php");
?>

<!-- page start -->
<p>
<a href="kp_update.php">Uppdatera från Excel</a>&nbsp;
</p>

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
//distr	kat	adress	namn	uppringd	vecka	av	telefon	telefontid	svar	kommentar	trycksaker

$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

$query = "SELECT *
FROM ".$xsite."_kp";

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
<td align=left>" . $row['svar'] ."</td>
<td align=left>" . $row['kommentar'] ."</td>
<td align=left>" . $row['trycksaker'] ."</td>

</tr>\n";
$count++;

}


?>

</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../../includes/footer.php"); ?>