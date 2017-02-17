<?php
	
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		
	
		$this->user->logout();
	
		redirect();
	}
	
	function Index(){
		// do nothing
	}
	
}