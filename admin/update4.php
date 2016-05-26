<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n
<meta http-equiv=refresh content=1;URL=svar4.php?namn=" . $_POST['namn'] . "&updated=1>";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../includes/header.php");
?>

<!-- page start -->
  <table width="100%" border="0">
    <tr valign="top">
      <td NOWRAP><br>
Sparar<br>
<?

$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

$pattern = '/[0-9]{6}[A-Z]{2}: $/';
$replacement = '';

$delimeter = '¤d¤e¤l';

foreach ($_POST as $key => $value) {

	if ($key <> 'Submit' AND $key <> 'namn') {
		if (substr($key, 0, 1) == 't') {
			$tid = explode($delimeter,	substr($key, 1));
			$query = "update ".$xsite."_bokning set tidklar = '" . $value . "' where id = '" . $tid[0] . "';";
			mysql_query($query)
			or die("Cannot get data from the database:"  . mysql_error());
//			echo $query . "<br>";
			if (empty($value)) {
				$query = "update ".$xsite."_panel set rapporterad = '0' where distrikt = '" . $tid[1] . "';";
			}
			else {
				$query = "update ".$xsite."_panel set rapporterad = '1' where distrikt = '" . $tid[1] . "';";
			}
			mysql_query($query)
			or die("Cannot get data from the database:"  . mysql_error());
//			echo $query . "<br>";
		}
		if (substr($key, 0, 1) == 'k') {
			$query = "update ".$xsite."_bokning set kommentar = '" . preg_replace($pattern, $replacement, $value) . "' where id = '" . substr($key, 1) . "';";
			mysql_query($query)
			or die("Cannot get data from the database:"  . mysql_error());
//			echo $query . "<br>";
		}

	}
}

mysql_close($connection);

?>

    </td>
  </tr>
</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../includes/footer.php"); ?>
