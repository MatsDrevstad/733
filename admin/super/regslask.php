<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../../includes/header.php");
?>

<!-- page start -->
<table width="999" border="0">
<?

$ret = array('A','B','C','D','E','F','G','H','I','J','L','M','N','O','P','R','S','T','U','V','X','Y','Z');

for ($i = 0; $i<1000; $i++) {
	$a = (int) rand(1,23);
	echo $ret[$a]."<br>";
}

?>
</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../../includes/footer.php"); ?>