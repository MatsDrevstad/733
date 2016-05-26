<?php

include_once realpath(dirname(__FILE__)."/config.php");

function write_selected($name, $value) {
	if ($name == $value) {
		return "selected";
	}
}

function write_checked($name, $value) {
	if ($name == $value) {
		return "checked";
	}
}

function array_compare($op1, $op2) {
    if (count($op1) < count($op2)) {
        return -1; // $op1 < $op2
    } elseif (count($op1) > count($op2)) {
        return 1; // $op1 > $op2
    }
    foreach ($op1 as $key => $val) {
        if (!array_key_exists($key, $op2)) {
            return null; // uncomparable
        } elseif ($val < $op2[$key]) {
            return -1;
        } elseif ($val > $op2[$key]) {
            return 1;
        }
    }
    return 0; // $op1 == $op2
}

function get_time_difference( $start, $end )
{
    $uts['start']      =    strtotime( $start );
    $uts['end']        =    strtotime( $end );
    if( $uts['start']!==-1 && $uts['end']!==-1 )
    {
        if( $uts['end'] >= $uts['start'] )
        {
            $diff    =    $uts['end'] - $uts['start'];
            if( $days=intval((floor($diff/86400))) )
                $diff = $diff % 86400;
            if( $hours=intval((floor($diff/3600))) )
                $diff = $diff % 3600;
            if( $minutes=intval((floor($diff/60))) )
                $diff = $diff % 60;
            $diff    =    intval( $diff );
            return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
        }
        else
        {
            trigger_error( "Ending date/time is earlier than the start date/time", E_USER_WARNING );
        }
    }
    else
    {
        trigger_error( "Invalid date/time data detected", E_USER_WARNING );
    }
    return( false );
}


function is_leap_year($year) {
	if ((($year % 4) == 0 and ($year % 100)!=0) or ($year % 400) == 0) {
		return 1;
	}
	else {
		return 0;
	}
}

function iso_week_days($yday, $wday) {
	return $yday - (($yday - $wday + 382) % 7) + 3;
}


//	$timestamp: time()
//	$offset: antal dagar

function get_week_number($timestamp, $offset) {

	$timestamp = $timestamp + ($offset * 24 * 60 * 60);

	$d = getdate($timestamp);
	$days = iso_week_days($d["yday"], $d["wday"]);

	if ($days < 0) {
		$d[ "yday"] += 365 + is_leap_year(--$d["year"]);
		$days = iso_week_days($d["yday"], $d["wday"]);
	}
	else {
		$d["yday"] -= 365 + is_leap_year($d["year"]);
		$d2 = iso_week_days($d["yday"], $d["wday"]);
		if (0 <= $d2) {
			$days = $d2;
		}
	}

	$week = (int)($days / 7) + 1;

	$week = substr("0" . $week, strlen($week)-1);

	$today2 = getdate($timestamp);

	return $today2[year] . $week;

}

function get_veckodag($dag) {

	$veckodag = Array(
	'Söndag',
	'Måndag',
	'Tisdag',
	'Onsdag',
	'Torsdag',
	'Fredag',
	'Lördag');

	return $veckodag[$dag];
}

function get_kategori($k) {

	$k--;
	$kategori = Array(
	'Lägenhet',
	'Villa');

	return $kategori[$k];
}

function get_adressanswer($k) {

	$enarray = Array(
	'',
	'Ja, portkod eller liknande finns',
	'Nej, det är öppet',
	'Glömde fråga/fick inget svar'
	);

	return $enarray[$k];
}

function get_fold_name($n) {

	$fold = explode('/', $_SERVER['SCRIPT_NAME']);
	$folditem = $fold[1];
	$name = Array(
	$_SERVER['SERVER_NAME'] . "/" . $folditem,
	$folditem);

	return $name[$n];
}



?>
