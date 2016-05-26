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

$teststring = $_POST['distrikt'];
$testarray = explode(chr(13).chr(10),$teststring);

$firstline = "#". chr(9). "Distrikt" . chr(9). "Op";

if(preg_match("/$firstline/i", $testarray[0])){
	$start_on_line = 1;
}
else {
	$start_on_line = 0;
}

for($i=$start_on_line; $i<count($testarray); $i++) {

	if(strlen($testarray[$i]) > 4) { //man kan ju inte vara allvarlig med att försöka peta in en rad på mindre än fem tecken
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
			}
		}
	}
}

$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

for($i=$start_on_line; $i<count($testarray); $i++) {

	if(strlen($testarray[$i]) > 4) { //man kan ju inte vara allvarlig med att försöka peta in en rad på mindre än fem tecken

		$okstring = "";

		$testarray2 = explode(chr(9),$testarray[$i]);

		$distr = substr("000" . $testarray2[1], strlen($testarray2[1])-1);

		$query = "update ".$xsite."_distrikt set op = '" . $testarray2[2] . "'
		where distrikt = '" . $distr . "';";

		$okstring = $okstring . " " . $testarray[$i] . " ";

		mysql_query($query);

		$query = "update ".$xsite."_panel set op = '" . $testarray2[2] . "'
		where distrikt = '" . $distr . "';";

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
