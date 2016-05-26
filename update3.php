<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n
<meta http-equiv=\"refresh\" content=\"1;URL=list3.php\">";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/includes/header.php");
?>

<!-- page start -->
  <table width="100%" border="0">
    <tr valign="top">
      <td NOWRAP><br>
Sparar
<?
$telefon = $telefon = str_replace("_", " ", $_POST['telefon']);
$kategori = '2';		// jag tar ettorna senare när jag reggar dom i centralen eller om ecportfilen innehåller kategori i frmatiden.$_POST['kategori'];
$medlem = $_POST['medlem'];
$week = $_POST['week'];
$ejsvar = 0;
if ($medlem == "") {
	$ejsvar = 1;
}
$kommentar = $_POST['kommentar'];
$op = $_SERVER['REMOTE_USER'];
$mynow = $today[year] . "-" . substr("0" .$today[mon], strlen($today[mon])-1) . "-" . substr("0" .$today[mday], strlen($today[mday])-1) . " " . substr("0" .$today[hours], strlen($today[hours])-1) . ":" . substr("0" . $today[minutes], strlen($today[minutes])-1) . ":" . substr("0" . $today[seconds], strlen($today[seconds])-1);
if($today['wday']==0) {
	$rapporterad = 1;
}
else {
	$rapporterad = 2;
}

	$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
	or die ('Cannot connect to the database: ' . mysql_error());
	mysql_select_db ("quicotse_bill");

		$query = "update ".$xsite."_panel set
		op = '" . $op . "',
		opinnan = '" . $op . "',
		vop = '" . $op . "',
		kategori = '" . $kategori . "',
		kommentar = '" . $kommentar . "',
		medlem = '" . $medlem . "',
		ejsvar = ejsvar + " . $ejsvar . ",
		tid = '" . $mynow . "',
		vecka = '" . $week . "'
		where telefon = '" . $telefon . "';";

//echo $query;
	mysql_query($query)
	or die("Cannot get data from the database:"  . mysql_error());

	mysql_close($connection);

?>

    </td>
  </tr>
</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/includes/footer.php"); ?>


