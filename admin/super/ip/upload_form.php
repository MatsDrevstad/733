<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../../../includes/header.php");
?>

<!-- page start -->
<!-- The data encoding type, enctype, MUST be specified as below -->
<form enctype="multipart/form-data" action="upload.php" method="POST">
    <!-- MAX_FILE_SIZE must precede the file input field -->
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    <!-- Name of input element determines name in $_FILES array -->
    <input name="userfile" type="file" />
    <input type="submit" value="Skicka" />
</form>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../../../includes/footer.php"); ?>
