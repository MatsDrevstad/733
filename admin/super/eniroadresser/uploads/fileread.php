<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../../../../includes/header.php");
?>

<!-- page start -->
<?
$myFile = $_GET[filename];
$distrikt = substr($myFile, 0, 4);
//funkar inte pga http://se.php.net/fopen safe mode
//echo $uploaddir . $myFile;
$fh = fopen($myFile, 'r');
$theData = fread($fh, filesize($myFile));
fclose($fh);
//echo $theData;

$teststring = $theData;
$testarray = explode(chr(13).chr(10),$teststring);
//print_r($testarray);

$firstline = "Namn". chr(9). "Adress". chr(9). "Postadress". chr(9). "Ort". chr(9). "Telefonnummer";

if(preg_match("/$firstline/i", $testarray[0])){
	$start_on_line = 1;
}
else {
	$start_on_line = 0;
}

for($i=$start_on_line; $i<count($testarray); $i++) {

	if(strlen($testarray[$i]) > 5) { //man kan ju inte vara alvarlig med att försöka peta in en rad på mindre än fem tecken
		$testarray2 = explode(chr(9),$testarray[$i]);
		for($j=0; $j<count($testarray2); $j++) {

			switch ($j) {
			case "0":
				if(!preg_match("/^\D{5,}$/i", $testarray2[$j])){
					exit("<b>Ett fel upptäcktes på rad " . $i . ":</b><br><br>'" . $testarray2[$j] . "'<br><br>Namn måste innehålla minst fem tecken och inga siffror. <i>Ex) Efternamn, Förnamn</i>" );
				}
			   break;
			case "1":
				if(!preg_match("/\D{1,}/i", $testarray2[$j])) {
					exit("<b>Ett fel upptäcktes på rad " . $i . ":</b><br><br>'" . $testarray2[$j] . "'<br><br>Adress måste innehålla minst 1 tecken som inte är en siffra. <i>Ex) Kungsgatan 10</i>" );
				}
			   break;
			case "2":
				if(!preg_match("/^\d{3,3}\s\d{2,2}$/i", $testarray2[$j])){
					exit("<b>Ett fel upptäcktes på rad " . $i . ":</b><br><br>'" . $testarray2[$j] . "'<br><br>Postadress måste innehålla 6 tecken. <i>Ex) 504 60</i>" );
				}
			   break;
			case "3":
				if(!preg_match("/^\D{2,}$/i", $testarray2[$j])){
					exit("<b>Ett fel upptäcktes på rad " . $i . ":</b><br><br>'" . $testarray2[$j] . "'<br><br>Ort måste innehålla minst 2 tecken och inga siffror. <i>Ex) ÅS</i>" );
				}
			   break;
			case "4":
				if(!preg_match("/^\d{2,4}-\d{2,3}\s\d{2,3}/i", $testarray2[$j])){
					exit("<b>Ett fel upptäcktes på rad " . $i . ":</b><br><br>'" . $testarray2[$j] . "'<br><br>Telefonnummer måste innehålla minst 2, 3 eller 4 siffor, bindestreck och ytterligare minst 2 siffor, samt bindestreck och ytterligare minst 2 siffor. <i>Ex) 033-22 33 44</i>" );
				}
			   break;
			}
		}
	}
}


$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

$query = "SELECT op FROM ".$xsite."_distrikt WHERE distrikt = '$distrikt';";

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

while($row = mysql_fetch_assoc($result)) {

	$op = $row['op'];

}

mysql_free_result($result);

$query = "SELECT trycksaker, kontroll FROM ".$xsite."_panel WHERE distrikt = '$distrikt';";

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

while($row = mysql_fetch_assoc($result)) {

	$kontroll = $row['kontroll'];
	$trycksaker = $row['trycksaker'];

}

mysql_free_result($result);

// sätt in vecka noll här. det kommer inte inom överskådlig tid gå att värva samtidigt som panel
// men man vill ju ringa dom här ganska fort, dels för att kolla ett och annat.
// sen beror det ju även på vad som sätts vid själva svaret.
$vecka = 0;

for($i=$start_on_line; $i<count($testarray); $i++) {

	if(strlen($testarray[$i]) > 5) { //man kan ju inte vara allvarlig med att försöka peta in en rad på mindre än fem tecken

		$query = "insert into ".$xsite."_panel (distrikt, vecka, kategori, op, kontroll, trycksaker, namn, adress, postadress, ort, telefon) values ('" . $distrikt ."','" . $vecka . "','2','$op','$kontroll','$trycksaker',";

		$okstring = "";

		$testarray2 = explode(chr(9),$testarray[$i]);

			$query = $query . "'" . $testarray2[0] . "', ";
			$okstring = $okstring . " " . $testarray2[0] . " ";

			$query = $query . "'" . $testarray2[1] . "', ";
			$okstring = $okstring . " " . $testarray2[1] . " ";

			$query = $query . "'" . substr($testarray2[2], 0, 3) . substr($testarray2[2], 4, 2) . "', ";
			$okstring = $okstring . " " . $testarray2[2] . " ";

			$query = $query . "'" . $testarray2[3] . "', ";
			$okstring = $okstring . " " . $testarray2[3] . " ";

			$query = $query . "'" . $testarray2[4] . "' ";
			$okstring = $okstring . " " . $testarray2[4] . " ";

			$query = $query . ");";

		mysql_query($query);
//		echo $query;

		if (mysql_error() == '') {
			echo ($okstring . "<b> ..OK!</b><br>");
		}
		else {
			echo ("<b>Error: </b>" . mysql_error() . "<br>");
		}
	}
}

mysql_close($connection);
?>
<a href="../upload_form.php">upload_form.php</a>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../../../../includes/footer.php"); ?>
