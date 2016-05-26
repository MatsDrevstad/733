<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n
<meta http-equiv=refresh content=1;URL=distrikt.php>";
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
$testarray = explode(chr(13).chr(10),$teststring);
//print_r($testarray);

$firstline = "#". chr(9). "Distrikt" . chr(9). "Op". chr(9). "Max svar". chr(9). "Ja svar". chr(9). "Nej svar 1". chr(9). "Nej svar 2". chr(9). "Kontroll". chr(9). "Kommentar". chr(9). "Uppdrag";

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
				if(!preg_match("/^\d{1,3}$/i", $testarray2[$j])){
					exit("<b>Ett fel upptäcktes på rad " . $i . ":</b><br><br>'" . $testarray2[$j] . "'<br><br># måste innehålla minst en siffra. <i>Ex) 1</i>" );
				}
			   break;
			case "1":
				if(!preg_match("/^\d{1,4}$/i", $testarray2[$j])){
					exit("<b>Ett fel upptäcktes på rad " . $i . ":</b><br><br>'" . $testarray2[$j] . "'<br><br>Distrikt måste innehålla minst en siffra. <i>Ex) 1010</i>" );
				}
			   break;
			case "2":
				if(strlen($testarray[$j]) > 0) {
					if(!preg_match("/^\D{2,2}$/i", $testarray2[$j])){
						exit("<b>Ett fel upptäcktes på rad " . $i . ":</b><br><br>'" . $testarray2[$j] . "'<br><br>Op måste innehålla 2 tecken och inga siffror, eller ingenting. <i>Ex) AB</i>" );
					}
				   break;
				}
			case "3":
				if(!preg_match("/^\d{1,1}$/i", $testarray2[$j])){
					exit("<b>Ett fel upptäcktes på rad " . $i . ":</b><br><br>'" . $testarray2[$j] . "'<br><br>Max svar måste innehålla en siffra. <i>Ex) 0</i>" );
				}
			   break;
			case "4":
				if(!preg_match("/^\d{1,1}$/i", $testarray2[$j])){
					exit("<b>Ett fel upptäcktes på rad " . $i . ":</b><br><br>'" . $testarray2[$j] . "'<br><br>Ja svar måste innehålla en siffra. <i>Ex) 0</i>" );
				}
			   break;
			case "5":
				if(!preg_match("/^\d{1,1}$/i", $testarray2[$j])){
					exit("<b>Ett fel upptäcktes på rad " . $i . ":</b><br><br>'" . $testarray2[$j] . "'<br><br>Nej svar 1 måste innehålla en siffra. <i>Ex) 0</i>" );
				}
			   break;
			case "6":
				if(!preg_match("/^\d{1,1}$/i", $testarray2[$j])){
					exit("<b>Ett fel upptäcktes på rad " . $i . ":</b><br><br>'" . $testarray2[$j] . "'<br><br>Nej svar 2 måste innehålla en siffra. <i>Ex) 0</i>" );
				}
			   break;
			case "7":
				if(!preg_match("/^(1|2|3|4)$/i", $testarray2[$j])){
					exit("<b>Ett fel upptäcktes på rad " . $i . ":</b><br><br>'" . $testarray2[$j] . "'<br><br>Kontroll måste vara 0, 1 eller 2. <i>Ex) 1</i>" );
				}
			   break;
			}
		}
	}
}

$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

for($i=$start_on_line; $i<count($testarray); $i++) {

	if(strlen($testarray[$i]) > 5) { //man kan ju inte vara allvarlig med att försöka peta in en rad på mindre än fem tecken

		$okstring = "";

		$testarray2 = explode(chr(9),$testarray[$i]);

		$distr = substr("000" . $testarray2[1], strlen($testarray2[1])-1);

		$query = "update ".$xsite."_distrikt set op = '" . $testarray2[2] . "',
		maxsvar = '" . $testarray2[3] . "', jasvar = '" . $testarray2[4] . "',  nejsvar_1 = '" . $testarray2[5] . "',
		nejsvar_2 = '" . $testarray2[6] . "', kontroll = '" . $testarray2[7] . "'
		, kommentar = '" . $testarray2[8] . "' , uppdrag = '" . $testarray2[9] . "' where distrikt = '" . $distr . "';";

		$okstring = $okstring . " " . $testarray[$i] . " ";

		mysql_query($query);

		$query = "update ".$xsite."_panel set op = '" . $testarray2[2] . "',
		maxsvar = '" . $testarray2[3] . "', jasvar = '" . $testarray2[4] . "',  nejsvar_1 = '" . $testarray2[5] . "',
		nejsvar_2 = '" . $testarray2[6] . "', kontroll = '" . $testarray2[7] . "' , uppdrag = '" . $testarray2[9] . "' where distrikt = '" . $distr . "';";

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
