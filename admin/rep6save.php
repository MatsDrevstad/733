<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n
<meta http-equiv=\"refresh\" content=\"1;URL=rep6update.php?f=" . $_POST['f'] . "&id=" . $_POST['id'] . "\">";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../includes/header.php");
?>

<!-- page start -->
Sparar..

<table border="0">

<?
$start = substr($_POST['start1'], 11, 5);
if(strlen($_POST['start2']) > 0) {
	$start = $_POST['start2'];
}
$stopp = substr($_POST['stopp1'], 11, 5);
if(strlen($_POST['stopp2']) > 0) {
	$stopp = $_POST['stopp2'];
}
if( $diff=@get_time_difference($start, $stopp) ) {
   	$tottime = sprintf( '%02d', $diff['minutes'] );
	$tottime = $tottime + 60*sprintf( '%02d', $diff['hours'] );
	$tottime = $tottime+2;
}
if( $tottime < 0.1 ) {
   	$tottime = $tottime * -1;
}
$tottime = round($tottime/60, 2);
$id = $_POST['id'];

$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

$query = "UPDATE ".$xsite."_tid SET start2 = '" . substr($_POST['start1'], 0, 11). $start . ":00', stopp2 = '" .  substr($_POST['start1'], 0, 11). $stopp . ":00', forsoktid = '" . $tottime . "' WHERE id = '" . $id . "' limit 1;";
mysql_query($query)
or die("Cannot get data from the database:"  . mysql_error());

if(!strlen($_POST['start2']) > 0) {
	$query = "UPDATE ".$xsite."_tid SET start2 = '0000-00-00 00:00:00' WHERE id = '" . $id . "' limit 1;";
	mysql_query($query)
	or die("Cannot get data from the database:"  . mysql_error());
}

if(!strlen($_POST['stopp2']) > 0) {
	$query = "UPDATE ".$xsite."_tid SET stopp2 = '0000-00-00 00:00:00' WHERE id = '" . $id . "' limit 1;";
	mysql_query($query)
	or die("Cannot get data from the database:"  . mysql_error());
}

mysql_close($connection);

?>
</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../includes/footer.php"); ?>
