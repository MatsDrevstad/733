<?
include_once realpath(dirname(__FILE__)."/config.php");
include_once realpath(dirname(__FILE__)."/functions.php");
$mytime = time() + (DAYDIFF * 24 * 60 * 60);
$today = getdate($mytime);
$week1 = substr(get_week_number($mytime, 0), 4);
$week2 = get_week_number($mytime, -OFFSET_DAYS);
$css = CSS;
$op = $_SERVER['REMOTE_USER'];
$mynow = sprintf("%04d-%02d-%02d", $today[year], $today[mon], $today[mday]);
$xsite = get_fold_name(1);
?>
<html>
<head>
<title><? echo $Title ?></title>
<? echo $Meta ?>
<link rel="stylesheet" type="text/css" href="/<? echo get_fold_name(1)?>/includes/<? echo CSS ?>">
</head>

<body <? echo $Body ?>>

<table width=100%>
  <tr>
    <td width="11%" height="66"><b><? echo $op?> @ <? echo $xsite?></b></td>
    <td width="25%" height="66"><b><? echo get_veckodag($today['wday']) . "en " . $mynow?> vecka <? echo $week1 ?></b></td>
    <td width="11%"><a href="http://<? echo get_fold_name(0)?>/">Hem</a></td>
    <td width="11%"></a><a href=http://<? echo get_fold_name(0)?>/list.php>Panel</a><br><a href="http://<? echo get_fold_name(0)?>/list3.php">Eniroadresser</a></td>
    <td width="11%"><a href="http://<? echo get_fold_name(0)?>/admin/matris1.php?vecka=<? echo $week2 ?>">Matris</a></td>
    <td width="11%"><a href="http://<? echo get_fold_name(0)?>/admin/">Admin</a></td>
  </tr>
</table>

<table width=100%>
  <tr>
    <td height="5" class=copybackground></td>
  </tr>
</table>