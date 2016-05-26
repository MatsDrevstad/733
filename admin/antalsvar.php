<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../includes/header.php");
?>

<!-- page start -->
<table width="444" border="0">
  <tr>
    <td>Vecka</td>
    <td>Antal</td>
  </tr>
  <?
$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

$query = "SELECT count( DISTINCT ".$xsite."_panel.telefon ) AS antal, ".$xsite."_panel.vecka
FROM ".$xsite."_panel, ".$xsite."_svar
WHERE (".$xsite."_svar.svar = 'J' OR ".$xsite."_svar.svar = 'N')
AND ".$xsite."_panel.telefon = ".$xsite."_svar.telefon
AND ".$xsite."_panel.medlem = 'J'
GROUP BY vecka
ORDER BY vecka DESC;";
$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

while($row = mysql_fetch_assoc($result)) {

	echo "<tr><td>" . $row['vecka'] ."</td>
	<td>" . $row['antal'] ."</td></tr>\n";
}


?>
</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../includes/footer.php"); ?>