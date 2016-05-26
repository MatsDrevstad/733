<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../../includes/header.php");
?>

<!-- page start -->
<b>J
= Medlem, V = Vilande</b>
<table width="999" border="0">
<?
$vecka = $_GET['vecka'];

$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

$query = "SELECT *
FROM ".$xsite."_panel
WHERE medlem = 'J'
OR medlem = 'V'
ORDER BY distrikt;";
$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

		$count = 1;
while($row = mysql_fetch_assoc($result)) {

	echo "<tr><td>" . $count ."</td>
<td><a href=../svar3.php?distrikt=" . $row['distrikt'] .">" . $row['distrikt'] . "</a></td>
<td><a href=form.php?telefon=" . urlencode($row['telefon']) . ">" . $row['namn'] ."</td>
<td>" . $row['telefon'] ."</td>
<td>" . $row['adress'] .", " . $row['postadress'] ." " . $row['ort'] ."</td>
<td>" . $row['kategori'] ."</td>
<td>" . $row['medlem'] ."</td>
<td>" . $row['tid'] ."</td>
<td>" . str_replace(chr(13),"<br>", $row['kommentar']) ."</td></tr>\n";
			$count++;

}

?>
</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../../includes/footer.php"); ?>
