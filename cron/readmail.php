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
$replacements[0] = 'Ö';
$replacements[1] = 'å';
$replacements[2] = 'ä';
$replacements[3] = 'ö';
$replacements[4] = '.';
$replacements[5] = 'é';
$replacements[6] = 'Å';
$replacements[7] = 'Ä';
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

	//OBS! OBS! OBS! OBS! OBS! OBS!!!!!!!!!!!!! nyårsbugg ev NYÅRSBUGG

	//vecka innehållr inte två siffror!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    $vecka = $year . substr($arbody[4], 20, 2);

    $tidklar =  "20" . substr($arbody[6], 15);

	//gör en liten test så att det inte kommer in några skräpmail
	//tas bort som vanligt isf
	if(preg_match("/^\d{6,6}$/i", $vecka) && preg_match("/^\d{4,4}$/i", $distrikt)) {

		$connection=mysql_connect ("localhost", "quicotse_drmurgu", "password")
		or die ('Cannot connect to the database: ' . mysql_error());
		mysql_select_db ("quicotse_bill");

		//ta reda på vilken rad det står enbart Överex: om det inte finns nån rad sätt radstopp = 25
		//läs in rad 8 till radstopp-1 till en sträng
		$ilastrow = 25;

		$imessage = '';

		for ($p = 8; $p <= $ilastrow; $p++) {

			$strbody = preg_replace($patterns, $replacements, $arbody[$p]);

			if(strcmp($strbody, "Överex:") == 0) {
				break;
			}
			else {
				$imessage = $imessage . $strbody . "<BR>";
			}
		}

		//om övrigt > 22 tecken peta in den i db.
		if (strlen($arbody[8]) > 22) {

			$query = "update " . $site . "_bokning set kommentar2 = '$imessage' where distrikt = '$distrikt'
			and vecka = '$vecka';";

			echo $query . "<br>";

			mysql_query($query)
			or die("Cannot get data from the database:"  . mysql_error());

		}

		//sätt bara tidklar före en viss veckodag, annars sätt sen rapport
		// $mytime, 1 sätter vi för att vi vill börja köra cron ¨på söndag redan
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
		// för att förhindra att gamla mail gör distrikt ringbara
		// _panel innehåller ju inga veckor på detta sättet.
		// approx -2 (tisdag) det är ju ingen som bryr sig om vilka som har rapporterat eller
		// ej på tisdag för att det ska vara ringbara i nån panel
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
