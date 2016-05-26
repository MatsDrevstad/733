<?php
require ('pop3.class.php');
include_once realpath(dirname(__FILE__)."/../includes/header.php");

$pop3 = new POP3;

// Connect to mail server
$do = $pop3->connect ('mail.quickfoot.se');
if ($do == false) {
    die($pop3->error);
}

// Login to your inbox
$do = $pop3->login ($xsite.'+quickfoot.se', 'nsjnj07');

if ($do == false) {
    die($pop3->error);
}

// Get office status
$status = $pop3->get_office_status();

if ($status == false) {
    die($pop3->error);
}

$count = $status['count_mails'];

if ($count == '0') {
    echo 'There are no new e-mails';
}

$patterns[0] = '/=D6/';
$patterns[1] = '/=E5/';
$patterns[2] = '/=E4/';
$patterns[3] = '/=F6/';
$patterns[4] = '/=2E/';
$patterns[5] = '/=E9/';
$patterns[6] = '/=C5/';
$patterns[7] = '/=C4/';
$patterns[8] = '/=/';
$patterns[9] = '/\'/';
$replacements[0] = '�';
$replacements[1] = '�';
$replacements[2] = '�';
$replacements[3] = '�';
$replacements[4] = '.';
$replacements[5] = '�';
$replacements[6] = '�';
$replacements[7] = '�';
$replacements[8] = ' ';
$replacements[9] = '';

for ($i = 1; $i <= $count; $i++) {
    $email = $pop3->get_mail($i);

    if ($email == false) {
        echo $pop3->error;
        continue;
    }

    $email = parse_email ($email);

//    echo '<b>From: </b>' . htmlentities($email['headers']['From']) . '<br />';
//    echo '<b>Subject: </b>' . htmlentities($email['headers']['Subject']) . '<br /><br />';
//    echo $email['message'];
//    echo '<hr />';

	$arbody = explode(chr(13).chr(10),$email['message']);

    $site = substr($arbody[2], 15, 3);
    $distrikt = substr($arbody[3], 15, 4);
    $year = substr($arbody[4], 15, 4);

	//OBS! OBS! OBS! OBS! OBS! OBS!!!!!!!!!!!!! ny�rsbugg ev NY�RSBUGG

	//vecka inneh�llr inte tv� siffror!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    $vecka = $year . substr($arbody[4], 20, 2);

    $tidklar =  "20" . substr($arbody[6], 15);

	//g�r en liten test s� att det inte kommer in n�gra skr�pmail
	//tas bort som vanligt isf
	if(preg_match("/^\d{6,6}$/i", $vecka) && preg_match("/^\d{4,4}$/i", $distrikt)) {

		$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
		or die ('Cannot connect to the database: ' . mysql_error());
		mysql_select_db ("quicotse_bill");

		//ta reda p� vilken rad det st�r enbart �verex: om det inte finns n�n rad s�tt radstopp = 25
		//l�s in rad 8 till radstopp-1 till en str�ng
		$ilastrow = 25;

		$imessage = '';

		for ($p = 8; $p <= $ilastrow; $p++) {

			$strbody = preg_replace($patterns, $replacements, $arbody[$p]);

			if(strcmp($strbody, "�verex:") == 0) {
				break;
			}
			else {
				$imessage = $imessage . $strbody . "<BR>";
			}
		}

		//om �vrigt > 22 tecken peta in den i db.
		if (strlen($arbody[8]) > 22) {

			$query = "update " . $site . "_bokning set kommentar2 = '$imessage' where distrikt = '$distrikt'
			and vecka = '$vecka';";

			echo $query . "<br>";

			mysql_query($query)
			or die("Cannot get data from the database:"  . mysql_error());

		}

		//s�tt bara tidklar f�re en viss veckodag, annars s�tt sen rapport
		// $mytime, 1 s�tter vi f�r att vi vill b�rja k�ra cron �p� s�ndag redan
		if (get_week_number($mytime, -ACCEPTED_REPORT) < get_week_number($mytime, 1)) {

			$query = "update " . $site . "_bokning set tidklar = '$tidklar' where distrikt = '$distrikt'
			and vecka = '$vecka';";
		}
		else {

			$query = "update " . $site . "_bokning set tidklar = 'Sen rapport' where distrikt = '$distrikt'
			and vecka = '$vecka';";
		}

//			echo $query . "<br>";

			mysql_query($query)
			or die("Cannot get data from the database:"  . mysql_error());

		// rapporterad avser alltid samma vecka som den aktuella rapporteringsveckan.
		// f�r att f�rhindra att gamla mail g�r distrikt ringbara
		// _panel inneh�ller ju inga veckor p� detta s�ttet.
		// approx -2 (tisdag) det �r ju ingen som bryr sig om vilka som har rapporterat eller
		// ej p� tisdag f�r att det ska vara ringbara i n�n panel
		if (get_week_number($mytime, -2) == $vecka) {

			$query = "update " . $site . "_panel set rapporterad = 1 where distrikt = '$distrikt';";

//			echo $query . "<br>";

			mysql_query($query)
			or die("Cannot get data from the database:"  . mysql_error());

		}

		mysql_close($connection);

	}

    // TODO: store the e-mail in a database or on the HDD

    // Remove from mail server
    $do = $pop3->delete_mail ($i);
    if ($do == false) {
        echo $pop3->error;
    }
}

$pop3->close();

function parse_email ($email) {
    // Split header and message
    $header = array();
    $message = array();

    $is_header = true;
    foreach ($email as $line) {
        if ($line == '<HEADER> ' . "\r\n") continue;
        if ($line == '<MESSAGE> ' . "\r\n") continue;
        if ($line == '</MESSAGE> ' . "\r\n") continue;
        if ($line == '</HEADER> ' . "\r\n") { $is_header = false; continue; }

        if ($is_header == true) {
            $header[] = $line;
        } else {
            $message[] = $line;
        }
    }

    // Parse headers
    $headers = array();
    foreach ($header as $line) {
        $colon_pos = strpos($line, ':');
        $space_pos = strpos($line, ' ');

        if ($colon_pos === false OR $space_pos < $colon_pos) {
            // attach to previous
            $previous .= "\r\n" . $line;
            continue;
        }

        // Get key
        $key = substr($line, 0, $colon_pos);

        // Get value
        $value = substr($line, $colon_pos+2);
        $headers[$key] = $value;

        $previous =& $headers[$key];
    }

    // Parse message
    $message = implode('', $message);

    // Return array
    $email = array();
    $email['message'] = $message;
    $email['headers'] = $headers;

    return $email;
}

?>
