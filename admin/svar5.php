<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../includes/header.php");
?>

<!-- page start -->
<form name="form1" method=POST action=save_svar5.php>
<table width=100% border="0">

<?
$distrikt = $_GET['distrikt'];
$max_tecken = 150;

echo "<input type=hidden name=distrikt value='$distrikt'>";

$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

$query = "SELECT kommentar FROM ".$xsite."_distrikt WHERE distrikt = '$distrikt';";

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

while($row = mysql_fetch_assoc($result)) {

	$kommentar = $row['kommentar'];
}

mysql_free_result($result);

echo "<td>Max tecken: $max_tecken<br>
		Ange <i>Gata 5(Trycksak)</i>
		Trycksaken matchas sen vid önskemål om extrakontroller.<br>
		<input type=text name=kommentar size=$max_tecken maxlength=$max_tecken value='$kommentar'>
		<input type=Submit name=submit value=Spara>
	</td>";

mysql_close($connection);

?>
</tr>
</table>
</form>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../includes/footer.php"); ?>
