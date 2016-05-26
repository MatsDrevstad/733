<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../includes/header.php");
?>

<!-- page start -->
<form name="form1" method=POST action=update4.php>
<input type="submit" name="Submit" value="Spara">
<input type=hidden name=namn value='<? echo urlencode($_GET['namn']) ?>'>
<table width=100% border="0">
<tr>
	<td>&nbsp;</td>
	<td>Vecka</td>
    <td>Svar</td>
    <td>Distrikt</td>
    <td>Utdelare</td>
    <td>Tidklar</td>
    <td>Kommentar</td>
</tr>
<?
$mynow = substr($today[year], 2) . substr("0" .$today[mon], strlen($today[mon])-1) . substr("0" .$today[mday], strlen($today[mday])-1);
$op = $_SERVER['REMOTE_USER'];
$week = get_week_number($mytime, -5);

$namn = $_GET['namn'];

if ($_GET['updated'] == 1) {
	$class = "monkeyface5";
}
else {
	$class = "monkeyface1";

}


$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

$query = "SELECT *
FROM ".$xsite."_bokning
WHERE namn = '" . $namn . "'
ORDER BY vecka desc, distrikt asc;";

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

$count = 1;

while($row = mysql_fetch_assoc($result)) {

	if ($row['vecka'] == $week) {

		if ($row['nejsvar'] > 0) {
			$nejsvar = "N" . $row['nejsvar'];
		}
		echo "<tr class=" . $class . "><td>" . $count ."</td>
		<td><a href=matris1.php?vecka=" . $row['vecka'] .">" . $row['vecka'] ."</a></td>
		<td align=center>" . $nejsvar . "</td>
		<td><a href=svar3.php?distrikt=" . $row['distrikt'] .">" . $row['distrikt'] . "</a></td>
		<td>" . $namn ."</td>";
		echo "<td><input type=text name='t" . $row['id'] . "¤d¤e¤l" . $row['distrikt'] . "' size=20 maxlength=20 value='" . $row['tidklar'] . "'></td>";
		echo "<td><textarea name='k" . $row['id'] ."' cols=80 rows=4>" . $row['kommentar'] . "\n" . $mynow . $op . ": </textarea></td></tr>\n";
	}
	else {

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
		<td align=center>" . $nejsvar . "</td>
		<td><a href=svar3.php?distrikt=" . $row['distrikt'] .">" . $row['distrikt'] . "</a></td>
		<td>" . $namn ."</td>";
		echo "<td>" . $row['tidklar'] ."</td>
		<td><a href=edit1.php?matris=1&distrikt=" . $row['distrikt'] ."&vecka=" . $row['vecka'] .">" . $kommentar ."</a></td></tr>\n";



	}

	$count++;
	$nejsvar = '';

}

mysql_close($connection);

?>
</table>
</form>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../includes/footer.php"); ?>
