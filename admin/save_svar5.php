<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n
<meta http-equiv=refresh content=1;URL=svar5.php?distrikt=" . $_POST["distrikt"] . ">";
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
	$distrikt = $_POST["distrikt"];
	$kommentar = $_POST["kommentar"];

	$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
	or die ('Cannot connect to the database: ' . mysql_error());
	mysql_select_db ("quicotse_bill");

	$query = "update ".$xsite."_distrikt set kommentar = '$kommentar' WHERE distrikt = '$distrikt';";

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
