<?php
	
class Notifications extends CI_Controller {
	
	
	function Index(){
		$this->load->view('common/header', $this->d);
		$this->load->view('notifications/index', $this->d);
		$this->load->view('common/footer', $this->d);
	}
	
}