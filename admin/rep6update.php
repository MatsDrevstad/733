<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "onload=form1." . $_GET['f'] . ".focus();";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../includes/header.php");
?>

<!-- page start -->
<script language="JavaScript">
function Checkform (s) {

	re = /^(01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23|00){1,1}:(0|1|2|3|4|5){1,1}\d{1,1}$/;

	if (!s.start2.value.match(re) && s.start2 == '') {
		alert("Fel format. '23:59'");
		s.start2.focus();
		return false;
	}
	if (!s.stopp2.value.match(re) && s.stopp2 == '') {
		alert("Fel format. '23:59'");
		s.start2.focus();
		return false;
	}

}
</script>
</head>

<?
$month = $today[year] .  substr("0" . $today[mon], strlen($today[mon])-1);
?>

OBS! Tid (f&ouml;rs&ouml;k)
kommer &auml;ndras <br>
<a href="rep6.php?mon=<? echo $month ?>">Arbetstid kommunikatör</a>
<form name="form1" action="rep6save.php" method=POST onsubmit="return Checkform(this);">
<input type=hidden name=f value="<?echo $_GET['f']?>">
  <table border="0">
  <?
$id = $_GET["id"];

$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

$query = "SELECT * FROM ".$xsite."_tid WHERE id = '" . $id . "' limit 1;";

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

	echo "<tr><td>Dag</td>\n";
	echo "<td>Start1&nbsp;</td>\n";
	echo "<td>Start2&nbsp;</td>\n";
	echo "<td>Stopp1&nbsp;</td>\n";
	echo "<td>Stopp2&nbsp;</td>\n";
	echo "<td>Op&nbsp;</td>\n";
	echo "<td>Försok&nbsp;</td>\n";
	echo "<td>Svar&nbsp;</td>\n";
	echo "<td><b>Tid (försök)*&nbsp;</b></td>\n";
	echo "<td>Tid (svar)&nbsp;</td>\n";
	echo "<td>Försök 10h&nbsp;</td>\n";
	echo "<td>Svar 10h&nbsp;</td></tr>\n";

while($row = mysql_fetch_assoc($result)) {

	$start2 = substr($row['start2'], 11, 5);
	$stopp2 = substr($row['stopp2'], 11, 5);
	if ($start2 == '00:00') {
		$start2 = "";
	}
	if ($stopp2 == '00:00') {
		$stopp2 = "";
	}

	echo "<input type=hidden name=start1 value='" . $row['start1'] . "'>\n";
	echo "<input type=hidden name=stopp1 value='" . $row['stopp1'] . "'>\n";
	echo "<input type=hidden name=id value='" . $row['id'] . "'>\n";
	echo "<input type=hidden name=id value='" . $row['id'] . "'>\n";

	echo "<tr><td>" . substr($row['start1'], 8, 2) ."</td>\n";
	echo "<td>" . substr($row['start1'], 11, 5) . "</td>\n";
	echo "<td><input type=text name=start2 maxlength=5 size=5 value='" . $start2 . "'></td>\n";
	echo "<td>" . substr($row['stopp1'], 11, 5) . "</td>\n";
	echo "<td><input type=text name=stopp2 maxlength=5 size=5 value='" . $stopp2 . "'></td>\n";
	echo "<td>" . $row['op'] . "</td>\n";
	echo "<td>" . $row['forsok'] . "</td>\n";
	echo "<td>" . $row['svar'] . "</td>\n";
	echo "<td><b>" . str_replace(".", ",", $row['forsoktid']) . "</b></td>\n";
	echo "<td>" . str_replace(".", ",", $row['svartid']) . "</td>\n";
	echo "<td>" . $row['forsok10h'] . "</td>\n";
	echo "<td>" . $row['svar10h'] . "</td></tr>\n";
}
mysql_free_result($result);

?>
</table>
  <b>*
  Första samtalet antas ta 2 minuter.</b>
  <input type="submit" name="Submit" value="&Auml;ndra">
</form>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../includes/footer.php"); ?>
