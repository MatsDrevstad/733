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
$arrskypeuser = explode("." , $myFile);
$skypeuser = $arrskypeuser[0];
//funkar inte pga http://se.php.net/fopen safe mode
//echo $uploaddir . $myFile;
$fh = fopen($myFile, 'r');
$theData = fread($fh, filesize($myFile));
fclose($fh);
//echo $theData;

$teststring = $theData;
//$testarray = explode(chr(13).chr(10),$teststring);
$testarray = explode(chr(10),$teststring);
//print_r($testarray);

$start_on_line = 1;

for($i=$start_on_line; $i<count($testarray); $i++) {

	if(strlen($testarray[$i]) > 5) { //man kan ju inte vara alvarlig med att försöka peta in en rad på mindre än fem tecken
		$testarray2 = explode(";",$testarray[$i]);
		for($j=0; $j<count($testarray2); $j++) {

			switch ($j) {
			case "0":
				if(!preg_match("/^\"(Jan|Feb|Mar|Apr|Maj|May|Jun|Jul|Aug|Sep|Okt|Oct|Nov|Dec)\s\d{2,2},\s\d{4,4}\s\d{2,2}:\d{2,2}\"$/i", $testarray2[$j])){
					exit("<b>Ett fel upptäcktes på 1rad " . $i . ":</b><br><br>'" . $testarray2[$j] . "'<br><br></i>" );
				}
			   break;
			case "1":
				if(!preg_match("/\d{7,15}/i", $testarray2[$j])) {
					exit("<b>Ett fel upptäcktes på 2rad " . $i . ":</b><br><br>'" . $testarray2[$j] . "'<br><br></i>" );
				}
			   break;
			case "5":
				if(!preg_match("/^\d{2,2}:\d{2,2}$/i", $testarray2[$j])){
					exit("<b>Ett fel upptäcktes på 3rad " . $i . ":</b><br><br>'" . $testarray2[$j] . "'<br><br></i>" );
				}
			   break;
			}
		}
	}
}


$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

$query = "update 733_svar set telefonip = replace(telefon, ' ', '') where telefonip = '';";
mysql_query($query);

$query = "update 733_svar set telefonip = replace(telefonip, '-', '') where telefonip like '%-%';";
mysql_query($query);

for($i=$start_on_line; $i<count($testarray); $i++) {

	if(strlen($testarray[$i]) > 5) { //man kan ju inte vara allvarlig med att försöka peta in en rad på mindre än fem tecken

		$query = "insert into ".$xsite."_svar  ('" . $skypeuser ."',";

		$okstring = "";

		$testarray2 = explode(";",$testarray[$i]);

		$query = "update ".$xsite."_svar set tidip = '" . fixdatum($testarray2[0]) . "' ,
		varaktip = '" . $testarray2[5] . "' ,
		ipanvandare = '" . $skypeuser . "'
		where telefonip = '" . fixtel($testarray2[1]) . "' and
		tid like '" . substr(fixdatum($testarray2[0]), 0, 10) . "%'";

		mysql_query($query);
//		echo $query;

		if (mysql_error() == '') {
			echo ("<b>".$query."<br>");
		}
		else {
			echo ("<b>Error: </b>" . mysql_error() . "<br>");
		}
	}
}

function fixtel($strd) {

	$strd = "0" . substr($strd, 3);

	return $strd;

}

function fixdatum($strd) {

	if (strcmp(substr($strd, 1, 3), 'Jan') == 0) {
		$mon = '01';
	}
	if (strcmp(substr($strd, 1, 3), 'Feb') == 0) {
		$mon = '02';
	}
	if (strcmp(substr($strd, 1, 3), 'Mar') == 0) {
		$mon = '03';
	}
	if (strcmp(substr($strd, 1, 3), 'Apr') == 0) {
		$mon = '04';
	}
	if (strcmp(substr($strd, 1, 3), 'Maj') == 0 || strcmp(substr($strd, 1, 3), 'May') == 0) {
		$mon = '05';
	}
	if (strcmp(substr($strd, 1, 3), 'Jun') == 0) {
		$mon = '06';
	}
	if (strcmp(substr($strd, 1, 3), 'Jul') == 0) {
		$mon = '07';
	}
	if (strcmp(substr($strd, 1, 3), 'Aug') == 0) {
		$mon = '08';
	}
	if (strcmp(substr($strd, 1, 3), 'Sep') == 0) {
		$mon = '09';
	}
	if (strcmp(substr($strd, 1, 3), 'Okt') == 0 || strcmp(substr($strd, 1, 3), 'Oct') == 0) {
		$mon = '10';
	}
	if (strcmp(substr($strd, 1, 3), 'Nov') == 0) {
		$mon = '11';
	}
	if (strcmp(substr($strd, 1, 3), 'Dec') == 0) {
		$mon = '12';
	}

	$strd = substr($strd, 9, 4) . "-" . $mon . "-" . substr($strd, 5, 2) .	" " . substr($strd, 14, 5) . ":00";

	return $strd;

}

mysql_close($connection);
?>
<a href="../upload_form.php">upload_form.php</a>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../../../../includes/footer.php"); ?>
