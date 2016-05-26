<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../includes/header.php");
?>

<!-- page start -->
<h3><b><? echo $_GET['karta'] ?><br>
  </b><a href="z:\imgs\k<? echo $xsite ?><? echo $_GET['karta'] ?>.jpg"><img src="z:\imgs\k<? echo $xsite ?><? echo $_GET['karta'] ?>.jpg" height="444" border="0"></a>
</h3>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../includes/footer.php"); ?>

