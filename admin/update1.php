<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n
<meta http-equiv=refresh content=1;URL=matris" . $_POST['matris'] . ".php?vecka=" . $_POST['vecka'] . "&order=" . $_POST['order'] . ">";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../includes/header.php");
?>

<!-- page start -->
  <table width="100%" border="0">
    <tr valign="top">
      <td NOWRAP><br>
Sparar
<?
$vecka = $_POST['vecka'];
$kommentar = $_POST['kommentar'];
$distrikt = $_POST['distrikt'];
$id = $_POST['id'];
$order = $_POST['order'];
$avisera = $_POST['avisera'];
$avtal = $_POST['avtal'];

$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

if ($id == '') {
	$query = "insert into ".$xsite."_bokning (kommentar, vecka, vecka_noindex, distrikt, avtal, avisera) values (
	'" . $kommentar . "',
	'" . $vecka . "',
	'" . $vecka . "',
	'" . $distrikt . "',
	'" . $avtal . "',
	'" . $avisera . "');";

}
else {
	$query = "update ".$xsite."_bokning set
	kommentar = '" . $kommentar . "',
	avisera = '" . $avisera . "',
	avtal = '" . $avtal . "'
	where id = '" . $id . "';";
}

mysql_query($query)
or die("Cannot get data from the database:"  . mysql_error());

mysql_close($connection);
?>

    </td>
  </tr>
</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../includes/footer.php"); ?>
