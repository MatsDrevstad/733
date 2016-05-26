<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n
<meta http-equiv=refresh content=1;URL=distrikt.php>";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../../includes/header.php");
?>

<!-- page start -->
<p><b>
  sparar..</b><b><a href="distrikt_update.php">
  </a></b>  </p>
<?

$distrikt = $_GET['distrikt'];
$kontroll2 = $_GET['kontroll'];

$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

$query = "SELECT kontroll FROM ".$xsite."_panel WHERE distrikt = '$distrikt';";
$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

while($row = mysql_fetch_assoc($result)) {

	$kontroll = $row['kontroll'];
}

//konfigurationen är att man ska kunna sätta ett distrikt till 2 eller 3 (inkl 4)
//Om ett distrikt är satt till 3 (eller 4) kan man inte ändra tillbaka igen

if ($kontroll > '2') {

	//gör ingenting med ".$xsite."_panel (den kan juinnehålla fyror oxå)

	//sätt kontroll = 3 för distrikttabellen
	$query = "update ".$xsite."_distrikt set kontroll = 3 where distrikt = '$distrikt';";
	mysql_query($query)
	or die("Cannot get data from the database:"  . mysql_error());
}
elseif ($kontroll == '1') {

	//sätt kontroll = 2 för ".$xsite."_panel
	$query = "update ".$xsite."_panel set kontroll = 2 where distrikt = '$distrikt';";
	mysql_query($query)
	or die("Cannot get data from the database:"  . mysql_error());

	//sätt kontroll = 2 för distrikttabellen
	$query = "update ".$xsite."_distrikt set kontroll = 2 where distrikt = '$distrikt';";
	mysql_query($query)
	or die("Cannot get data from the database:"  . mysql_error());
}
elseif ($kontroll == '2') {

	//sätt kontroll = 3 för ".$xsite."_panel
	$query = "update ".$xsite."_panel set kontroll = 3 where distrikt = '$distrikt';";
	mysql_query($query)
	or die("Cannot get data from the database:"  . mysql_error());

	//sätt kontroll = 3 för distrikttabellen
	$query = "update ".$xsite."_distrikt set kontroll = 3 where distrikt = '$distrikt';";
	mysql_query($query)
	or die("Cannot get data from the database:"  . mysql_error());
}
else {
	echo "FEL: Inget eller fel kontrollnummer";
}

mysql_close($connection);
?>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../../includes/footer.php"); ?>
