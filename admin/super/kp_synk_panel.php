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

$query = "SELECT count(*) as ant
FROM ".$xsite."_kp
WHERE telefon NOT
IN (
	SELECT telefon FROM ".$xsite."_panel
);";

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

while($row = mysql_fetch_assoc($result)) {

	$ant = $row['ant'];
}

mysql_free_result($result);

?>

<p>Saknas i panel, men finns i excelfil.</p>
<table width=100% border="0">
<tr>
	<td align=left>distrikt</td>
	<td align=left>kategori</td>
	<td align=left>adress</td>
	<td align=left>postadress</td>
	<td align=left>ort</td>
	<td align=left>namn</td>
	<td align=left>uppringd</td>
	<td align=left>vecka</td>
	<td align=left>op</td>
	<td align=left>telefon</td>
	<td align=left>kommentar</td>
</tr>

<form name=form1 medthod=post action=kp_synk_panel_update.php>

<?

$query = "SELECT *
FROM ".$xsite."_kp
WHERE telefon NOT
IN (
	SELECT telefon FROM ".$xsite."_panel
)
LIMIT 1;";

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

while($row = mysql_fetch_assoc($result)) {

	$distrikt = $row['distrikt'];
	$kategori = $row['kategori'];
	$adress = $row['adress'];
	$postadress = $row['postadress'];
	$ort = $row['ort'];
	$namn = $row['namn'];
	$uppringd = $row['uppringd'];
	$vecka = $row['vecka'];
	$telefon = $row['telefon'];
	$kommentar = $row['kommentar'];
}

echo "<input type=hidden name=distrikt value='" . $distrikt . "'>";
echo "<input type=hidden name=kategori value='" . $kategori . "'>";
echo "<input type=hidden name=adress value='" . $adress . "'>";
echo "<input type=hidden name=postadress value='" . $postadress . "'>";
echo "<input type=hidden name=ort value='" . $ort . "'>";
echo "<input type=hidden name=namn value='" . $namn . "'>";
echo "<input type=hidden name=uppringd value='" . $uppringd . "'>";
echo "<input type=hidden name=vecka value='" . $vecka . "'>";
echo "<input type=hidden name=telefon value='" . $telefon . "'>";
echo "<input type=hidden name=kommentar value='" . $kommentar . "'>";

	echo "<tr>
			<td align=left>" . $distrikt . "</td>
			<td align=left>" . $kategori . "</td>
			<td align=left>" . $adress . "</td>
			<td align=left>" . $postadress . "</td>
			<td align=left>" . $ort . "</td>
			<td align=left>" . $namn . "</td>
			<td align=left>" . $uppringd . "</td>
			<td align=left>" . $vecka . "</td>
			<td align=left>" . $op . "</td>
			<td align=left>" . $telefon . "</td>
			<td align=left>" . $kommentar . "</td>
		</tr>\n";

mysql_free_result($result);

mysql_close($connection);

?>

</table>
<br>

<input type="submit" name="Submit" value="Lägg till i panel (<? echo $ant ?>)">
</form>


<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../../includes/footer.php"); ?>