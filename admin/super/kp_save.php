<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n
<meta http-equiv=refresh content=1;URL=kp.php>";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../../includes/header.php");
?>

<!-- page start -->
<p>
sparar..
</p>
<?

$teststring = $_POST['distrikt'];
$testarray = explode("¤¤¤".chr(13).chr(10),$teststring);
//$testarray = explode(chr(13).chr(10),$teststring); funar inte det finns massa skräp cr
//print_r($testarray);

$firstline = "distr". chr(9). "kat". chr(9). "adress". chr(9). "namn". chr(9). "uppringd". chr(9). "vecka". chr(9). "av". chr(9). "telefon". chr(9). "telefontid". chr(9). "svar". chr(9). "kommentar". chr(9). "trycksaker";

if(preg_match("/$firstline/i", $testarray[0])){
	$start_on_line = 1;
}
else {
	$start_on_line = 0;
}

for($i=$start_on_line; $i<count($testarray); $i++) {

	if(strlen($testarray[$i]) > 5) { //man kan ju inte vara allvarlig med att försöka peta in en rad på mindre än fem tecken
		$testarray2 = explode(chr(9),$testarray[$i]);

		for($j=0; $j<count($testarray2); $j++) {

			switch ($j) {
			case "0":
				if(!preg_match("/^\d{1,4}$/i", $testarray2[$j])){
					exit("<b>Ett fel upptäcktes på rad " . $i . ":</b><br><br>'" . $testarray2[$j] . "'<br><br>distr måste innehålla 1-4 st siffror. <i>Ex) 1</i>" );
				}
			   break;
			case "1":
				if(!preg_match("/^\d{1,1}$/i", $testarray2[$j])){
					exit("<b>Ett fel upptäcktes på rad " . $i . ":</b><br><br>'" . $testarray2[$j] . "'<br><br>kat måste innehålla en siffra. <i>Ex) 1</i>" );
				}
			   break;
			// case 2 skippar jag så länge, vet inte om det alltid finns
			// case 3 skippar jag så länge, vet inte om det alltid finns
			// case 4 skippar jag så länge, vet inte om det alltid finns
			// case 5 skippar jag så länge, vet inte om det alltid finns
			// case 6 skippar jag så länge, vet inte om det alltid finns
			case "7":
				if(!preg_match("/^\d{2,4}-\d{2}/i", $testarray2[$j])){
					exit("<b>Ett fel upptäcktes på rad " . $i . ":</b><br><br>'" . $testarray2[$j] . "'<br><br>Telefon måste innehålla 2-4 siffor ett bindestreck 0ch minst 2 siffror till." );
				}
			   break;
			// case 8 skippar jag så länge, vet inte om det alltid finns
			// case 9 skippar jag så länge, vet inte om det alltid finns
			// case 10 skippar jag så länge, vet inte om det alltid finns
			// case 11 skippar jag så länge, vet inte om det alltid finns
			}
		}
	}
}

$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

mysql_query("TRUNCATE TABLE `".$xsite."_kp`;");

for($i=$start_on_line; $i<count($testarray); $i++) {

	if(strlen($testarray[$i]) > 5) { //man kan ju inte vara allvarlig med att försöka peta in en rad på mindre än fem tecken

		$okstring = "";

		$testarray2 = explode(chr(9),$testarray[$i]);

		$distr = sprintf("%04d", $testarray2[0]);

		$adressarr = explode("," ,$testarray2[2]);

		$adress = $adressarr[0];
		$postadress = substr($adressarr[1], 1, 5);
		$ort = substr($adressarr[1], 7);

		$query = "insert into ".$xsite."_kp (distrikt, kategori, adress, postadress, ort, namn,
		uppringd, vecka, op, telefon, telefontid, svar, kommentar, trycksaker) values (
		'$distr', '$testarray2[1]', '$adress', '$postadress', '$ort', '$testarray2[3]', '$testarray2[4]',
		'$testarray2[5]', '$testarray2[6]', '$testarray2[7]', '$testarray2[8]',
		'$testarray2[9]', '$testarray2[10]', '$testarray2[11]');";

		mysql_query($query);

//		echo $query;

		if (mysql_error() == '') {
//			echo ($okstring . "<b> ..OK!</b><br>");
		}
		else {
			echo ("<b>Error: </b>" . mysql_error() . "<br>");
		}
	}
}

mysql_close($connection);
?>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../../includes/footer.php"); ?>
