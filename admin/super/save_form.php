<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n
<meta http-equiv=refresh content=1;URL=form.php?telefon=" . urlencode($_POST['telefon']) .">";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../../includes/header.php");
?>

<!-- page start -->
  <table width="100%" border="0">
    <tr valign="top">
      <td NOWRAP><br>
Sparar
<?
	$resetlp = $_POST["resetlp"];
	$distrikt = $_POST["distrikt"];
	$olddistrikt = $_POST["olddistrikt"];
	$vecka = $_POST["vecka"];
	$telefon = $_POST["telefon"];
	$adress = $_POST["adress"];
	$postadress = $_POST["postadress"];
	$ort = $_POST["ort"];
	$kategori = $_POST["kategori"];
	$namn = $_POST["namn"];
	$kommentar = $_POST["kommentar"];
	$opinnan = strtoupper($_POST["opinnan"]);
	$op = strtoupper($_POST["op"]);
	$vop = strtoupper($_POST["vop"]);
	$trycksaker = $_POST["trycksaker"];
	$medlem = strtoupper($_POST["medlem"]);
	$svar = strtoupper($_POST["svar"]);
	$tid = $_POST["tid"];
	// fixa en ytterligare vecka eftersom vecka kan vara långt tillbaka pga ej svar
	$reset_answer = RESET_ANSWER;
	$week = get_week_number($mytime, -$reset_answer);

	$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
	or die ('Cannot connect to the database: ' . mysql_error());
	mysql_select_db ("quicotse_bill");

	$query = "SELECT svar FROM ".$xsite."_panel WHERE telefon = '$telefon'";

	$result = mysql_query($query)
	or die("Cannot get data from the database:" . mysql_error());

	while($row = mysql_fetch_assoc($result)) {

		$svarinnan = $row['svar'];
	}
	mysql_free_result($result);

	if ($svarinnan == 'N' && $svar != 'N') {

		$query = "update ".$xsite."_bokning set nejsvar = nejsvar-1 where distrikt = '$olddistrikt' and vecka = '$vecka'";
		mysql_query($query) or die("Cannot get data from the database:" . mysql_error());

	}

	if ($svarinnan != 'N' && $svar == 'N') {

		$query = "update ".$xsite."_bokning set nejsvar = nejsvar+1 where distrikt = '$olddistrikt' and vecka = '$vecka'";
		mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

	}

	$query = "update ".$xsite."_svar set svar = '$svar' WHERE telefon = '$telefon' AND vecka = '$week';";
	mysql_query($query) or die("Cannot get data from the database:" . mysql_error());



	if ($resetlp == 1) {
		$query = "update ".$xsite."_panel set
		lp = '0',
		distrikt = '" . $distrikt . "',
		vecka = '" . $vecka . "',
		adress = '" . $adress . "',
		postadress = '" . $postadress . "',
		ort = '" . $ort . "',
		kategori = '" . $kategori . "',
		namn = '" . $namn . "',
		kommentar = '" . $kommentar . "',
		opinnan = '" . $opinnan . "',
		op = '" . $op . "',
		vop = '" . $vop . "',
		trycksaker = '" . $trycksaker . "',
		medlem = '" . $medlem . "',
		svar = '" . $svar . "',
		tid = '" . $tid . "'
		where telefon = '" . $telefon . "';";
	}
	else {
		$query = "update ".$xsite."_panel set
		distrikt = '" . $distrikt . "',
		vecka = '" . $vecka . "',
		adress = '" . $adress . "',
		postadress = '" . $postadress . "',
		ort = '" . $ort . "',
		kategori = '" . $kategori . "',
		namn = '" . $namn . "',
		kommentar = '" . $kommentar . "',
		opinnan = '" . $opinnan . "',
		op = '" . $op . "',
		vop = '" . $vop . "',
		trycksaker = '" . $trycksaker . "',
		medlem = '" . $medlem . "',
		svar = '" . $svar . "',
		tid = '" . $tid . "'
		where telefon = '" . $telefon . "';";
	}

	mysql_query($query)
	or die("Cannot get data from the database:"  . mysql_error());

	mysql_close($connection);

?>

    </td>
  </tr>
</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../../includes/footer.php"); ?>
