<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "onload=\"javascript:document.form1.focus();createCookie('distrikt','" . $_GET["distrikt"] . "','1');\"";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../includes/header.php");
?>

<!-- page start -->
<script language="JavaScript">

function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

/*
function addGo() {
	str1 = '(GO)';
	document.form1.kommentar.value = document.form1.kommentar.value + str1;
}

function addMap() {
	str1 = '(KRT) ';
	document.form1.kommentar.value = document.form1.kommentar.value + str1;
}
*/
</script>
<?
if (is_null($_GET["order"])) {
	$order = "distrikt";
}
else {
	$order = $_GET["order"];
}
?>
<form name="form1" method=POST action=update1.php>
<input type=hidden name=distrikt value="<?php echo $_GET["distrikt"] ?>">
<input type=hidden name=vecka value="<?php echo $_GET["vecka"] ?>">
<input type=hidden name=matris value="<?php echo $_GET["matris"] ?>">
<input type=hidden name=order value="<?php echo $order ?>">
<?
$mynow = substr($today[year], 2) . substr("0" .$today[mon], strlen($today[mon])-1) . substr("0" .$today[mday], strlen($today[mday])-1);
$op = $_SERVER['REMOTE_USER'];

$distrikt = $_GET["distrikt"];
$vecka = $_GET["vecka"];

if(is_null($distrikt)) {
	echo "Inga poster.";
}
else {
	$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
	or die ('Cannot connect to the database: ' . mysql_error());
	mysql_select_db ("quicotse_bill");

	$query = "SELECT *
	FROM ".$xsite."_bokning
	WHERE vecka = '" . $vecka . "'
	AND distrikt = '" . $distrikt . "';";

	$result = mysql_query($query)
	or die("Cannot get data from the database:"  . mysql_error());
	while($row = mysql_fetch_assoc($result)) {
		$namn = $row['namn'];
		$kommentar = $row['kommentar'];
		$kommentar2 = $row['kommentar2'];
		$id = $row['id'];
		if ($row['avisera'] == '1') {
			$avisera = 'checked';
		}
		if ($row['avtal'] == '1') {
			$avtal = 'checked';
		}
	}
	mysql_free_result($result);
}

echo "<input type=hidden name=id value=" . $id . ">";
?>

<table border=0>
	<tr valign=top>
		<td>
			<b><? echo $namn ?></b><br>
			<b><? echo $distrikt ?></b><br>
			<b><? echo $vecka ?></b><br>
		</td>
		<td>
			<? echo $kommentar2 ?>
		</td>
	</tr>
	<tr valign="top">
		<td colspan=2>
			<textarea name="kommentar" cols="80" rows="20"><? echo $kommentar . "\n" . $mynow . $op ?>:&nbsp;</textarea>
			<br>
			<input type="checkbox" name="avisera" value="1" <? echo $avisera ?>>Ändring körordning
			<input type="checkbox" name="avtal" value="1" <? echo $avtal ?>>Innehåller avtal
			<input type="submit" name="Submit" value="Spara">
			<br>
		</td>
	</tr>
</table>
</form>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../includes/footer.php"); ?>
