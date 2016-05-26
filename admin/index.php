<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../includes/header.php");
?>

<!-- page start -->
<?
$week = get_week_number($mytime, -OFFSET_DAYS);
$month = $today[year] .  substr("0" . $today[mon], strlen($today[mon])-1);
$mynow = $today[year] . "-" . substr("0" .$today[mon], strlen($today[mon])-1). "-" . substr("0" .$today[mday], strlen($today[mday])-1);
?>

<table width="100%" border="0">
  <tr valign="top">
    <td>
      <p><b>PANELSVAR</b></p>
      <p>
        &nbsp;<a href="svar6.php?vecka=<?echo $week?>">Panelsvar (Nejsvar)</a><br>
        &nbsp;<a href="rep5.php?vecka=<?echo $week?>">Panelsvar (Special)</a><br>
        &nbsp;<a href="antalsvar.php">Panelsvar (Summa per vecka)</a><br>
        &nbsp;<a href="rep2.php?vecka=<?echo $week?>">Panelsvar (Summering)</a><br>
        &nbsp;<a href="svar2.php?vecka=<?echo $week?>">Panelsvar (Utförlig)</a><br>
	</td>
    <td>
      <p><b>RAPPORTER</b></p>
      <p>&nbsp;<a href="rep6.php?mon=<? echo $month ?>">Arbetstid kommunikatör</a><br>
        &nbsp;<a href="matris3.php">Matris (Innehåller avtal)</a><br>
        &nbsp;<a href="../../../../rep2.php">Matris (Ändring körordning)</a><br>
        <!--&nbsp;<a href="ringlista.php">Ringlista (Fördelning)</a><br>-->
        &nbsp;<a href="antalutdelare.php">Utdelare (Antal)</a><br></p>
	</td>
    <td>
      <p><b>CENTRALEN FOX M.M.</b></p>
      <p>&nbsp;<a href="distrikt_kartor.php">Distrikt</a><br>
		&nbsp;<a href="z:\standardbrev\">Standardbrev</a><br>
		&nbsp;<a href="super/">Superadmin</a><br></p>
	</td>
  </tr>
</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../includes/footer.php"); ?>




