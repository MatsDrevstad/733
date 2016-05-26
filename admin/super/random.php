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

$min = $_GET['min'];
$max = $_GET['max'];
$num = $_GET['num'];

if (is_null($min) or is_null($max or is_null($num))) {
	echo "ange min, max, num (generate an array of num numbers between min and max";
}
else {

/*
I needed to generate a random array of different(!) numbers, i.e. no number in the array should be duplicated. I used the nice functions from phpdeveloper AT o2 DOT pl but it didn't work as I thought.

So I varied it a little bit and here you are:

*/

function RandomArray($min,$max,$num) {

	$ret = array();

	while (count($ret) <$num) {
	   do {
	       $a = rand($min,$max);
	   }
	   while (in_array($a,$ret));
	   $ret[] = $a;
	}
	return($ret);
}

$ret = randomArray($min,$max,$num);

$nmax = $max - $min;

for ($i = 0; $i<$nmax+1; $i++) {
	echo $ret[$i]."<br>";
}

}

?>
</table>

<!-- footer -->
<? include_once realpath(dirname(__FILE__)."/../../includes/footer.php"); ?>