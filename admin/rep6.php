<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../includes/header.php");
?>

<!-- page start -->
<?
$months = array();

$year = $today[year];
$month = $_GET["mon"];
$visaantal_ar = 11;
$gyear = $year - $visaantal_ar;

for($i=0;$i<=$visaantal_ar;$i++) {
	for($j=1;$j<=12;$j++) {
		array_push($months, $gyear . substr("0" . $j, strlen($j)-1));
	}

	$gyear = $gyear +1;
}

$key = array_search($month, $months);

$mynow = $today[year] . "-" . substr("0" .$today[mon], strlen($today[mon])-1) . "-" . substr("0" .$today[mday], strlen($today[mday])-1);
?>
<a href="rep4.php?tid=<?echo $mynow?>"><?echo $mynow?></a>
<table width=100% border="0">
  <tr>
    <td width=188><b>Månad</b></td><td width=10></td>
      <td>
		&nbsp;<a href=<? echo $_SERVER['PHP_SELF']?>?mon=<? echo $months[$key-5] ?>><? echo $months[$key-5] ?></a>
        &nbsp;<a href=<? echo $_SERVER['PHP_SELF']?>?mon=<? echo $months[$key-4] ?>><? echo $months[$key-4] ?></a>
        &nbsp;<a href=<? echo $_SERVER['PHP_SELF']?>?mon=<? echo $months[$key-3] ?>><? echo $months[$key-3] ?></a>
        &nbsp;<a href=<? echo $_SERVER['PHP_SELF']?>?mon=<? echo $months[$key-2] ?>><? echo $months[$key-2] ?></a>
        &nbsp;<a href=<? echo $_SERVER['PHP_SELF']?>?mon=<? echo $months[$key-1] ?>><? echo $months[$key-1] ?></a>
        &nbsp;<b><? echo $months[$key] ?> </B>
        &nbsp;<a href=<? echo $_SERVER['PHP_SELF']?>?mon=<? echo $months[$key+1] ?>><? echo $months[$key+1] ?></a>
        &nbsp;<a href=<? echo $_SERVER['PHP_SELF']?>?mon=<? echo $months[$key+2] ?>><? echo $months[$key+2] ?></a>
      </td>
  </tr>
</table>

<table border="0">

<?

$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

$query = "SELECT * FROM ".$xsite."_tid WHERE start1 LIKE '" . substr($months[$key], 0 , 4) . "-" . substr($months[$key], 4, 2) . "%';";

$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

	echo "<tr><td>Dag</td>\n";
	echo "<td>Ändra&nbsp;</td>\n";
	echo "<td>Start1&nbsp;</td>\n";
	echo "<td>Start2&nbsp;</td>\n";
	echo "<td>Ändra&nbsp;</td>\n";
	echo "<td>Stopp1&nbsp;</td>\n";
	echo "<td>Stopp2&nbsp;</td>\n";
	echo "<td>Op&nbsp;</td>\n";
	echo "<td>Försok&nbsp;</td>\n";
	echo "<td>Svar&nbsp;</td>\n";
	echo "<td>Tid (försök)*&nbsp;</td>\n";
	echo "<td>Tid (svar)&nbsp;</td>\n";
	echo "<td>Försök 10h&nbsp;</td>\n";
	echo "<td>Svar 10h&nbsp;</td></tr>\n";

$patterns[0] = '/^00:00$/';
$patterns[1] = '/^0$/';
$patterns[2] = '/^0,00$/';
$replacement = '';
echo preg_replace($patterns, $replacements, $string);

while($row = mysql_fetch_assoc($result)) {

	echo "<tr><td>" . substr($row['start1'], 8, 2) ."</td>\n";
	echo "<td><a href=rep6update.php?f=start2&id=" . $row['id'] . ">ändra</a></td>\n";
	echo "<td>" . preg_replace($patterns, $replacement, substr($row['start1'], 11, 5)) . "</td>\n";
	echo "<td>" . preg_replace($patterns, $replacement, substr($row['start2'], 11, 5)) . "</td>\n";
	echo "<td><a href=rep6update.php?f=stopp2&id=" . $row['id'] . ">ändra</a></td>\n";
	echo "<td>" . preg_replace($patterns, $replacement, substr($row['stopp1'], 11, 5)) . "</td>\n";
	echo "<td>" . preg_replace($patterns, $replacement, substr($row['stopp2'], 11, 5)) . "</td>\n";
	echo "<td>" . $row['op'] . "</td>\n";
	echo "<td>" . preg_replace($patterns, $replacement, $row['forsok']) . "</td>\n";
	echo "<td>" . preg_replace($patterns, $replacement, $row['svar']) . "</td>\n";
	echo "<td>" . preg_replace($patterns, $replacement, str_replace(".", ",", $row['forsoktid'])) . "</td>\n";
	echo "<td>" . preg_replace($patterns, $replacement, str_replace(".", ",", $row['svartid'])) . "</td>\n";
	echo "<td>" . preg_replace($patterns, $replacement, $row['forsok10h']) . "</td>\n";
	echo "<td>" . preg_replace($patterns, $replacement, $row['svar10h']) . "</td></tr>\n";
}
mysql_free_result($result);

?>

</table>
<p><b>* Första samtalet antas
  ta 2 minuter.</b></p>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../includes/footer.php"); ?>
