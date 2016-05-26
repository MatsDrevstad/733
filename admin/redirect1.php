<?php
setcookie("order", $_GET["order"], time()+86400);
header('Location: matris1.php?vecka=' . $_GET["vecka"]) ;
?>
<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../includes/header.php");
?>

<!-- page start -->

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../includes/footer.php"); ?>