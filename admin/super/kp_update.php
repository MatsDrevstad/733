<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../../includes/header.php");
?>

<!-- page start -->
<p><b>
  Klistra in och spara</b></p>
<form name="form1" method="post" action="kp_save.php" >
  <p>
    <textarea name="distrikt" cols="99" rows="22" wrap="PHYSICAL"></textarea>
  </p>
  <p>
    <input type="submit" name="Submit" value="Submit">
  </p>
</form>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../../includes/footer.php"); ?>


