<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n
<meta http-equiv=refresh content=1;URL=rep5.php?vecka=" . $_POST["vecka"] . "#" . $_POST["id"] . ">";
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
	$telefon = $_POST["telefon"];
	$kommentar = $_POST["kommentar"];

	$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
	or die ('Cannot connect to the database: ' . mysql_error());
	mysql_select_db ("quicotse_bill");

	$query = "update ".$xsite."_panel set kommentar = '$kommentar' WHERE telefon = '$telefon';";

//	echo $query;

	mysql_query($query)
	or die("Cannot get data from the database:"  . mysql_error());

	mysql_close($connection);

?>

    </td>
  </tr>
</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../includes/footer.php"); ?>
