<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../includes/header.php");
?>

<!-- page start -->
<table width=900 border="0">
<tr>
<td align=right>#</td>
<td align=left>Distrikt</td>
<td align=left>Kommentar</td>
</tr>

<?
$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

$query = "SELECT *
FROM ".$xsite."_distrikt
ORDER BY distrikt;";
$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

		$count = 1;
while($row = mysql_fetch_assoc($result)) {

if(empty($row['kommentar'])) {
	$kommentar = "Skapa";
}
else {
	$kommentar = $row['kommentar'];
}

	echo "<tr><td align=right>" . $count ."</td>
<td align=left><a href=distrikt_kartor_detalj.php?karta=" . $row['distrikt'] .">" . $row['distrikt'] ."</a></td>
<td align=left><a href=svar5.php?distrikt=" . $row['distrikt'] .">" . $kommentar ."</a></td>
</tr>\n";
$count++;

}

?>
</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../includes/footer.php"); ?>