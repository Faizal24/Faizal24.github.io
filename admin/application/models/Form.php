<?php
	
class Form extends CI_Model {
	
	
	function Submit_successful($data){
		echo '<script language="javascript" type="text/javascript">';
		echo 'window.top.window.base.formSubmitted(1,'.json_encode($data).')';
		echo '</script>';
		die();
	}
	
	function Submit_unsuccessful($error){
		echo '<script language="javascript" type="text/javascript">';
		echo 'window.top.window.base.formSubmitted(0,"'.$error.'")';
		echo '</script>';
		die();

	}
	
	function Redirect($uri){
		echo '<script language="javascript" type="text/javascript">';
		echo 'window.top.window.base.go("'.$uri.'")';
		echo '</script>';
		die();
		
	}
	
}