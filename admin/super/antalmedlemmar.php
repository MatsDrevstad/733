<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../../includes/header.php");
?>

<!-- page start -->
<b>Sammanställning Eniroadresser
</b>  <br>
- jag har lagt några medlemmar från herrljunga distrikten som skulle postas i V (Valfri)<br>
- jag lägger alla utträden som tars bort via KP (KP synkronisering) administrerad i centralen i V (Valfri) med automatik<br>
- 2008-09-20 update 733_panel set medlem = 'X' where distrikt > 7020 and distrikt < 8600 and medlem = 'J';<br>
- 2008-09-20 update 733_panel set medlem = 'X' where distrikt > 8705 and distrikt < 9601 and medlem = 'J';<br>
- 2008-09-20 update 733_panel set medlem = 'X' where distrikt > 9703 and distrikt < 9999 and medlem = 'J';<br>
<table width="777" border="0">
  <tr>
    <td>#</td>
    <td>Distrikt</td>
    <td>Medlemmar</td>
    <td>Vägran</td>
    <td>Eniroadresser</td>
    <td>Utträden</td>
    <td>V (Valfri)</td>
    <td>X (Valfri)</td>
    <td>Y (Valfri)</td>
    <td>Saldo</td>
  </tr>
  <?
$max_new_member = MAX_NEW_MEMBER;

$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
or die ('Cannot connect to the database: ' . mysql_error());
mysql_select_db ("quicotse_bill");

$query = "SELECT t1.distrikt as distrikt,
count( t2.medlem ) AS Ja,
count( t3.medlem ) AS Nej,
count( t4.medlem ) AS Ny,
count( t5.medlem ) AS Uttr,
count( t6.medlem ) AS Valfri_V,
count( t7.medlem ) AS Valfri_X,
count( t8.medlem ) AS Valfri_Y
FROM ".$xsite."_panel t1
LEFT JOIN ".$xsite."_panel t2 ON t1.telefon = t2.telefon
AND t2.medlem = 'J'
LEFT JOIN ".$xsite."_panel t3 ON t1.telefon = t3.telefon
AND t3.medlem = 'N'
LEFT JOIN ".$xsite."_panel t4 ON t1.telefon = t4.telefon
AND t4.medlem = 'E'
LEFT JOIN ".$xsite."_panel t5 ON t1.telefon = t5.telefon
AND t5.medlem = 'U'
LEFT JOIN ".$xsite."_panel t6 ON t1.telefon = t6.telefon
AND t6.medlem = 'V'
LEFT JOIN ".$xsite."_panel t7 ON t1.telefon = t7.telefon
AND t7.medlem = 'X'
LEFT JOIN ".$xsite."_panel t8 ON t1.telefon = t8.telefon
AND t8.medlem = 'Y'
GROUP BY t1.distrikt
ORDER BY t1.distrikt;";
$result = mysql_query($query) or die("Cannot get data from the database:"  . mysql_error());

$count = 1;
while($row = mysql_fetch_assoc($result)) {

	$saldo = $row['Ja'] - $max_new_member + $row['Ny'];
	echo "<tr><td>" . $count ."</td>
	<td>" . $row['distrikt'] ."</td>
	<td><a href=panelmedlemmar2.php?status=J&distrikt=" . $row['distrikt'] . ">" . $row['Ja'] ."</a></td>
	<td>" . $row['Nej'] ."</td>
	<td><a href=panelmedlemmar2.php?status=E&distrikt=" . $row['distrikt'] . ">" . $row['Ny'] ."</a></td>
	<td><a href=panelmedlemmar2.php?status=U&distrikt=" . $row['distrikt'] . ">" . $row['Uttr'] ."</a></td>
	<td><a href=panelmedlemmar2.php?status=V&distrikt=" . $row['distrikt'] . ">" . $row['Valfri_V'] ."</a></td>
	<td><a href=panelmedlemmar2.php?status=X&distrikt=" . $row['distrikt'] . ">" . $row['Valfri_X'] ."</a></td>
	<td><a href=panelmedlemmar2.php?status=Y&distrikt=" . $row['distrikt'] . ">" . $row['Valfri_Y'] ."</a></td>
	<td>" . $saldo . "</td>
	</tr>\n";

	$count++;

}


?>
</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../../includes/footer.php"); ?>