<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../includes/header.php");
?>

<!-- page start -->
<table width=100% border="0">
<?
$vecka = $_GET['vecka'];
$id = $_GET['id'];
$mynow = "\n" . $today[year] . "-" . substr("0" .$today[mon], strlen($today[mon])-1) . "-" . substr("0" .$today[mday], strlen($today[mday])-1) . " " . substr("0" .$today[hours], strlen($today[hours])-1) . ":" . substr("0" . $today[minutes], strlen($today[minutes])-1) . " (" . $op . "): ";

$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

if (is_null($vecka)) {

	echo "ange vecka";
}
else {

	echo "<tr class=monkeyface1><td colspan=7><h3>NEJ TACK</h3></td></tr>\n";

	$query = "SELECT ".$xsite."_panel.distrikt, ".$xsite."_panel.namn, "
	.$xsite."_panel.telefon, ".$xsite."_panel.adress, ".$xsite."_panel.postadress, "
	.$xsite."_panel.ort, ".$xsite."_panel.op, ".$xsite."_panel.kommentar, ".$xsite."_svar.id
	FROM ".$xsite."_svar, ".$xsite."_panel
	WHERE ".$xsite."_svar.telefon = ".$xsite."_panel.telefon
	AND ".$xsite."_panel.medlem = 'J'
	AND ".$xsite."_svar.nt = '1'
	AND ".$xsite."_svar.vecka = '" . $vecka . "' ORDER BY distrikt;";
	$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

	$count = 1;
	while($row = mysql_fetch_assoc($result)) {

		echo "<tr class=monkeyface1 valign=top><td>NT" . $count ."<a name=" . $row['id'] . "></a></td><td>" . $row['telefon'] ."</td>\n";
		echo "<td>" . $row['namn'] ."</td>\n";
		echo "<td><a href=svar3.php?distrikt=" . $row['distrikt'] . ">" . $row['distrikt'] ."</a></td>\n";
		echo "<td>" . $row['adress'] . ", " . $row['postadress'] . " " . $row['ort'] . "</td>\n";
		echo "<td>" . $row['op'] . "</td>\n";
		if ($id == $row['id']) {
			echo "<td width=250>
			<form name=form1 action=save_rep5.php method=post>
			<input type=hidden name=telefon value='" . $row['telefon'] . "'>
			<input type=hidden name=vecka value='" . $vecka . "'>
			<input type=hidden name=id value='" . $id . "'>
			<textarea cols=44 rows=12 name=kommentar>" . $row['kommentar'] . $mynow . "</textarea>
			<input type=Submit name=Submit value=Spara>
			</td>";
		}
		else {
			echo "<td width=250><a href=rep5.php?vecka=$vecka&view=1&id=" . $row['id'] . "#" . $row['id'] . ">" . nl2br($row['kommentar']) ."</a></td>";
		}
		echo "</tr>\n";
		$count++;
	}

	mysql_free_result($result);

	echo "<tr class=monkeyface1><td colspan=7><h3>LÅST PORT</h3></td></tr>\n";

	$query = "SELECT ".$xsite."_panel.distrikt, ".$xsite."_panel.namn, "
	.$xsite."_panel.telefon, ".$xsite."_panel.adress, ".$xsite."_panel.postadress, "
	.$xsite."_panel.ort, ".$xsite."_panel.op, ".$xsite."_panel.kommentar, ".$xsite."_svar.id
	FROM ".$xsite."_svar, ".$xsite."_panel
	WHERE ".$xsite."_svar.telefon = ".$xsite."_panel.telefon
	AND ".$xsite."_panel.medlem = 'J'
	AND ".$xsite."_svar.lp = '1'
	AND ".$xsite."_svar.svar = 'N'
	AND ".$xsite."_svar.vecka = '" . $vecka . "' ORDER BY distrikt;";
	$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

	$count = 1;
	while($row = mysql_fetch_assoc($result)) {

		echo "<tr class=monkeyface1 valign=top><td>LP" . $count ."<a name=" . $row['id'] . "></a></td><td>" . $row['telefon'] ."</td>\n";
		echo "<td>" . $row['namn'] ."</td>\n";
		echo "<td><a href=svar3.php?distrikt=" . $row['distrikt'] . ">" . $row['distrikt'] ."</a></td>\n";
		echo "<td>" . $row['adress'] . ", " . $row['postadress'] . " " . $row['ort'] . "</td>\n";
		echo "<td>" . $row['op'] . "</td>\n";
		if ($id == $row['id']) {
			echo "<td width=250>
			<form name=form1 action=save_rep5.php method=post>
			<input type=hidden name=telefon value='" . $row['telefon'] . "'>
			<input type=hidden name=vecka value='" . $vecka . "'>
			<input type=hidden name=id value='" . $id . "'>
			<textarea cols=44 rows=12 name=kommentar>" . $row['kommentar'] . $mynow . "</textarea>
			<input type=Submit name=Submit value=Spara>
			</td>";
		}
		else {
			echo "<td width=250><a href=rep5.php?vecka=$vecka&view=1&id=" . $row['id'] . "#" . $row['id'] . ">" . nl2br($row['kommentar']) ."</a></td>";
		}
		echo "</tr>\n";
		$count++;
	}

	mysql_free_result($result);

	echo "<tr class=monkeyface1><td colspan=7><h3>SPECIAL</h3></td></tr>\n";

	$query = "SELECT ".$xsite."_panel.distrikt, ".$xsite."_panel.namn, "
	.$xsite."_panel.telefon, ".$xsite."_panel.adress, ".$xsite."_panel.postadress, "
	.$xsite."_panel.ort, ".$xsite."_panel.op, ".$xsite."_panel.kommentar, ".$xsite."_svar.id
	FROM ".$xsite."_svar, ".$xsite."_panel
	WHERE ".$xsite."_svar.telefon = ".$xsite."_panel.telefon
	AND ".$xsite."_panel.medlem = 'J'
	AND ".$xsite."_svar.sp = '1'
	AND ".$xsite."_svar.vecka = '" . $vecka . "' ORDER BY distrikt;";
	$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

	$count = 1;
	while($row = mysql_fetch_assoc($result)) {

		echo "<tr class=monkeyface1 valign=top><td>SP" . $count ."<a name=" . $row['id'] . "></a></td><td>" . $row['telefon'] ."</td>\n";
		echo "<td>" . $row['namn'] ."</td>\n";
		echo "<td><a href=svar3.php?distrikt=" . $row['distrikt'] . ">" . $row['distrikt'] ."</a></td>\n";
		echo "<td>" . $row['adress'] . ", " . $row['postadress'] . " " . $row['ort'] . "</td>\n";
		echo "<td>" . $row['op'] . "</td>\n";
		if ($id == $row['id']) {
			echo "<td width=250>
			<form name=form1 action=save_rep5.php method=post>
			<input type=hidden name=telefon value='" . $row['telefon'] . "'>
			<input type=hidden name=vecka value='" . $vecka . "'>
			<input type=hidden name=id value='" . $id . "'>
			<textarea cols=44 rows=12 name=kommentar>" . $row['kommentar'] . $mynow . "</textarea>
			<input type=Submit name=Submit value=Spara>
			</td>";
		}
		else {
			echo "<td width=250><a href=rep5.php?vecka=$vecka&view=1&id=" . $row['id'] . "#" . $row['id'] . ">" . nl2br($row['kommentar']) ."</a></td>";
		}
		echo "</tr>\n";
		$count++;
	}

	mysql_free_result($result);

	echo "<tr class=monkeyface1><td colspan=7><h3>NY ADRESS</h3></td></tr>\n";

	$query = "SELECT ".$xsite."_panel.distrikt, ".$xsite."_panel.namn, "
	.$xsite."_panel.telefon, ".$xsite."_panel.adress, ".$xsite."_panel.postadress, "
	.$xsite."_panel.ort, ".$xsite."_panel.op, ".$xsite."_panel.kommentar, ".$xsite."_svar.id
	FROM ".$xsite."_svar, ".$xsite."_panel
	WHERE ".$xsite."_svar.telefon = ".$xsite."_panel.telefon
	AND ".$xsite."_panel.medlem = 'J'
	AND ".$xsite."_svar.ad = '1'
	AND ".$xsite."_svar.vecka = '" . $vecka . "' ORDER BY distrikt;";
	$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

	$count = 1;
	while($row = mysql_fetch_assoc($result)) {

		echo "<tr class=monkeyface1 valign=top><td>AD" . $count ."<a name=" . $row['id'] . "></a></td><td>" . $row['telefon'] ."</td>\n";
		echo "<td>" . $row['namn'] ."</td>\n";
		echo "<td><a href=svar3.php?distrikt=" . $row['distrikt'] . ">" . $row['distrikt'] ."</a></td>\n";
		echo "<td>" . $row['adress'] . ", " . $row['postadress'] . " " . $row['ort'] . "</td>\n";
		echo "<td>" . $row['op'] . "</td>\n";
		if ($id == $row['id']) {
			echo "<td width=250>
			<form name=form1 action=save_rep5.php method=post>
			<input type=hidden name=telefon value='" . $row['telefon'] . "'>
			<input type=hidden name=vecka value='" . $vecka . "'>
			<input type=hidden name=id value='" . $id . "'>
			<textarea cols=44 rows=12 name=kommentar>" . $row['kommentar'] . $mynow . "</textarea>
			<input type=Submit name=Submit value=Spara>
			</td>";
		}
		else {
			echo "<td width=250><a href=rep5.php?vecka=$vecka&view=1&id=" . $row['id'] . "#" . $row['id'] . ">" . nl2br($row['kommentar']) ."</a></td>";
		}
		echo "</tr>\n";
		$count++;
	}

	mysql_free_result($result);
}

mysql_close($connection);
?>
</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../includes/footer.php"); ?>
