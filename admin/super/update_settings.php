<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n
<meta http-equiv=refresh content=1;URL=settings.php>";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../../includes/header.php");
?>

<!-- page start -->
<?php

$filename = '../../includes/config.php';

$somecontent = "<?php\n
define('MSOFFICE', '" . $_POST['MSOFFICE']. "');\n
define('CSS', '" . $_POST['CSS']. "');\n
define('MIN_NEXTCALL', '" . $_POST['MIN_NEXTCALL']. "');\n
define('MAX_MEMBER', '" . $_POST['MAX_MEMBER']. "');\n
define('MAX_NEW_MEMBER', '" . $_POST['MAX_NEW_MEMBER']. "');\n
define('OFFSET_DAYS', '" . $_POST['OFFSET_DAYS']. "');\n
define('FLATS_ONLY', '" . $_POST['FLATS_ONLY']. "');\n
define('RESET_ANSWER', '" . $_POST['RESET_ANSWER']. "');\n
define('SHOW_EDITION', '" . $_POST['SHOW_EDITION']. "');\n
define('ENIRO_MAX', '" . $_POST['ENIRO_MAX']. "');\n
define('CALL_REPORTED_ONLY', '" . $_POST['CALL_REPORTED_ONLY']. "');\n
define('MISSION', '" . $_POST['MISSION']. "');\n
define('DAYDIFF', '" . $_POST['DAYDIFF']. "');\n
define('ACCEPTED_REPORT', '" . $_POST['ACCEPTED_REPORT']. "');\n
?>\n";

if (is_writable($filename)) {

    if (!$handle = fopen($filename, 'w')) {
         echo "Cannot open file ($filename)";
         exit;
    }

    if (fwrite($handle, $somecontent) === FALSE) {
        echo "Cannot write to file ($filename)";
        exit;
    }

    fclose($handle);

} else {
    echo "The file $filename is not writable";
}
?>

  <table width="100%" border="0">
    <tr valign="top">
      <td NOWRAP><br>
Sparar

    </td>
  </tr>
</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../../includes/footer.php"); ?>