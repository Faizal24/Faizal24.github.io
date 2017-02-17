<?php

function date_reformat($dmy_date){
	list($dmy_date, $time) = explode(' ', $dmy_date);
	list($day,$month,$year) = explode('/',$dmy_date);
	$his = date('H:i:s',strtotime($time));
	
	if (!$dmy_date) return NULL;
	
	return $year . '-' . $month . '-' . $day . ' ' . $his;
}

function truncate($string, $limit){
	if (strlen($string) < $limit) return $string;
	else {
		for ($i = 0; $i < $limit; $i++){
			$new_string .= $string[$i];
		}
		return $new_string . '...';
	}
}

function profile_photo($user){
	
}

function makeClickableLinks($s) {
	return preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.%-=#]*(\?\S+)?)?)?)@', '<a target="_blank" href="$1">$1</a>', $s);
}

function make_array_from_values($data, $field){
	
	if (!$field) $field = 'value';
	foreach ($data as $row){
		$array[$row->$field] = $row->$field;
	}
	
	return $array;
}


function ago($time){
	$periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
	$lengths = array("60","60","24","7","4.35","12","10");

	$now = time();

	$difference     = $now - $time;
	$tense         = "ago";

	for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
		$difference /= $lengths[$j];
	}

	$difference = round($difference);

	if($difference != 1) {
		$periods[$j].= "s";
	}
	
	if (($periods[$j] == 'seconds' || $periods[$j] == 'second')  && $difference < 30) return "Just now";

	return "$difference $periods[$j] ago";
}


function object_to_array($d) {
	if (is_object($d)) {
		// Gets the properties of the given object
		// with get_object_vars function
		$d = get_object_vars($d);
	}

	if (is_array($d)) {
		/*
		* Return array converted to object
		* Using __FUNCTION__ (Magic constant)
		* for recursive call
		*/
		return array_map(__FUNCTION__, $d);
	} else {
		// Return array
		return $d;
	}
}

function underscore($string){
	$string = str_replace(' ', '_', $string);
	$string = str_replace('/', '_', $string);
	return $string;
}

function generate_pallete($n){
	$green	= [0,255,0];
	$yellow = [255,255,0];
	$red 	= [255,0,0];
	$blue	= [0,0,255];
	
	
	
}


function classname($str){
	$str = strtolower($str);
	$str = str_replace(' ', '-', $str);
	
	return $str;
}