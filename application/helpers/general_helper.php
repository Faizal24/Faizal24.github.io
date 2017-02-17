<?php
	
function class_name($string){
	
	$string = str_replace('(', '', trim($string));
	$string = str_replace(')', '', trim($string));
	$string = str_replace(' ', '-', trim($string));
	
	return $string;
}

function reformat_date($date){
	list($day, $month, $year) = explode('/', $date);
	return $year . '-' . $month . '-' . $day;
}

function hide_chars($string){
	$string = trim($string);
	for ($i = 0; $i < strlen($string); $i++){
		if ($i < 8 && $string[$i] != ' ' && is_numeric($string[$i])){
			$newstring .= 'X';
		} else {
			$newstring .= $string[$i];
		}

	}
	return  $newstring;
}

function and_filter($array){
	return count($array) ? ' WHERE ' . implode(' AND ', $array) : ''; 
}

function truncate($string, $limit){
	$string = trim($string);
	return substr($string, 0, $limit) . '...';
}

function _uimg($user){
	return '<div class="medium-profile-photo" style="background-image: url(\'uploads/profile/'.$user->photo.'\')"></div>';
}

function Ajax_submit_successful($data){
	echo '<script language="javascript" type="text/javascript">';
	echo 'window.top.window.base.formSubmitted(1,'.json_encode($data).')';
	echo '</script>';
	die();
}
	
function Ajax_submit_unsuccessful($error){
	echo '<script language="javascript" type="text/javascript">';
	echo 'window.top.window.base.formSubmitted(0,"'.$error.'")';
	echo '</script>';
	die();

}
	
	
function Ajax_redirect($uri){
	echo '<script language="javascript" type="text/javascript">';
	echo 'window.top.window.base.go("'.$uri.'")';
	echo '</script>';
	die();
		
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
