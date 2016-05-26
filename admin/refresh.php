<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n
<meta http-equiv=refresh content=1;URL=matris1.php?vecka=" . $_GET['vecka'] . ">";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../includes/header.php");
?>

<!-- page start -->
  <table width="100%" border="0">
    <tr valign="top">
      <td NOWRAP><br>
Uppdaterar..
<?
$vecka = $_GET['vecka'];

$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

$order = 'distrikt';
$sqlorder = "".$xsite."_distrikt.distrikt";
$filename = "./" . $order . $vecka . ".inc";

$query = "SELECT ".$xsite."_distrikt.distrikt AS distr, ".$xsite."_bokning.*
FROM ".$xsite."_distrikt
LEFT JOIN ".$xsite."_bokning
ON ".$xsite."_distrikt.distrikt = ".$xsite."_bokning.distrikt
AND ".$xsite."_bokning.vecka = '" . $vecka . "'
ORDER BY " . $sqlorder . "
LIMIT 999;";

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

$count = 1;
$somecontent = '';

while($row = mysql_fetch_assoc($result)) {

	if (strlen($row['kommentar']) < 3) { //ta i lite extra. 1 räckte inte pga radbryt
		$kommentar = "Skapa";
	}
	else {
		$kommentar = $row['kommentar'];
	}
		$kommentar3 = $row['kommentar3'];

		$somecontent = $somecontent . "<tr>
		<td align=right>" . $count ."</td>
		<td><div align=center>";
		if (!empty($row['kommentar2'])) {
			$somecontent = $somecontent	. "<a href=edit1.php?matris=1&distrikt=" . $row['distr'] . "&order=" . $order ."&vecka=" . $vecka ." title='" . preg_replace("/<BR>/", "", $row['kommentar2']) . "'>" . $row['tidklar'] . "</a>";
		}
		else {
			$somecontent = $somecontent	. $row['tidklar'];
		}
		$somecontent = $somecontent	. "</div></td>
		<td><div align=center>";
		if ($row['nejsvar'] > 0) {
			$somecontent = $somecontent	. "N" . $row['nejsvar'] . "</div></td>";
		}
		$somecontent = $somecontent	. "<td><a href=svar3.php?distrikt=" . $row['distr'] .">" . $row['distr'] ."</a></td>
		<td><a href=svar4.php?namn=" . urlencode($row['namn']) .">" . $row['namn'] ."</a></td>
		<td><a href=edit1.php?matris=1&distrikt=" . $row['distr'] . "&order=" . $order ."&vecka=" . $vecka ." title='" . $kommentar ."'>" . substr($kommentar, 0, 40) ."</a></td>
		<td><a href=svar3.php?distrikt=" . $row['distr'] . "&view=1#mer title='" . $kommentar3 ."'>" . substr($kommentar3, 0, 40) ."</a></td>
		</tr>\n";

	$count++;
}

if (!$handle = fopen($filename, 'w')) {
	echo "Cannot open file ($filename)";
	exit;
}

if (fwrite($handle, $somecontent) === FALSE) {
	echo "Cannot write to file ($filename)";
	exit;
}

fclose($handle);

$order = 'namn';
$sqlorder = "".$xsite."_bokning.namn";
$filename = "./" . $order . $vecka . ".inc";

$query = "SELECT ".$xsite."_distrikt.distrikt AS distr, ".$xsite."_bokning.*
FROM ".$xsite."_distrikt
LEFT JOIN ".$xsite."_bokning
ON ".$xsite."_distrikt.distrikt = ".$xsite."_bokning.distrikt
AND ".$xsite."_bokning.vecka = '" . $vecka . "'
ORDER BY " . $sqlorder . "
LIMIT 999;";

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

$count = 1;
$somecontent = '';

while($row = mysql_fetch_assoc($result)) {

	if (strlen($row['kommentar']) < 3) { //ta i lite extra. 1 räckte inte pga radbryt
		$kommentar = "Skapa";
	}
	else {
		$kommentar = $row['kommentar'];
	}
		$kommentar3 = $row['kommentar3'];

		$somecontent = $somecontent . "<tr>
		<td align=right>" . $count ."</td>
		<td><div align=center>";
		if (!empty($row['kommentar2'])) {
			$somecontent = $somecontent	. "<a href=edit1.php?matris=1&distrikt=" . $row['distr'] . "&order=" . $order ."&vecka=" . $vecka ." title='" . preg_replace("/<BR>/", "", $row['kommentar2']) . "'>" . $row['tidklar'] . "</a>";
		}
		else {
			$somecontent = $somecontent	. $row['tidklar'];
		}
		$somecontent = $somecontent	. "</div></td>
		<td><div align=center>";
		if ($row['nejsvar'] > 0) {
			$somecontent = $somecontent	. "N" . $row['nejsvar'] . "</div></td>";
		}
		$somecontent = $somecontent	. "<td><a href=svar3.php?distrikt=" . $row['distr'] .">" . $row['distr'] ."</a></td>
		<td><a href=svar4.php?namn=" . urlencode($row['namn']) .">" . $row['namn'] ."</a></td>
		<td><a href=edit1.php?matris=1&distrikt=" . $row['distr'] . "&order=" . $order ."&vecka=" . $vecka ." title='" . $kommentar ."'>" . substr($kommentar, 0, 40) ."</a></td>
		<td><a href=svar3.php?distrikt=" . $row['distr'] . "&view=1#mer title='" . $kommentar3 ."'>" . substr($kommentar3, 0, 40) ."</a></td>
		</tr>\n";

	$count++;
}

if (!$handle = fopen($filename, 'w')) {
	echo "Cannot open file ($filename)";
	exit;
}

if (fwrite($handle, $somecontent) === FALSE) {
	echo "Cannot write to file ($filename)";
	exit;
}

fclose($handle);

mysql_close($connection);

?>

    </td>
  </tr>
</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../includes/footer.php"); ?>
