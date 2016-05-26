<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "onload=form1.searchstring.focus();";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../includes/header.php");
?>

<!-- page start -->
<form name="form1" action="matrissok.php" method="post" >
  <table width="100%" border="0">
  <tr>
    <td colspan=6><input type="text" name="searchstring"><input type="submit" name="Submit" value="Sök"></td>
  </tr>
  <?
$max_new_member = MAX_NEW_MEMBER;

if (strlen($_POST['searchstring']) > 2) {

	$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
	or die ('Cannot connect to the database: ' . mysql_error());
	mysql_select_db ("quicotse_bill");

	$query = "SELECT * FROM ".$xsite."_bokning
	WHERE kommentar LIKE '%" . $_POST['searchstring'] . "%'
	OR namn LIKE '%" . $_POST['searchstring'] . "%'
	OR kommentar2 LIKE '%" . $_POST['searchstring'] . "%'
	OR kommentar3 LIKE '%" . $_POST['searchstring'] . "%'
	ORDER BY vecka desc, distrikt asc;";

	$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

	while($row = mysql_fetch_assoc($result)) {

		echo "<tr><td>" . $row['distrikt'] . "</td>
		<td nowrap><a href=svar4.php?namn=" . urlencode($row['namn']) .">" . $row['namn'] ."</a></td>
		<td><a href=matris1.php?vecka=" . $row['vecka'] .">" . $row['vecka'] ."</a></td>
		<td><a href=edit1.php?matris=1&distrikt=" . $row['distrikt'] ."&vecka=" . $row['vecka'] .">" . $row['kommentar'] ."</a></td>
		<td><a href=edit1.php?matris=1&distrikt=" . $row['distrikt'] ."&vecka=" . $row['vecka'] .">" . $row['kommentar2'] ."</a></td>
		<td><a href=edit1.php?matris=1&distrikt=" . $row['distrikt'] ."&vecka=" . $row['vecka'] .">" . $row['kommentar3'] ."</a></td></tr>\n";

	}
}


?>
</table>
</form>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../includes/footer.php"); ?>
