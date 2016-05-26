<?
if (!is_null($_GET["order"])) {
	setcookie("order", $_GET["order"], time()+86400);
	$order = $_GET["order"];
}
?>
<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Matris v" . $_GET["vecka"];
include_once realpath(dirname(__FILE__)."/../includes/header.php");
?>

<!-- page start -->
<?
$year = $today[year];

if (is_null($_GET["vecka"])) {
	$vecka = get_week_number($mytime, -OFFSET_DAYS);
}
else {
	$vecka = $_GET["vecka"];
}

$weeks = array();

$gyear = $year - 1;

// ett år tillbaka och två fram, eller nått??
for($i=1;$i<4;$i++) {

	for($j=1;$j<53;$j++) {
		array_push($weeks, $gyear . substr("0" . $j, strlen($j)-1));
	}

	$gyear = $gyear +1;
}

$key = array_search($vecka, $weeks);

?>

<input type=hidden name=vecka value="<?php echo $vecka ?>">

<table width=100% border="0">
  <tr>
    <td width=120><b>Matris v<? echo $vecka ?></b></td><td width=60><a href=matrissok.php>Sök</a></td><td width=60><a href="#<? echo $_COOKIE["distrikt"] ?>" title="Snabblänk, senast sparade"><? echo $_COOKIE["distrikt"] ?></a></td>
      <td>
		&nbsp;<a href=<? echo $_SERVER['PHP_SELF']?>?vecka=<? echo $weeks[$key-5] ?>><? echo substr($weeks[$key-5],4) ?></a>
        &nbsp;<a href=<? echo $_SERVER['PHP_SELF']?>?vecka=<? echo $weeks[$key-4] ?>><? echo substr($weeks[$key-4],4) ?></a>
        &nbsp;<a href=<? echo $_SERVER['PHP_SELF']?>?vecka=<? echo $weeks[$key-3] ?>><? echo substr($weeks[$key-3],4) ?></a>
        &nbsp;<a href=<? echo $_SERVER['PHP_SELF']?>?vecka=<? echo $weeks[$key-2] ?>><? echo substr($weeks[$key-2],4) ?></a>
        &nbsp;<a href=<? echo $_SERVER['PHP_SELF']?>?vecka=<? echo $weeks[$key-1] ?>><? echo substr($weeks[$key-1],4) ?></a>
        &nbsp;<b><? echo substr($weeks[$key],4) ?> </B>
		&nbsp;<a href=<? echo $_SERVER['PHP_SELF']?>?vecka=<? echo $weeks[$key+1] ?>><? echo substr($weeks[$key+1],4) ?></a>
        &nbsp;<a href=<? echo $_SERVER['PHP_SELF']?>?vecka=<? echo $weeks[$key+2] ?>><? echo substr($weeks[$key+2],4) ?></a>
        &nbsp;<a href=<? echo $_SERVER['PHP_SELF']?>?vecka=<? echo $weeks[$key+3] ?>><? echo substr($weeks[$key+3],4) ?></a>
        &nbsp;<a href=<? echo $_SERVER['PHP_SELF']?>?vecka=<? echo $weeks[$key+4] ?>><? echo substr($weeks[$key+4],4) ?></a>
        &nbsp;<a href=<? echo $_SERVER['PHP_SELF']?>?vecka=<? echo $weeks[$key+5] ?>><? echo substr($weeks[$key+5],4) ?></a>
        &nbsp;<a href=<? echo $_SERVER['PHP_SELF']?>?vecka=<? echo $weeks[$key+6] ?>><? echo substr($weeks[$key+6],4) ?></a>
        &nbsp;<a href=<? echo $_SERVER['PHP_SELF']?>?vecka=<? echo $weeks[$key+7] ?>><? echo substr($weeks[$key+7],4) ?></a>
        &nbsp;<a href=<? echo $_SERVER['PHP_SELF']?>?vecka=<? echo $weeks[$key+8] ?>><? echo substr($weeks[$key+8],4) ?></a>
        &nbsp;<a href=<? echo $_SERVER['PHP_SELF']?>?vecka=<? echo $weeks[$key+9] ?>><? echo substr($weeks[$key+9],4) ?></a>
        &nbsp;<a href=<? echo $_SERVER['PHP_SELF']?>?vecka=<? echo $weeks[$key+10] ?>><? echo substr($weeks[$key+10],4) ?></a>
        &nbsp;<a href=<? echo $_SERVER['PHP_SELF']?>?vecka=<? echo $weeks[$key+11] ?>><? echo substr($weeks[$key+11],4) ?></a>
        &nbsp;<a href=<? echo $_SERVER['PHP_SELF']?>?vecka=<? echo $weeks[$key+12] ?>><? echo substr($weeks[$key+12],4) ?></a>
      </td>
  </tr>
</table>

  <table width=100% border="0">
<?
if (!is_null($_COOKIE['order'])) {
	$order = $_COOKIE['order'];
}

if (is_null($vecka)) {
	exit("ange vecka");
}

if (is_null($order)) {
	$sqlorder = "".$xsite."_distrikt.distrikt";
	$order = "distrikt";
}

if ($order == 'namn') {
	$sqlorder = "".$xsite."_bokning.namn";
}

if ($order == 'distrikt') {
	$sqlorder = "".$xsite."_distrikt.distrikt";
}


echo "<tr>
	<td width=30 align=right><a href=refresh.php?vecka=" . $vecka . " title='Uppdatera nej svar'>Uppd</a></td>
		<td width=120 align=left>Klar</td>
		<td width=30 align=left>Svar</td>
		<td width=60 align=left><a href=redirect1.php?vecka=" . $vecka . "&order=distrikt title='Sortera på Distrikt'>Distrikt</a></td>
		<td width=200 align=left><a href=redirect1.php?vecka=" . $vecka ."&order=namn title='Sortera på Namn'>Namn</a></td>
		<td>Kommentar</td>
		<td>Panelkommentar</td>
	</tr>\n";

// samma nivå= enklare user admin $filename = "files/" . $order . $vecka . ".inc";
$filename = "./" . $order . $vecka . ".inc";

if (file_exists($filename)) {
	include($filename);
}
else {

	$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
	or die ('Cannot connect to the database: ' . mysql_error());
	mysql_select_db ("quicotse_bill");

	$query = "SELECT ".$xsite."_distrikt.distrikt AS distr, ".$xsite."_bokning.*
	FROM ".$xsite."_distrikt
	LEFT JOIN ".$xsite."_bokning
	ON ".$xsite."_distrikt.distrikt = ".$xsite."_bokning.distrikt
	AND ".$xsite."_bokning.vecka = '" . $vecka . "'
	ORDER BY " . $sqlorder . "
	LIMIT 999;";

	$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

	$count = 1;

	while($row = mysql_fetch_assoc($result)) {

		if (strlen($row['kommentar']) < 3) { //ta i lite extra. 1 räckte inte pga radbryt
			$kommentar = "Skapa";
		}
		else {
			$kommentar = $row['kommentar'];
		}
			$kommentar3 = $row['kommentar3'];

			$somecontent = $somecontent . "<tr>
			<td align=right>" . $count ."</td>
			<td><div align=center>";
			if (!empty($row['kommentar2'])) {
				$somecontent = $somecontent	. "<a href=edit1.php?matris=1&distrikt=" . $row['distr'] . "&order=" . $order ."&vecka=" . $vecka ." title='" . preg_replace("/<BR>/", "", $row['kommentar2']) . "'>" . $row['tidklar'] . "</a>";
			}
			else {
				$somecontent = $somecontent	. $row['tidklar'];
			}
			$somecontent = $somecontent	. "</div></td>
			<td><div align=center>";
			if ($row['nejsvar'] > 0) {
				$somecontent = $somecontent	. "N" . $row['nejsvar'] . "</div></td>";
			}
			$somecontent = $somecontent	. "<td><a href=svar3.php?distrikt=" . $row['distr'] .">" . $row['distr'] ."</a></td>
			<td><a href=svar4.php?namn=" . urlencode($row['namn']) .">" . $row['namn'] ."</a></td>
			<td><a href=edit1.php?matris=1&distrikt=" . $row['distr'] . "&order=" . $order ."&vecka=" . $vecka ." title='" . $kommentar ."'>" . substr($kommentar, 0, 40) ."</a></td>
			<td><a href=svar3.php?distrikt=" . $row['distr'] . "&view=1#mer title='" . $kommentar3 ."'>" . substr($kommentar3, 0, 40) ."</a></td>
			</tr>\n";

		$count++;
	}

    if (!$handle = fopen($filename, 'w')) {
         echo "Cannot open file ($filename)";
         exit;
    }

    if (fwrite($handle, $somecontent) === FALSE) {
        echo "Cannot write to file ($filename)";
        exit;
    }

    fclose($handle);

	include($filename);
}

echo "</form>";
?>
</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../includes/footer.php"); ?>

