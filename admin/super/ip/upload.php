<!-- header -->

<?
$Meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
$Body = "";
$Title = "Quickfoot";
include_once realpath(dirname(__FILE__)."/../../../includes/header.php");
?>

<!-- page start -->
<?php
// In PHP versions earlier than 4.1.0, $HTTP_POST_FILES should be used instead
// of $_FILES.

$uploaddir = './uploads/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

if(!preg_match("/^\S{1,50}.csv$/i", $_FILES['userfile']['name'])){
  exit("You cannot upload this type of file.");
}

echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
   echo "File is valid, and was successfully uploaded.\n";
} else {
   echo "Possible file upload attack!\n";
}

echo 'Here is some more debugging info:';
print_r($_FILES);

print "</pre>";

?> <a href=uploads/fileread.php?filename=<? echo $_FILES['userfile']['name'] ?>>Kolla
vad som finns i filen</a>
<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../../../includes/footer.php"); ?>
