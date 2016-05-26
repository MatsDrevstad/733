<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../includes/header.php");
?>

<!-- page start -->
  <table width="100%" border="0">
  <?
$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

$query = "SELECT * FROM ".$xsite."_bokning where avtal = '1' order by tid desc;";

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

while($row = mysql_fetch_assoc($result)) {

	echo "<tr><td><a href=edit1.php?matris=3&matris=3&distrikt=" . $row['distrikt'] . "&vecka=" . $row['vecka'] . ">" . $row['distrikt'] . "</a> " . $row['namn'] . " /" . substr($row['tid'],8,11) .
	" => " . substr($row['kommentar'], 6) . "</td></tr>\n";

}

mysql_free_result($result);

mysql_close($connection);


?>
</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../includes/footer.php"); ?>
